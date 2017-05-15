<?php
namespace FrontendBundle\Controller;

use BackendBundle\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class EmpresaController extends Controller
{
    /**
     * @Route("/empresa/{id}", name="empresa_ver")
     */
    public function indexAction(Company $company)
    {

        return $this->render('FrontendBundle:Empresa:index.html.twig',array(
            'empresa'=>$company,
        ));
    }


}