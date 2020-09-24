<?php

namespace App\Controller;

use App\Entity\Sujets;
use App\Entity\Messages;
use App\Form\MessagesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @security("is_granted('ROLE_EFFECTIF') or is_granted('ROLE_FAMILLE') or is_granted('ROLE_ADMIN')")
 */
class MessagesController extends AbstractController
{
    /**
     * @Route("/messages", name="messages")
     */
    public function index()
    {
        $messages = $this->getDoctrine()
            ->getRepository(Messages::class)
            ->getAll();

        return $this->render('forum/messages/index.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * @Route("/{id}/messagesdelete", name="messagess_delete")
     */
    public function delete(Messages $messages, AuthorizationCheckerInterface $authChecker)
    {
        if ($messages->getUsers()->getId() == $this->user->getId() || true === $authChecker->isGranted('ROLE_ADMIN')) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($messages);
            $entityManager->flush();
        }else{
        }
        return $this->redirectToRoute('forum');
    }


    /**
     * @Route("/{idS}/messagessadd", name="messages_add")
     * @Route("/{id}/messagesedit", name="messages_edit")
     */
    public function add_edit(UserInterface $user, AuthorizationCheckerInterface $authChecker, Messages $messages = null, Request $request, Sujets $sujet)
    {

        if (($messages && $messages->getUsers()->getId() != $user->getId()) && false === $authChecker->isGranted('ROLE_ADMIN')) {     
            return $this->redirectToRoute('forum');
        }
        if (!$messages) {
            $messages = new Messages($user, $sujet);
        }

        $form = $this->createForm(MessagesType::class, $messages);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $messages = $form->getData();


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($messages);
            $entityManager->flush();

            return $this->redirectToRoute('forum');
        }

        return $this->render('forum/messages/add_edit.html.twig', [
            'formMessages' => $form->createView(),
            'editMode' => $messages->getId() !== null
        ]);
    }

    /**
     * @Route("/{id}/messagesShow", name="messages_show", methods="GET")
     */
    public function show(Messages $messages): Response
    {
        return $this->render('forum/messages/show.html.twig', [
            'messages' => $messages
        ]);
    }
}
