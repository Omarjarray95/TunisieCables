<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ouvrier;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class OuvrierController extends BaseController
{
    private $eventDispatcher;
    private $formFactory;
    private $userManager;
    private $tokenStorage;

    public function __construct(EventDispatcherInterface $eventDispatcher, FactoryInterface $formFactory, UserManagerInterface $userManager, TokenStorageInterface $tokenStorage)
    {
        parent::__construct($eventDispatcher, $formFactory, $userManager, $tokenStorage);
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $formFactory;
        $this->userManager = $userManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/ouvriers", name="afficher_ouvriers")
     */
    public function AfficherOuvriersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ouvriers = $em->getRepository("AppBundle:Ouvrier")->findBy([], array('enabled' => 'DESC', 'nom' => 'ASC'));
        return $this->render('default/ouvriers.html.twig', array('ouvriers' => $ouvriers));
    }

    /**
     * @Route("/ouvriers/ajouter", name="ajouter_ouvriers")
     */
    public function registerAction(Request $request)
    {
        $ouvrier = new Ouvrier();
        $ouvrier->setEnabled(true);

        $event = new GetResponseUserEvent($ouvrier, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse())
        {
            return $event->getResponse();
        }

        $form = $this->formFactory->createForm();
        $form->setData($ouvrier);

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {
                $event = new FormEvent($form, $request);
                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $this->userManager->updateUser($ouvrier);

                if (null === $response = $event->getResponse())
                {
                    $url = $this->generateUrl('afficher_ouvriers');
                    $response = new RedirectResponse($url);
                }

                return $response;
            }

            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse())
            {
                return $response;
            }
        }

        return $this->render('default/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/ouvriers/modifier/{id}", name="modifier_ouvriers")
     */
    public function ModifierOuvrierAction(Request $request, $id)
    {
        $ouvrier = $this->userManager->findUserBy(array('id' => $id));

        $form = $this->formFactory->createForm();
        $form->setData($ouvrier);

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {
                $event = new FormEvent($form, $request);
                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $this->userManager->updateCanonicalFields($ouvrier);
                $this->userManager->updatePassword($ouvrier);
                $this->userManager->updateUser($ouvrier);

                if (null === $response = $event->getResponse())
                {
                    $url = $this->generateUrl('afficher_ouvriers');
                    $response = new RedirectResponse($url);
                }

                return $response;
            }

            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse())
            {
                return $response;
            }
        }

        return $this->render('default/modifier_ouvrier.html.twig', array(
            'form' => $form->createView(), 'ouvrier' => $ouvrier
        ));
    }

    /**
     * @Route("/ouvriers/supprimer/{id}", name="supprimer_ouvriers")
     */
    public function SupprimerOuvrierAction(Request $request, $id)
    {
        $ouvrier = $this->userManager->findUserBy(array('id' => $id));

        $ouvrier->setEnabled(false);

        $this->userManager->updateUser($ouvrier);

        $url = $this->generateUrl('afficher_ouvriers');
        $response = new RedirectResponse($url);

        return $response;
    }

    /**
     * Tell the user to check their email provider.
     */
    public function checkEmailAction(Request $request)
    {
        $email = $request->getSession()->get('fos_user_send_confirmation_email/email');

        if (empty($email)) {
            return new RedirectResponse($this->generateUrl('fos_user_registration_register'));
        }

        $request->getSession()->remove('fos_user_send_confirmation_email/email');
        $user = $this->userManager->findUserByEmail($email);

        if (null === $user) {
            return new RedirectResponse($this->container->get('router')->generate('fos_user_security_login'));
        }

        return $this->render('@FOSUser/Registration/check_email.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Receive the confirmation token from user email provider, login the user.
     *
     * @param Request $request
     * @param string  $token
     *
     * @return Response
     */
    public function confirmAction(Request $request, $token)
    {
        $userManager = $this->userManager;

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('fos_user_registration_confirmed');
            $response = new RedirectResponse($url);
        }

        $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

    /**
     * Tell the user his account is now confirmed.
     */
    public function confirmedAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('@FOSUser/Registration/confirmed.html.twig', array(
            'user' => $user,
            'targetUrl' => $this->getTargetUrlFromSession($request->getSession()),
        ));
    }

    /**
     * @return string|null
     */
    private function getTargetUrlFromSession(SessionInterface $session)
    {
        $key = sprintf('_security.%s.target_path', $this->tokenStorage->getToken()->getProviderKey());

        if ($session->has($key)) {
            return $session->get($key);
        }

        return null;
    }
}
