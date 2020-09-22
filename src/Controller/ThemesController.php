<?php

namespace App\Controller;

use App\Entity\Themes;
use App\Form\ThemesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ThemesController extends AbstractController
{
    /**
     * @Route("/themes", name="themes")
     */
    public function index()
    {
        return $this->render('forum/themes/index.html.twig', [
            'controller_name' => 'ThemesController',
        ]);
    }

    /**
     * @Route("/{id}/delete", name="themes_delete")
     */
    public function delete(Themes $themes)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($themes);
        $entityManager->flush();
        return $this->redirectToRoute('forum');
    }


    /**
     * @Route("/addthemes", name="themes_add")
     * @Route("/{id}/editthemes", name="themes_edit")
     */
    public function add_edit(UserInterface $user, Themes $themes = null, Request $request)
    {
        if (!$themes) {
            $themes = new Themes();
        }

        $form = $this->createForm(ThemesType::class, $themes);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $themes = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($themes);
            $entityManager->flush();
            return $this->redirectToRoute('forum');
        }

        return $this->render('forum/themes/add_edit.html.twig', [
            'formThemes' => $form->createView(),
            'editMode' => $themes->getId() !== null
        ]);
    }

    /**
     * @Route("/{id}", name="themes_show", methods="GET")
     */
    public function show(Themes $themes): Response
    {
        return $this->render('forum/themes/show.html.twig', [
            'themes' => $themes
        ]);
    }
}
