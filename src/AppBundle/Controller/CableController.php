<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cable;
use AppBundle\Form\CableType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CableController extends Controller
{
    /**
     * @Route("/stock", name="afficher_stock")
     */
    public function AfficherStockAction()
    {
        $em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository("AppBundle:Cable")->findBy([], array('libelle' => 'ASC'));
        return $this->render('default/stock.html.twig', array('stock' => $stock));
    }

    /**
     * @Route("/stock/ajouter", name="ajouter_cables")
     */
    public function AjouterCablesAction(Request $request)
    {
        $cable = new Cable();
        $form = $this->createForm(CableType::class, $cable);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($cable);
            $em->flush();
            return $this->redirectToRoute('afficher_stock');
        }
        return $this->render('default/ajouter_cable.html.twig',
            array('form' => $form->createView()));
    }

    /**
     * @Route("/stock/modifier/{id}", name="modifier_cables")
     */
    public function ModifierCablesAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $cable = $em->getRepository("AppBundle:Cable")->find($id);
        $form = $this->createForm(CableType::class, $cable);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted())
        {
            $em->merge($cable);
            $em->flush();
            return $this->redirectToRoute('afficher_stock');
        }

        return $this->render('default/modifier_cable.html.twig',
            array('form' => $form->createView(), 'cable' => $cable));
    }

    /**
     * @Route("/stock/supprimer/{id}", name="supprimer_cables")
     */
    public function SupprimerCablesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cable = $em->getRepository("AppBundle:Cable")->find($id);

        $em->remove($cable);
        $em->flush();

        return $this->redirectToRoute('afficher_stock');
    }
}
