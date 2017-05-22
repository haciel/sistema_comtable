<?php
namespace FrontendBundle\Controller;

use BackendBundle\Entity\Company;
use BackendBundle\Entity\Account;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class PlanController extends Controller
{
    /**
     * @Route("/plan/{id}", name="plan_ver")
     */
    public function indexAction(Company $company, Request $request)
    {
       $this->is_access($company->getUserId());
        $Account = new Account();
        $Account->setCompanyId($company);
        $form = $this->createForm('FrontendBundle\Form\AccountType', $Account);
        $form->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-success flat']]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Account);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('account.create_successfull'));
            return $this->redirectToRoute('plan_ver', array('id' => $company->getId()));
        }

        $em = $this->getDoctrine()->getManager();
        $cuentas = $em->getRepository('BackendBundle:Account')->findBy(array(
            'companyId' => $company,
        ));
        $delete_forms=array();
        foreach ($cuentas as $entity)
            $delete_forms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        return $this->render('FrontendBundle:Plan:index.html.twig', array(
            'cuentas' => $cuentas,
            'empresa' => $company,
            'delete_forms'=>$delete_forms,
            'form' => $form->createView(),
        ));
    }

    public function is_access(User $user){
        $account = $this->container->get('security.context')->getToken()->getUser();
        if($account->getId()!= $user->getId()){
            throw $this->createAccessDeniedException('No tiene permisos para acceder a esta página!');
        }
    }

    /**
     * Displays a form to edit an existing Company entity.
     *
     * @Route("/editar-cuenta/{id}", name="cuenta_editar")
     * @Method({"GET", "POST"})
     */
    public function editCompanyAction(Request $request, Account $account)
    {
        $this->is_access($account->getCompanyId()->getUserId());
        $editForm = $this->createForm('FrontendBundle\Form\AccountType', $account);
        $editForm->add('submit','Symfony\Component\Form\Extension\Core\Type\SubmitType',['label'=>'Guardar','attr'=>['class'=>'btn btn-success flat']]);

        $editForm->handleRequest($request);
        $trans=$this->get('translator');

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('account.edit_successfull'));

            return $this->redirectToRoute('plan_ver', array('id' => $account->getCompanyId()->getId()));

        }
        return $this->render('FrontendBundle:Plan:form.html.twig', array(
            'account' => $account,
            'title'=>'Editar Cuenta',
            'form' => $editForm->createView(),
            'description_page'=>$trans->trans('account.title'),
        ));
    }

    /**
     * Deletes a Account entity.
     *
     * @Route("/cuenta-eliminar/{id}", name="cuenta_eliminar")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Account $Account)
    {
        $this->is_access($Account->getCompanyId()->getUserId());
        $form = $this->createDeleteForm($Account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($Account);
            $em->flush();
        }

        return $this->redirectToRoute('plan_ver',array('id'=>$Account->getCompanyId()->getId()));
    }

    /**
     * Creates a form to delete a Account entity.
     *
     * @param Account $Account The Account entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Account $Account)
    {
        return $this->createFormBuilder()
            ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array('label' =>'backend.delete', 'attr' => array('class' => 'btn btn-sm btn-danger flat')))
            ->setAction($this->generateUrl('cuenta_eliminar', array('id' => $Account->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}