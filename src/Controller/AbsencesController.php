<?php

namespace App\Controller;

use App\Entity\Absences;
use App\Form\AbsencesType;
use App\Form\AbsencesEnfantsType;
use App\Form\AbsencesEffectifsType;
use App\Repository\AbsencesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/absences")
 * @security("is_granted('ROLE_EFFECTIF') or is_granted('ROLE_FAMILLE') or is_granted('ROLE_ADMIN') or is_granted('ROLE_ACCUEIL')")
 */
class AbsencesController extends AbstractController
{

    /**
     * @Route("/", name="absences")
     */
    public function calendrier()
    {
        return $this->render('absences/calendrier.html.twig');
    }

    /**
     * @Route("/index", name="absences_index", methods={"GET"})
     */
    public function index(AbsencesRepository $absencesRepository): Response
    {
        return $this->render('absences/index.html.twig', [
            'absences' => $absencesRepository->findAll(),
        ]);
    }
    
    
    /**
     * @Route("/new", name="absences_new", methods={"GET","POST"})
     * @security("is_granted('ROLE_ADMIN')")
     */
    public function new(Request $request): Response
    {
        $absence = new Absences();
        $form = $this->createForm(AbsencesType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($absence);
            $entityManager->flush();

            return $this->redirectToRoute('absences_index');
        }

        return $this->render('absences/new.html.twig', [
            'absence' => $absence,
            'form' => $form->createView(),
        ]);
    }

        /**
     * @Route("/absencesEnfants_new", name="absencesEnfants_new", methods={"GET","POST"})
     * @security("is_granted('ROLE_FAMILLE')")
     */
    public function newAbsEnfants(Request $request): Response
    {
        $user = $this->getUser();
        $absence = new Absences($user);
        $form = $this->createForm(AbsencesEnfantsType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($absence);
            $entityManager->flush();

            return $this->redirectToRoute('absences_index');
        }

        return $this->render('absences/new.html.twig', [
            'absence' => $absence,
            'form' => $form->createView(),
        ]);
    }

        /**
     * @Route("/absencesEffectifs_new", name="absencesEffectifs_new", methods={"GET","POST"})
     * @security("is_granted('ROLE_EFFECTIF')")
     */
    public function newAbsEffectifss(Request $request): Response
    {
        $user = $this->getUser();
        $absence = new Absences($user);
        $form = $this->createForm(AbsencesEffectifsType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($absence);
            $entityManager->flush();

            return $this->redirectToRoute('absences_index');
        }

        return $this->render('absences/new.html.twig', [
            'absence' => $absence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="absences_show", methods={"GET"})
     */
    public function show(Absences $absence): Response
    {
        return $this->render('absences/show.html.twig', [
            'absence' => $absence,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="absences_edit", methods={"GET","POST"})
     */
    public function edit(UserInterface $user, AuthorizationCheckerInterface $authChecker, Request $request, Absences $absence): Response
    {
        if (($absence->getEnfants()->getFamilles()->getUsers()->getId() != $user->getId() || $absence->getEffectifs()->getUsers()->getId() != $user->getId()) && false === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('absences_index');
        }
        $form = $this->createForm(AbsencesType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('absences_index');
        }

        return $this->render('absences/edit.html.twig', [
            'absence' => $absence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="absences_delete", methods={"DELETE"})
     */
    public function delete(UserInterface $user, AuthorizationCheckerInterface $authChecker, Request $request, Absences $absence): Response
    {
        if (($absence->getEnfants()->getFamilles()->getUsers()->getId() != $user->getId() || $absence->getEffectifs()->getUsers()->getId() != $user->getId()) && false === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('absences_index');
        }
        if ($this->isCsrfTokenValid('delete'.$absence->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($absence);
            $entityManager->flush();
        }
        return $this->redirectToRoute('absences_index');
    }
}
