<?php
namespace FrontendBundle\Controller;

use BackendBundle\Entity\AccountantMove;
use BackendBundle\Entity\Company;
use BackendBundle\Entity\Account;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class MovimientosController extends Controller
{
    /**
     * @Route("/movimientos-contables/{id}", name="movimientosContables_ver")
     */
    public function indexAction(Company $company, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $movimiento=$em->getRepository('BackendBundle:AccountantMove')->findOneBy(array(
            'companyId' => $company,
        ));
        $number=1;
        if(empty($movimiento)){
            $movimiento=new AccountantMove();
            $movimiento->setCompanyId($company);
            $movimiento->setDate(new \DateTime('now'));
            $movimientos=$em->getRepository('BackendBundle:AccountantMove')->findAll();
            $number+=count($movimientos);
        }else{
            $number=$movimiento->getId();
        }
        $form = $this->createForm('FrontendBundle\Form\AccountantMoveType', $movimiento);
        $form->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-success flat']]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($movimiento->getOperations() as &$operation){
                $operation->setAccountmoveId($movimiento);
            }
            $em->persist($movimiento);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('accountantMove.create_successfull'));
            return $this->redirectToRoute('movimientosContables_ver', array('id' => $company->getId()));
        }
        return $this->render('FrontendBundle:Movimientos:index.html.twig', array(
            'empresa' => $company,
            'numero' => $number,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/get-accounts/{id}", name="getAccounts")
     */
    public function getAccountName(Company $company)
    {
        $em = $this->getDoctrine()->getManager();
        $cuentas=$em->getRepository('BackendBundle:Account')->findBy(array(
            'companyId' => $company,
        ));
        $response=array();
        foreach ($cuentas as $item){
            $response[]=array(
                'id'=>$item->getId(),
                'name'=>$item->getName(),
            );
        }
        return new JsonResponse($response);
    }


}