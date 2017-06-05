<?php
namespace FrontendBundle\Controller;

use BackendBundle\Entity\Company;
use BackendBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
            'close'=>$this->container->get('router')->generate('empresa_ver',array('id'=>$company->getId()))
        ));
    }

}