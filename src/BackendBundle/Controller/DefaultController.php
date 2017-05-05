<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/flash_bag", name="flash_bag", defaults={"_format"="json"})
     */
    public function flashBagAction()
    {
        return new JsonResponse($this->get('session')->getFlashBag()->all());
    }

    public function navbarRightAction()
    {
        return $this->render('BackendBundle:Default:partials/nav_right.html.twig');
    }

    public function mainSidebarAction($active)
    {

        return $this->render('BackendBundle:Default:partials/main_sidebar.html.twig',['active'=>$active]);
    }
}
