<?php
namespace FrontendBundle\Controller;

use BackendBundle\Entity\Company;
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

        return $this->render('FrontendBundle:Index:index.html.twig',array(
            'active'=>'',
        ));
    }

    /**
     * @Route("/home", name="home")
     */
    public function homeAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $empresas = $em->getRepository('BackendBundle:Company')->findBy(array(
            'userId' => $user,
        ));
        $delete_forms = array();
        foreach ($empresas as $entity)
            $delete_forms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        return $this->render('FrontendBundle:Home:index.html.twig',array(
            'empresas' => $empresas,
            'delete_forms'=>$delete_forms,
            'active'=>'',
        ));
    }

    /**
     * Creates a new Company entity.
     *
     * @Route("/crear-empresa", name="company_new_home")
     * @Method({"GET", "POST"})
     */
    public function newCompanyAction(Request $request)
    {
        $Company = new Company();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $Company->setUserId($user);
        $Company->setInstitutionId($user->getInstitutionId());
        $Company->setEducationallevelId($user->getEducationallevelId());
        $form = $this->createForm('FrontendBundle\Form\CompanyType', $Company);
        $form->add('submit','Symfony\Component\Form\Extension\Core\Type\SubmitType',['label'=>'Guardar','attr'=>['class'=>'btn btn-success flat']]);

        $form->handleRequest($request);
        $trans=$this->get('translator');

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Company);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('company.create_successfull'));

            return $this->redirectToRoute('home');
        }

        return $this->render('FrontendBundle:Company:new.html.twig', array(
            'company' => $Company,
            'form' => $form->createView(),
            'description_page'=>$trans->trans('company.title'),
        ));
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
            ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array('label' =>'backend.delete', 'attr' => array('class' => 'btn btn-sm btn-danger flat')))
            ->setAction($this->generateUrl('company_delete', array('id' => $Company->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}