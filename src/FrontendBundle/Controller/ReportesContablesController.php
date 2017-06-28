<?php
namespace FrontendBundle\Controller;

use BackendBundle\Entity\Account;
use BackendBundle\Entity\AccountantMove;
use BackendBundle\Entity\Company;
use BackendBundle\Entity\Operations;
use BackendBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TCPDF;
use UserBundle\Entity\User;

/**
 * Reportes controller.
 *
 * @Route("reportes-contables/{id}")
 */
class ReportesContablesController extends Controller {
  /**
   * @Route("/", name="reportesContables")
   */
  public function indexAction(Company $company) {
    $breadcrumb[] = array(
      'name' => 'Inicio',
      'url' => $this->container->get('router')->generate('plataformaEducativa'),
    );
    return $this->render('FrontendBundle:ReportesContables:index.html.twig', array(
      'breadcrumb' => $breadcrumb,
      'empresa' => $company,
      'close' => $this->container->get('router')->generate('empresa_ver', array('id' => $company->getId())),
    ));
  }

  /**
   * @Route("/libro-diario", name="librodiario")
   */
  public function libroDiario(Request $request, Company $company) {
    $l = Array();

    // PAGE META DESCRIPTORS --------------------------------------

    $l['a_meta_charset'] = 'UTF-8';
    $l['a_meta_dir'] = 'ltr';
    $l['a_meta_language'] = 'en';

    // TRANSLATIONS --------------------------------------
    $l['w_page'] = 'page';

    $desde = $request->get('desde');
    $hasta = $request->get('hasta');
    $em = $this->getDoctrine()->getManager();
    $asientosAll = $em->getRepository('BackendBundle:AccountantMove')->findBy(array(
      'companyId' => $company,
    ));
    $asientos = array();
    foreach ($asientosAll as $item) {
      if ($desde <= $item->getDate()->format('Y-m-d') && $hasta >= $item->getDate()->format('Y-m-d')) {
        $asientos[] = $item;
      }
    }
    $html = $this->render('FrontendBundle:ReportesContables:libroDiario.html.twig', array(
      'asientos' => $asientos,
      'desde' => $desde,
      'hasta' => $hasta,
      'company' => $company,
    ));

    $stringHTML = $html->getContent();
    $hederTitle = "KK";

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    //$pdf->SetCreator(PDF_CREATOR);
    //$pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('Libro Diario');
    //$pdf->SetSubject('TCPDF Tutorial');
    //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    $now = new \DateTime('now');
    // set default header data
    $pdf->SetHeaderData('', 130, "Fecha:" . $now->format('d/m/Y'));

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $pdf->setLanguageArray($l);

    $pdf->SetFont('helvetica', '', 10);

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML($stringHTML, true, false, true, false, '');

    $pdf->lastPage();

    $response = new Response($pdf->Output($hederTitle . '.pdf', 'I'), 200, array('Content-Type' => 'application/pdf'));
    return $response;
  }

  /**
   * @Route("/balance-comprobacion", name="balanceComprobacion")
   */
  public function balanceComprobacion(Request $request, Company $company) {
    $l = Array();

    // PAGE META DESCRIPTORS --------------------------------------

    $l['a_meta_charset'] = 'UTF-8';
    $l['a_meta_dir'] = 'ltr';
    $l['a_meta_language'] = 'en';

    // TRANSLATIONS --------------------------------------
    $l['w_page'] = 'page';

    $desde = $request->get('desde');
    $hasta = $request->get('hasta');
    $em = $this->getDoctrine()->getManager();
    $asientosAll = $em->getRepository('BackendBundle:AccountantMove')->findBy(array(
      'companyId' => $company,
    ));
    $asientos = array();
    foreach ($asientosAll as $item) {
      /** @var AccountantMove $item */
      if ($desde <= $item->getDate()->format('Y-m-d') && $hasta >= $item->getDate()->format('Y-m-d')) {
        foreach ($item->getOperations() as $operation) {
          /** @var Operations $operation */
          if (!empty($operation->getAccountId())) {
            if (isset($asientos[$operation->getAccountId()->getId()]['debe'])) {
              $asientos[$operation->getAccountId()->getId()]['debe'] += $operation->getDeve();
              $asientos[$operation->getAccountId()->getId()]['haber'] += $operation->getHaber();
            }
            else {
              $asientos[$operation->getAccountId()->getId()]['debe'] = $operation->getDeve();
              $asientos[$operation->getAccountId()->getId()]['haber'] = $operation->getHaber();
            }
          }
        }
      }
    }
    $cuentasAll = $em->getRepository('BackendBundle:Account')->findBy(array(
      'companyId' => $company,
    ));
    foreach ($cuentasAll as &$cuenta) {
      /** @var Account $cuenta */
      if (isset($asientos[$cuenta->getId()])) {
        $cuenta->{'debe'} = $asientos[$cuenta->getId()]['debe'];
        $cuenta->{'haber'} = $asientos[$cuenta->getId()]['haber'];
      }
      else {
        $cuenta->{'debe'} = 0;
        $cuenta->{'haber'} = 0;
      }
    }
    $order = $this->orderString($cuentasAll);
    $codes = [];
    $fathers = $this->getFathers($cuentasAll, $codes);
    $cuentas = array();
    foreach ($order as $item) {
      $cuentaAux = $cuentasAll[$item['index']];
      if (in_array($cuentaAux->getCode(), $codes)) {
        $debe = 0;
        $credito = 0;
        $childrens = $this->getChildrens($cuentaAux->getCode() . "", $cuentasAll);
        foreach ($childrens as $children) {
          $debe += $children->debe;
          $credito += $children->haber;
        }
        $cuentaAux->debe = $debe;
        $cuentaAux->haber = $credito;
      }
      $cuentas[] = $cuentaAux;
    }
    $html = $this->render('FrontendBundle:ReportesContables:balanceComprobacion.html.twig', array(
      'cuentas' => $cuentas,
      'desde' => $desde,
      'hasta' => $hasta,
      'company' => $company,
    ));

    $stringHTML = $html->getContent();
    $hederTitle = "KK";

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    //$pdf->SetCreator(PDF_CREATOR);
    //$pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('Balance de Comprobación');
    //$pdf->SetSubject('TCPDF Tutorial');
    //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    $now = new \DateTime('now');
    // set default header data
    $pdf->SetHeaderData('', 130, "Fecha:" . $now->format('d/m/Y'));

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $pdf->setLanguageArray($l);

    $pdf->SetFont('helvetica', '', 10);

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML($stringHTML, true, false, true, false, '');

    $pdf->lastPage();

    $response = new Response($pdf->Output($hederTitle . '.pdf', 'I'), 200, array('Content-Type' => 'application/pdf'));
    return $response;
  }

  /**
   * @Route("/estado-resultados", name="estadoResultados")
   */
  public function estadoResultados(Request $request, Company $company) {
    $l = Array();

    // PAGE META DESCRIPTORS --------------------------------------

    $l['a_meta_charset'] = 'UTF-8';
    $l['a_meta_dir'] = 'ltr';
    $l['a_meta_language'] = 'en';

    // TRANSLATIONS --------------------------------------
    $l['w_page'] = 'page';

    $desde = $request->get('desde');
    $hasta = $request->get('hasta');
    $em = $this->getDoctrine()->getManager();

    $cuentasAll = $em->getRepository('BackendBundle:Account')->findBy(array(
      'companyId' => $company,
    ));

    $asientosAll = $em->getRepository('BackendBundle:AccountantMove')->findBy(array(
      'companyId' => $company,
    ));

    $asientos = array();
    foreach ($asientosAll as $item) {
      /** @var AccountantMove $item */
      if ($desde <= $item->getDate()->format('Y-m-d') && $hasta >= $item->getDate()->format('Y-m-d')) {
        foreach ($item->getOperations() as $operation) {
          /** @var Operations $operation */
          if (!empty($operation->getAccountId())) {
            if (isset($asientos[$operation->getAccountId()->getId()]['debe'])) {
              $asientos[$operation->getAccountId()->getId()]['debe'] += $operation->getDeve();
              $asientos[$operation->getAccountId()->getId()]['haber'] += $operation->getHaber();
            }
            else {
              $asientos[$operation->getAccountId()->getId()]['debe'] = $operation->getDeve();
              $asientos[$operation->getAccountId()->getId()]['haber'] = $operation->getHaber();
            }
          }
        }
      }
    }
    $cuentasAll = $em->getRepository('BackendBundle:Account')->findBy(array(
      'companyId' => $company,
    ));
    foreach ($cuentasAll as &$cuenta) {
      /** @var Account $cuenta */
      if (isset($asientos[$cuenta->getId()])) {
        $cuenta->{'debe'} = $asientos[$cuenta->getId()]['debe'];
        $cuenta->{'haber'} = $asientos[$cuenta->getId()]['haber'];
      }
      else {
        $cuenta->{'debe'} = 0;
        $cuenta->{'haber'} = 0;
      }
    }
    $order = $this->orderString($cuentasAll);
    $codes = [];
    $fathers = $this->getFathers($cuentasAll, $codes);
    $cuentas = array();
    foreach ($order as $item) {
      $cuentaAux = $cuentasAll[$item['index']];
      if ($this->isEstado($cuentaAux->getCode())) {
        if (in_array($cuentaAux->getCode(), $codes)) {
          $debe = 0;
          $credito = 0;
          $childrens = $this->getChildrens($cuentaAux->getCode() . "", $cuentasAll);
          foreach ($childrens as $children) {
            $debe += $children->debe;
            $credito += $children->haber;
          }
          $cuentaAux->debe = $debe;
          $cuentaAux->haber = $credito;
        }
        $cuentas[] = $cuentaAux;
      }
    }

    $html = $this->render('FrontendBundle:ReportesContables:estadoResultados.html.twig', array(
      'cuentas' => $cuentas,
      'desde' => $desde,
      'hasta' => $hasta,
      'company' => $company,
    ));

    $stringHTML = $html->getContent();
    $hederTitle = "KK";

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    //$pdf->SetCreator(PDF_CREATOR);
    //$pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('Estado de Resultados');
    //$pdf->SetSubject('TCPDF Tutorial');
    //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    $now = new \DateTime('now');
    // set default header data
    $pdf->SetHeaderData('', 130, "Fecha:" . $now->format('d/m/Y'));

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $pdf->setLanguageArray($l);

    $pdf->SetFont('helvetica', '', 10);

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML($stringHTML, true, false, true, false, '');

    $pdf->lastPage();

    $response = new Response($pdf->Output($hederTitle . '.pdf', 'I'), 200, array('Content-Type' => 'application/pdf'));
    return $response;
  }

  /**
   * @Route("/estado-situacion", name="estadoSituacion")
   */
  public function estadoSituacion(Request $request, Company $company) {
    $l = Array();

    // PAGE META DESCRIPTORS --------------------------------------

    $l['a_meta_charset'] = 'UTF-8';
    $l['a_meta_dir'] = 'ltr';
    $l['a_meta_language'] = 'en';

    // TRANSLATIONS --------------------------------------
    $l['w_page'] = 'page';

    $desde = $request->get('desde');
    $hasta = $request->get('hasta');
    $em = $this->getDoctrine()->getManager();

    $cuentasAll = $em->getRepository('BackendBundle:Account')->findBy(array(
      'companyId' => $company,
    ));

    $asientosAll = $em->getRepository('BackendBundle:AccountantMove')->findBy(array(
      'companyId' => $company,
    ));

    $asientos = array();
    foreach ($asientosAll as $item) {
      /** @var AccountantMove $item */
      if ($desde <= $item->getDate()->format('Y-m-d') && $hasta >= $item->getDate()->format('Y-m-d')) {
        foreach ($item->getOperations() as $operation) {
          /** @var Operations $operation */
          if (!empty($operation->getAccountId())) {
            if (isset($asientos[$operation->getAccountId()->getId()]['debe'])) {
              $asientos[$operation->getAccountId()->getId()]['debe'] += $operation->getDeve();
              $asientos[$operation->getAccountId()->getId()]['haber'] += $operation->getHaber();
            }
            else {
              $asientos[$operation->getAccountId()->getId()]['debe'] = $operation->getDeve();
              $asientos[$operation->getAccountId()->getId()]['haber'] = $operation->getHaber();
            }
          }
        }
      }
    }
    $cuentasAll = $em->getRepository('BackendBundle:Account')->findBy(array(
      'companyId' => $company,
    ));
    foreach ($cuentasAll as &$cuenta) {
      /** @var Account $cuenta */
      if (isset($asientos[$cuenta->getId()])) {
        $cuenta->{'debe'} = $asientos[$cuenta->getId()]['debe'];
        $cuenta->{'haber'} = $asientos[$cuenta->getId()]['haber'];
      }
      else {
        $cuenta->{'debe'} = 0;
        $cuenta->{'haber'} = 0;
      }
    }
    $order = $this->orderString($cuentasAll);
    $codes = [];
    $fathers = $this->getFathers($cuentasAll, $codes);
    $cuentas = array();
    foreach ($order as $item) {
      $cuentaAux = $cuentasAll[$item['index']];
      if ($this->isEstadoSituacion($cuentaAux->getCode())) {
        if (in_array($cuentaAux->getCode(), $codes)) {
          $debe = 0;
          $credito = 0;
          $childrens = $this->getChildrens($cuentaAux->getCode() . "", $cuentasAll);
          foreach ($childrens as $children) {
            $debe += $children->debe;
            $credito += $children->haber;
          }
          $cuentaAux->debe = $debe;
          $cuentaAux->haber = $credito;
        }
        $cuentas[] = $cuentaAux;
      }
    }

    $html = $this->render('FrontendBundle:ReportesContables:estadoSituacion.html.twig', array(
      'cuentas' => $cuentas,
      'desde' => $desde,
      'hasta' => $hasta,
      'company' => $company,
    ));

    $stringHTML = $html->getContent();
    $hederTitle = "KK";

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    //$pdf->SetCreator(PDF_CREATOR);
    //$pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('Estado de Situación');
    //$pdf->SetSubject('TCPDF Tutorial');
    //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    $now = new \DateTime('now');
    // set default header data
    $pdf->SetHeaderData('', 130, "Fecha:" . $now->format('d/m/Y'));

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $pdf->setLanguageArray($l);

    $pdf->SetFont('helvetica', '', 10);

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML($stringHTML, true, false, true, false, '');

    $pdf->lastPage();

    $response = new Response($pdf->Output($hederTitle . '.pdf', 'I'), 200, array('Content-Type' => 'application/pdf'));
    return $response;
  }

  /**
   * @Route("/plan-cuentas", name="planCuentas")
   */
  public function planCuentas(Request $request, Company $company) {
    $l = Array();

    // PAGE META DESCRIPTORS --------------------------------------

    $l['a_meta_charset'] = 'UTF-8';
    $l['a_meta_dir'] = 'ltr';
    $l['a_meta_language'] = 'en';

    // TRANSLATIONS --------------------------------------
    $l['w_page'] = 'page';

    $desde = $request->get('desde');
    $hasta = $request->get('hasta');
    $em = $this->getDoctrine()->getManager();
    $asientosAll = $em->getRepository('BackendBundle:AccountantMove')->findBy(array(
      'companyId' => $company,
    ));
    $asientos = array();
    foreach ($asientosAll as $item) {
      /** @var AccountantMove $item */
      if ($desde <= $item->getDate()->format('Y-m-d') && $hasta >= $item->getDate()->format('Y-m-d')) {
        foreach ($item->getOperations() as $operation) {
          /** @var Operations $operation */
          if (!empty($operation->getAccountId())) {
            if (isset($asientos[$operation->getAccountId()->getId()]['debe'])) {
              $asientos[$operation->getAccountId()->getId()]['debe'] += $operation->getDeve();
              $asientos[$operation->getAccountId()->getId()]['haber'] += $operation->getHaber();
            }
            else {
              $asientos[$operation->getAccountId()->getId()]['debe'] = $operation->getDeve();
              $asientos[$operation->getAccountId()->getId()]['haber'] = $operation->getHaber();
            }
          }
        }
      }
    }
    $cuentasAll = $em->getRepository('BackendBundle:Account')->findBy(array(
      'companyId' => $company,
    ));
    foreach ($cuentasAll as &$cuenta) {
      /** @var Account $cuenta */
      if (isset($asientos[$cuenta->getId()])) {
        $cuenta->{'debe'} = $asientos[$cuenta->getId()]['debe'];
        $cuenta->{'haber'} = $asientos[$cuenta->getId()]['haber'];
      }
      else {
        $cuenta->{'debe'} = 0;
        $cuenta->{'haber'} = 0;
      }
    }
    $order = $this->orderString($cuentasAll);
    $codes = [];
    $fathers = $this->getFathers($cuentasAll, $codes);
    $cuentas = array();
    foreach ($order as $item) {
      $cuentaAux = $cuentasAll[$item['index']];
      if (in_array($cuentaAux->getCode(), $codes)) {
        $debe = 0;
        $credito = 0;
        $childrens = $this->getChildrens($cuentaAux->getCode() . "", $cuentasAll);
        foreach ($childrens as $children) {
          $debe += $children->debe;
          $credito += $children->haber;
        }
        $cuentaAux->debe = $debe;
        $cuentaAux->haber = $credito;
      }
      $cuentas[] = $cuentaAux;
    }
    $html = $this->render('FrontendBundle:ReportesContables:planCuentas.html.twig', array(
      'cuentas' => $cuentas,
      'desde' => $desde,
      'hasta' => $hasta,
      'company' => $company,
    ));

    $stringHTML = $html->getContent();
    $hederTitle = "KK";

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    //$pdf->SetCreator(PDF_CREATOR);
    //$pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('Plan de Cuentas');
    //$pdf->SetSubject('TCPDF Tutorial');
    //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    $now = new \DateTime('now');
    // set default header data
    $pdf->SetHeaderData('', 130, "Fecha:" . $now->format('d/m/Y'));

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $pdf->setLanguageArray($l);

    $pdf->SetFont('helvetica', '', 10);

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML($stringHTML, true, false, true, false, '');

    $pdf->lastPage();

    $response = new Response($pdf->Output($hederTitle . '.pdf', 'I'), 200, array('Content-Type' => 'application/pdf'));
    return $response;
  }

  function isEstado($code) {
    $code = $code . "";
    return $code[0] == 4 || $code[0] == 5 || $code[0] == 6;
  }

  function isEstadoSituacion($code) {
    $code = $code . "";
    return $code[0] == 1 || $code[0] == 2 || $code[0] == 3;
  }

  public function orderString($accounts) {
    $data = array();
    $maxLength = 0;
    foreach ($accounts as $account) {
      if ($maxLength < strlen($account->getCode())) {
        $maxLength = strlen($account->getCode());
      }
    }
    for ($i = 0; $i < count($accounts); $i++) {
      $code = $accounts[$i]->getCode();
      $multiplo = $maxLength - strlen($accounts[$i]->getCode()) ? pow(10, $maxLength - strlen($accounts[$i]->getCode())) : 1;
      $data[] = array(
        'code' => $multiplo != 1 ? $code * $multiplo : $code + 1,
        'index' => $i,
      );
    }
    sort($data);
    return $data;
  }

  public function getFathers($cuentasAll, &$codes) {
    $fathers = array();
    for ($i = 0; $i < count($cuentasAll); $i++) {
      $ok = true;
      for ($j = 0; $j < count($cuentasAll); $j++) {
        if ($cuentasAll[$i] != $cuentasAll[$j]) {
          if ($this->isFather($cuentasAll[$j]->getCode() . "", $cuentasAll[$i]->getCode() . "")) {
            $ok = false;
            break;
          }
        }
      }
      if ($ok) {
        $fathers[] = $cuentasAll[$i];
        $codes[] = $cuentasAll[$i]->getCode();
      }
    }
    return $fathers;
  }

  public function getChildrens($father, $cuentasAll) {
    $childrens = [];
    foreach ($cuentasAll as $item) {
      if ($this->isFather($father, $item->getCode() . "")) {
        $childrens[] = $item;
      }
    }
    return $childrens;
  }

  function isFather($father, $child) {
    if (strlen($father) >= strlen($child)) {
      return false;
    }
    for ($i = 0; $i < strlen($father); $i++) {
      if ($father[$i] != $child[$i]) {
        return false;
      }
    }
    return true;
  }
}