<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cable;
use AppBundle\Entity\Commande;
use AppBundle\Entity\CommandeCable;
use AppBundle\Entity\Palette;
use AppBundle\Entity\Touret;
use AppBundle\Form\CommandeCableType;
use AppBundle\Form\CommandeTransportType;
use AppBundle\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/commandes/ouvrier", name="afficher_commandes_ouvrier")
     */
    public function AfficherCommandesOuvrierAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $commandes = $em->getRepository("AppBundle:Commande")->getCommandesOuvrier($user->getId());
        return $this->render('default/commandes_ouvrier.html.twig', array('commandes' => $commandes));
    }

    /**
     * @Route("/commandes/details/{id}", name="afficher_details_commandes")
     */
    public function AfficherDetailsCommandesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository("AppBundle:Commande")->find($id);
        $palettes = $em->getRepository("AppBundle:Cable")->getCommandeCablesPalettes($id);
        $tourets = $em->getRepository("AppBundle:Cable")->getCommandeCablesTourets($id);

        return $this->render('default/commande.html.twig',
            array('commande' => $commande, 'palettes' => $palettes, 'tourets' => $tourets));
    }

    /**
     * @Route("/commande/ajouter", name="ajouter_commande")
     */
    public function AjouterCommandeAction(Request $request)
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $commande->setOuvrier($this->getUser());
            $commande->setDate(new \DateTime());
            $em->persist($commande);
            $em->flush();
            return $this->redirectToRoute('ajouter_commande_cables', array('id' => $commande->getId()));
        }
        return $this->render('default/ajouter_commande.html.twig',
            array('form' => $form->createView()));
    }

    /**
     * @Route("/commande/ajouter/cables/{id}", name="ajouter_commande_cables")
     */
    public function AjouterCommandeCablesAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $commandeCable = new CommandeCable();
        $form = $this->createForm(CommandeCableType::class, $commandeCable);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted())
        {
            $cable = new Cable();
            $cable->setLibelle($form["libelle"]->getData());
            $cable->setType($form["type"]->getData());
            $cable->setCouleur($form["couleur"]->getData());
            $cable->setTypeMetal($form["typeMetal"]->getData());
            $cable->setPoidsKgKm($form["poidsKgKm"]->getData());
            $cable->setQuantite(0);
            $em->persist($cable);
            $em->flush();

            $commande = $em->getRepository("AppBundle:Commande")->find($id);
            $commandeCable->setCable($cable);
            $commandeCable->setCommande($commande);

            $longueur = $commandeCable->getLongueurCable();
            while ($longueur > 0)
            {
                if (!$commandeCable->getCableDecoupe())
                {
                    switch (true)
                    {
                        case $longueur > 5000:
                            $touret = new Touret();
                            $touret->setCable($cable);
                            $touret->setType('4');
                            $touret->setLibelle('TUN_'.$cable->getLibelle());
                            $touret->setDiametre(1050);
                            $touret->setLargeur(950);
                            $touret->setLongueurCable(5000);
                            $touret->setLongueurCableMax(5000);
                            $touret->setLongueurCableMin(3500);
                            $touret->setPoidsVide(50);
                            $em->persist($touret);
                            $longueur = $longueur - 5000;
                            break;
                        case ($longueur <= 5000 && $longueur >= 3500):
                            $touret = new Touret();
                            $touret->setCable($cable);
                            $touret->setType('4');
                            $touret->setLibelle('TUN_'.$cable->getLibelle());
                            $touret->setDiametre(1050);
                            $touret->setLargeur(950);
                            $touret->setLongueurCable($longueur);
                            $touret->setLongueurCableMax(5000);
                            $touret->setLongueurCableMin(3500);
                            $touret->setPoidsVide(50);
                            $em->persist($touret);
                            $longueur = 0;
                            break;
                        case ($longueur <= 3500 && $longueur >= 3000):
                            $touret = new Touret();
                            $touret->setCable($cable);
                            $touret->setType('3');
                            $touret->setLibelle('TTN_'.$cable->getLibelle());
                            $touret->setDiametre(1050);
                            $touret->setLargeur(650);
                            $touret->setLongueurCable($longueur);
                            $touret->setLongueurCableMax(3500);
                            $touret->setLongueurCableMin(3000);
                            $touret->setPoidsVide(40);
                            $em->persist($touret);
                            $longueur = 0;
                            break;
                        case ($longueur <= 3000 && $longueur >= 2500):
                            $touret = new Touret();
                            $touret->setCable($cable);
                            $touret->setType('2');
                            $touret->setLibelle('TZN_'.$cable->getLibelle());
                            $touret->setDiametre(1050);
                            $touret->setLargeur(550);
                            $touret->setLongueurCable($longueur);
                            $touret->setLongueurCableMax(3000);
                            $touret->setLongueurCableMin(2500);
                            $touret->setPoidsVide(30);
                            $em->persist($touret);
                            $longueur = 0;
                            break;
                        case ($longueur <= 2500 && $longueur >= 500):
                            $touret = new Touret();
                            $touret->setCable($cable);
                            $touret->setType('1');
                            $touret->setLibelle('TCN_'.$cable->getLibelle());
                            $touret->setDiametre(1050);
                            $touret->setLargeur(450);
                            $touret->setLongueurCable($longueur);
                            $touret->setLongueurCableMax(2500);
                            $touret->setLongueurCableMin(500);
                            $touret->setPoidsVide(20);
                            $em->persist($touret);
                            $longueur = 0;
                            break;
                        case ($longueur < 500 && $longueur > 0):
                            $touret = new Touret();
                            $touret->setCable($cable);
                            $touret->setType('1');
                            $touret->setLibelle('TCN_'.$cable->getLibelle());
                            $touret->setDiametre(1050);
                            $touret->setLargeur(450);
                            $touret->setLongueurCable(50);
                            $touret->setLongueurCableMax(2500);
                            $touret->setLongueurCableMin(500);
                            $touret->setPoidsVide(20);
                            $em->persist($touret);
                            $commandeCable->setLongueurCable($commandeCable->getLongueurCable()
                                + (500 - $longueur));
                            $longueur = 0;
                            break;
                    }
                }
                else
                {
                    switch (true)
                    {
                        case $longueur > 15000:
                            $palette = new Palette();
                            $palette->setCable($cable);
                            $palette->setLibelle('Palette_EURO_'.$cable->getLibelle());
                            $palette->setPoidsMax(1000);
                            $palette->setPoidsVide(50);
                            $palette->setLongueur(120);
                            $palette->setLargeur(80);
                            $palette->setLongueurCableCouronnes(0.09);
                            $palette->setLongueurCableMax(15000);
                            $palette->setLongueurCableMin(2000);
                            $em->persist($palette);
                            $longueur = $longueur - 5000;
                            break;
                        case ($longueur >= 15000 && $longueur <= 2000):
                            $palette = new Palette();
                            $palette->setCable($cable);
                            $palette->setLibelle('Palette_EURO_'.$cable->getLibelle());
                            $palette->setPoidsMax(1000);
                            $palette->setPoidsVide(50);
                            $palette->setLongueur(120);
                            $palette->setLargeur(80);
                            $palette->setLongueurCableCouronnes(0.09);
                            $palette->setLongueurCableMax(15000);
                            $palette->setLongueurCableMin(2000);
                            $em->persist($palette);
                            $longueur = 0;
                            break;
                        case ($longueur > 0 && $longueur < 2000):
                            $palette = new Palette();
                            $palette->setCable($cable);
                            $palette->setLibelle('Palette_EURO_'.$cable->getLibelle());
                            $palette->setPoidsMax(1000);
                            $palette->setPoidsVide(50);
                            $palette->setLongueur(120);
                            $palette->setLargeur(80);
                            $palette->setLongueurCableCouronnes(0.09);
                            $palette->setLongueurCableMax(15000);
                            $palette->setLongueurCableMin(2000);
                            $em->persist($palette);
                            $commandeCable->setLongueurCable($commandeCable->getLongueurCable()
                                + (2000 - $longueur));
                            $longueur = 0;
                            break;
                    }
                }
            }

            $em->persist($commandeCable);
            $em->flush();

            if ($form->get('enregistrerajouter')->isClicked())
            {
                return $this->redirectToRoute('ajouter_commande_cables', array('id' => $id));
            }
            else if ($form->get('enregistrerpasser')->isClicked())
            {
                return $this->redirectToRoute('ajouter_commande_transport', array('id' => $id));
            }

            return $this->redirectToRoute('afficher_commandes_ouvrier');
        }

        $palettes = $em->getRepository("AppBundle:Cable")->getCommandeCablesPalettes($id);
        $tourets = $em->getRepository("AppBundle:Cable")->getCommandeCablesTourets($id);

        /*$normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$normalizer]);
        $formatted = $serializer->normalize($commandeCables);
        return new JsonResponse($formatted);*/

        return $this->render('default/ajouter_commande_cables.html.twig',
            array('form' => $form->createView(), 'palettes' => $palettes, 'tourets' => $tourets, 'id' => $id));
    }

    /**
     * @Route("/commande/ajouter/transport/{id}", name="ajouter_commande_transport")
     */
    public function AjouterCommandeTransportAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository("AppBundle:Commande")->find($id);
        $identifier = rand(1,3);
        $transport = $em->getRepository("AppBundle:Transport")->find($identifier);
        $palettes = $em->getRepository("AppBundle:Cable")->getCommandeCablesPalettes($id);
        $tourets = $em->getRepository("AppBundle:Cable")->getCommandeCablesTourets($id);
        $form = $this->createForm(CommandeTransportType::class, $commande);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted())
        {
            $commande->setTransport($transport);
            $em->persist($commande);
            $em->flush();
            return $this->redirectToRoute('afficher_commandes_ouvrier');
        }
        return $this->render('default/ajouter_commande_transport.html.twig',
            array('form' => $form->createView(), 'palettes' => $palettes, 'tourets' => $tourets, 'transport' => $transport,
                'id' => $id));
    }
}
