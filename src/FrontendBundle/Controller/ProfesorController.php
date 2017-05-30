<?php
namespace FrontendBundle\Controller;

use BackendBundle\Entity\AnswerTask;
use BackendBundle\Entity\Company;
use BackendBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class ProfesorController extends Controller
{

    /**
     * @Route("/profesor/listado/estudiantes", name="profesor")
     */
    public function indexAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $estudiantes = $em->getRepository('UserBundle:User')->findBy(array(
            'institutionId' => $user->getInstitutionId(),
            'educationallevelId' => $user->getEducationallevelId(),
        ));
        foreach ($estudiantes as $index=>$estudiante){
            if(!in_array('ROLE_ESTUDENT',$estudiante->getRoles())){
                unset($estudiantes[$index]);
            }
        }
        $delete_forms = array();
        foreach ($estudiantes as $entity)
            $delete_forms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        return $this->render('FrontendBundle:Profesor:index.html.twig',array(
            'estudiantes' => $estudiantes,
            'delete_forms'=>$delete_forms,
            'active'=>'estudiantes',
        ));
    }

    /**
     * @Route("/profesor/listado/tareas", name="profesor_tareas")
     */
    public function tareasAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $tareas = $em->getRepository('BackendBundle:Task')->findBy(array(
            'userId' => $user,
        ));
        $delete_forms = array();
        foreach ($tareas as $entity)
            $delete_forms[$entity->getId()] = $this->createDeleteFormTask($entity)->createView();

        $task=new Task();
        $task->setUserId($user);
        $form = $this->createForm('FrontendBundle\Form\TaskType', $task);
        $form->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-success flat']]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('task.create_successfull'));
                return $this->redirectToRoute('profesor_tareas');
            }

        return $this->render('FrontendBundle:Profesor:tasks.html.twig',array(
            'tareas' => $tareas,
            'delete_forms'=>$delete_forms,
            'active'=>'task',
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
     * @Route("/profesor/editar/tarea/{id}", name="profesor_editar_tarea")
     * @Method({"GET", "POST"})
     */
    public function editTaskAction(Request $request, Task $tarea)
    {
        $this->is_access($tarea->getUserId());
        $editForm = $this->createForm('FrontendBundle\Form\TaskType', $tarea);
        $editForm->add('submit','Symfony\Component\Form\Extension\Core\Type\SubmitType',['label'=>'Guardar','attr'=>['class'=>'btn btn-success flat']]);

        $editForm->handleRequest($request);
        $trans=$this->get('translator');

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('task.edit_successfull'));

            return $this->redirectToRoute('profesor_tareas');

        }

        return $this->render('FrontendBundle:Profesor:formTask.html.twig', array(
            'task' => $tarea,
            'title'=>'Editar Tarea',
            'form' => $editForm->createView(),
            'description_page'=>$trans->trans('task.name'),
            'active'=>'task'
        ));
    }

    /**
     * @Route("/profesor/activar/estudiante/{id}", name="profesor_activar_estudiante")
     */
    public function activarEstudianteAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setEnabled(true);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('profesor');
    }

    /**
     * @Route("/profesor/desactivar/estudiante/{id}", name="profesor_desactivar_estudiante")
     */
    public function desactivarEstudianteAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setEnabled(false);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('profesor');
    }

    /**
     * Creates a form to delete a Company entity.
     *
     * @param Company $Company The Company entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array('label' =>'backend.delete', 'attr' => array('class' => 'btn btn-sm btn-danger flat')))
            ->setAction($this->generateUrl('profesor_delete_estudiante', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    private function createDeleteFormTask(Task $task)
    {
        return $this->createFormBuilder()
            ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array('label' =>'backend.delete', 'attr' => array('class' => 'btn btn-sm btn-danger flat')))
            ->setAction($this->generateUrl('profesor_delete_task', array('id' => $task->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    private function createDeleteFormAnswer(AnswerTask $answerTask)
    {
        return $this->createFormBuilder()
            ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array('label' =>'backend.delete', 'attr' => array('class' => 'btn btn-sm btn-danger flat')))
            ->setAction($this->generateUrl('profesor_delete_answer', array('id' => $answerTask->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Deletes a Company entity.
     *
     * @Route("/{id}/profesor-delete-estudiante", name="profesor_delete_estudiante")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('profesor');
    }

    /**
     * Deletes a Company entity.
     *
     * @Route("/{id}/profesor-delete-tarea", name="profesor_delete_task")
     * @Method("DELETE")
     */
    public function deleteTaskAction(Request $request, Task $task)
    {
        $form = $this->createDeleteForm($task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();
        }

        return $this->redirectToRoute('profesor_tareas');
    }

    /**
     * Deletes a Company entity.
     *
     * @Route("/{id}/profesor-delete-respuesta", name="profesor_delete_answer")
     * @Method("DELETE")
     */
    public function deleteAnswerAction(Request $request, AnswerTask $answerTask)
    {
        $form = $this->createDeleteForm($answerTask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($answerTask);
            $em->flush();
        }

        return $this->redirectToRoute('profesor_revision');
    }

    /**
     *
     * @Route("/profesor/listado/revisiones", name="profesor_revision")
     *
     */
    public function answerTaskAction(){
        $em = $this->getDoctrine()->getManager();

        $AnswerTasks = $em->getRepository('BackendBundle:AnswerTask')->findAll();
        $delete_forms = array();
        foreach ($AnswerTasks as $entity)
            $delete_forms[$entity->getId()] = $this->createDeleteFormAnswer($entity)->createView();

        return $this->render('FrontendBundle:Profesor:answerTask.html.twig', array(
            'answerTasks' => $AnswerTasks,
            'delete_forms'=>$delete_forms,
        ));
    }
}