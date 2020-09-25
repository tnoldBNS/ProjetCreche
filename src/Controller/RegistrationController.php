<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\EditUsersType;
use App\Form\RegistrationFormType;
use App\Security\AppCustomAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AppCustomAuthenticator $authenticator): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/listUsers", name="listUsers")
     * @security("is_granted('ROLE_USER')")
     */
    public function listUsers()
    {
        $users = $this->getDoctrine()
            ->getRepository(Users::class)
            ->getAll();

        return $this->render('users/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/{id}/deleteUsers", name="users_delete")
     * @security("is_granted('ROLE_USER')")
     */
    public function delete(Users $users, UserInterface $user, AuthorizationCheckerInterface $authChecker)
    {
        if ($users->getId() == $user->getId() || true === $authChecker->isGranted('ROLE_ADMIN')) {
      $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($users);
        $entityManager->flush();
        }else{
        }
        return $this->redirectToRoute('listUsers');
    }

    /**
     * @Route("/{id}/editUsersByAdmin", name="users_editByAdmin")
     * @security("is_granted('ROLE_ADMIN')")
     */
    public function editByAdmin(Users $users = null, Request $request)
    {
        $form = $this->createForm(EditUsersType::class, $users);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $users = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($users);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('listUsers');
        }
        return $this->render('users/add_edit.html.twig', [
            'formUsers' => $form->createView(),
            'editMode' => $users->getId() !== null
        ]);
    }

        /**
     * @Route("/{id}/editUsers", name="users_edit")
     * @security("is_granted('ROLE_USER')")
     */
    public function edit(Users $users = null, Request $request, UserInterface $user, AuthorizationCheckerInterface $authChecker)
    {
        if ($users->getId() != $user->getId()) {
            return $this->redirectToRoute('listUsers');
        }
        $form = $this->createForm(RegistrationFormType::class, $users);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $users = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($users);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('listUsers');
        }
        return $this->render('users/add_edit.html.twig', [
            'formUsers' => $form->createView(),
            'editMode' => $users->getId() !== null
        ]);
    }
}
