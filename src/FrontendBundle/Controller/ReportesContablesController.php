<?php
namespace FrontendBundle\Controller;

use BackendBundle\Entity\Company;
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
class ReportesContablesController extends Controller
{
    /**
     * @Route("/", name="reportesContables")
     */
    public function indexAction(Company $company)
    {
        $breadcrumb[] = array(
            'name' => 'Inicio',
            'url' => $this->container->get('router')->generate('plataformaEducativa'),
        );
        return $this->render('FrontendBundle:ReportesContables:index.html.twig', array(
            'breadcrumb' => $breadcrumb,
            'empresa' => $company,
        ));
    }

    /**
     * @Route("/libro-diario", name="librodiario")
     */
    public function testreporte(Request $request,Company $company)
    {
        $l = Array();

        // PAGE META DESCRIPTORS --------------------------------------

        $l['a_meta_charset'] = 'UTF-8';
        $l['a_meta_dir'] = 'ltr';
        $l['a_meta_language'] = 'en';

        // TRANSLATIONS --------------------------------------
        $l['w_page'] = 'page';

        $desde=$request->get('desde');
        $hasta=$request->get('hasta');
        $em = $this->getDoctrine()->getManager();
        $asientosAll = $em->getRepository('BackendBundle:AccountantMove')->findBy(array(
            'companyId' => $company,
        ));
        $asientos=array();
        foreach ($asientosAll as $item){
            if($desde<=$item->getDate()->format('Y-m-d') && $hasta>=$item->getDate()->format('Y-m-d')){
                $asientos[]=$item;
            }
        }
        $html = $this->render('FrontendBundle:ReportesContables:pdf.html.twig',array(
            'asientos'=>$asientos,
            'desde'=>$desde,
            'hasta'=>$hasta,
            'company'=>$company
        ));

        $stringHTML=$html->getContent();
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

}