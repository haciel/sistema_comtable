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

class HomeController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {

        return $this->render('FrontendBundle:Index:index.html.twig', array(
            'active' => '',
        ));
    }

    /**
     * @Route("/plataforma-educativa", name="plataformaEducativa")
     */
    public function plataformaEducativaAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (in_array('ROLE_ESTUDENT', $user->getRoles())) {
            return $this->estudiante();
        } else {
            return $this->profesor();
        }
    }


    private function estudiante()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $empresas = $em->getRepository('BackendBundle:Company')->findBy(array(
            'userId' => $user,
        ));
        $tareas_pendientes = $this->getTareasPendientes($user);
        $delete_forms = array();
        foreach ($empresas as $entity)
            $delete_forms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        return $this->render('FrontendBundle:Home:index.html.twig', array(
            'empresas' => $empresas,
            'tareas' => $tareas_pendientes,
            'delete_forms' => $delete_forms,
            'active' => '',
        ));
    }

    private function profesor()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $empresas = $em->getRepository('BackendBundle:Company')->findBy(array(
            'userId' => $user,
        ));
        $delete_forms = array();
        foreach ($empresas as $entity)
            $delete_forms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        return $this->render('FrontendBundle:Home:index.html.twig', array(
            'empresas' => $empresas,
            'delete_forms' => $delete_forms,
            'active' => '',
        ));
    }

    private function getTareasPendientes($user)
    {
        $em = $this->getDoctrine()->getManager();
        $tareas = $em->getRepository('BackendBundle:Task')->findBy(array(
            'institutionId' => $user->getInstitutionId(),
            'educationallevelId' => $user->getEducationallevelId(),
        ));
        $response=array();
        foreach ($tareas as $tarea){
            $hoy=new \DateTime('now');
            if($tarea->getDateLimit()->format('Y-m-d')>=$hoy->format('Y-m-d')){
                $response[]=$tarea;
            }
        }
        return $response;
    }

    /**
     * Creates a form to delete a Company entity.
     *
     * @param Company $Company The Company entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Company $Company)
    {
        return $this->createFormBuilder()
            ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array('label' => 'backend.delete', 'attr' => array('class' => 'btn btn-sm btn-danger flat')))
            ->setAction($this->generateUrl('company_delete_estudiante', array('id' => $Company->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}