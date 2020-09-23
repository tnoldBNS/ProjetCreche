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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/absences")
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
    public function edit(Request $request, Absences $absence): Response
    {
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
    public function delete(Request $request, Absences $absence): Response
    {
        if ($this->isCsrfTokenValid('delete'.$absence->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($absence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('absences_index');
    }
}
