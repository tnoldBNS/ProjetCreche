<?php

namespace App\Controller;

use App\Entity\Galleries;
use App\Form\GalleriesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @security("is_granted('ROLE_EFFECTIF') or is_granted('ROLE_ADMIN')")
 */
class GalleriesController extends AbstractController
{
    /**
     * @Route("/galleries", name="galleries")
     */
    public function index()
    {$galleries = $this->getDoctrine()
        ->getRepository(Galleries::class)
        ->getAll();

        return $this->render('galleries/index.html.twig', [
            'galleries' => $galleries,
        ]);
    }

    /**
     * @Route("/{id}/deleteGalleries", name="galleries_delete")
     */
    public function delete(Galleries $galleries)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($galleries);
        $entityManager->flush();
        return $this->redirectToRoute('galleries');
    }


    /**
     * @Route("/addGalleries", name="galleries_add")
     * @Route("/{id}/editGalleries", name="galleries_edit")
     */
    public function add_edit(UserInterface $user, Galleries $galleries = null, Request $request)
    {
        if (!$galleries) {
            $galleries = new Galleries();
        }
        $form = $this->createForm(GalleriesType::class, $galleries);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $galleries = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($galleries);
            $entityManager->flush();
            return $this->redirectToRoute('galleries');
        }

        /* on renvoie à la vue correspondante : 
            - le formulaire
            - le booléen editMode (si vrai, on est dans le cas d'une édition sinon on est dans le cas d'un ajout)
        */
        return $this->render('galleries/add_edit.html.twig', [
            'formGalleries' => $form->createView(),
            'editMode' => $galleries->getId() !== null
        ]);
    }
}