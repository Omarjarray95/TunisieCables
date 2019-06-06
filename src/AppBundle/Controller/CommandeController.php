<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CommandeController extends Controller
{
    /**
     * @Route("/commandes", name="afficher_commandes")
     */
    public function AfficherCommandesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository("AppBundle:Commande")->findBy([], array('date' => 'DESC'));
        return $this->render('default/commandes.html.twig', array('commandes' => $commandes));
    }

    /**
     * @Route("/commandes/details/{id}", name="afficher_details_commandes")
     */
    public function AfficherDetailsCommandesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository("AppBundle:Commande")->find($id);
        $commandeCables = $em->getRepository("AppBundle:Cable")->getCommandeCables($id);

        return $this->render('default/commande.html.twig',
            array('commande' => $commande, 'cables' => $commandeCables));
    }
}
