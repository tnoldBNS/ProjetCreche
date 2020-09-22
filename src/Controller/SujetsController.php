<?php

namespace App\Controller;

use App\Entity\Sujets;
use App\Form\SujetsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SujetsController extends AbstractController
{
    /**
     * @Route("/sujets", name="sujets")
     */
    public function index()
    {
        $sujets = $this->getDoctrine()
            ->getRepository(Sujets::class)
            ->getAll();

        return $this->render('sujets/index.html.twig', [
            'sujets' => $sujets,
        ]);
    }

    /**
     * @Route("/{id}/sujetsdelete", name="sujets_delete")
     */
    public function delete(Sujets $sujets)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($sujets);
        $entityManager->flush();
        return $this->redirectToRoute('forum');
    }


    /**
     * @Route("/sujetsadd", name="sujets_add")
     * @Route("/{id}/sujetsedit", name="sujets_edit")
     */
    public function add_edit(UserInterface $user, Sujets $sujets = null, Request $request)
    {

        if (!$sujets) {
            $sujets = new Sujets($user);
        }

        $form = $this->createForm(SujetsType::class, $sujets);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sujets = $form->getData();


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sujets);
            $entityManager->flush();

            return $this->redirectToRoute('forum');
        }

        return $this->render('forum/sujets/add_edit.html.twig', [
            'formSujets' => $form->createView(),
            'editMode' => $sujets->getId() !== null
        ]);
    }

    /**
     * @Route("/{id}/sujetShow", name="sujets_show", methods="GET")
     */
    public function show(Sujets $sujets): Response
    {
        return $this->render('forum/sujets/show.html.twig', [
            'sujets' => $sujets
        ]);
    }
}
