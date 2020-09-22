<?php

namespace App\Controller;

use App\Entity\Parents;
use App\Form\ParentsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/parents")
 */
class ParentsController extends AbstractController
{
    /**
     * @Route("/parents", name="parents")
     */
    public function index()
    {
        $parents = $this->getDoctrine()
            ->getRepository(Parents::class)
            ->getAll();

        return $this->render('parents/index.html.twig', [
            'parents' => $parents,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="parents_delete")
     */
    public function delete(Parents $parents)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($parents);
        $entityManager->flush();
        return $this->redirectToRoute('familles');
    }


    /**
     * @Route("/add", name="parents_add")
     * @Route("/{id}/edit", name="parents_edit")
     */
    public function add_edit(UserInterface $user, Parents $parents = null, Request $request)
    {
        // si le Parent n'existe pas, on instancie un nouveau parent (on est dans le cas d'un ajout)
        if (!$parents) {
            $parents = new Parents($user->getFamilles());
        }

        // il faut créer un parentsType au préalable (php bin/console make:form
        $form = $this->createForm(ParentsType::class, $parents);

        $form->handleRequest($request);
        // si on soumet le formulaire et que le form est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère les données du formulaire
            $parents = $form->getData();
            // on ajoute le nouvel enfant
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($parents);
            $entityManager->flush();
            // on redirige vers la liste des parents (Parents_list étant le nom de la route qui liste tous les enfants dans ParentsController)
            return $this->redirectToRoute('familles');
        }

        /* on renvoie à la vue correspondante : 
            - le formulaire
            - le booléen editMode (si vrai, on est dans le cas d'une édition sinon on est dans le cas d'un ajout)
        */
        return $this->render('parents/add_edit.html.twig', [
            'formParents' => $form->createView(),
            'editMode' => $parents->getId() !== null
        ]);
    }

    /**
     * @Route("/{id}", name="enfants_show", methods="GET")
     */
    public function show(Parents $parents): Response
    {
        return $this->render('parents/show.html.twig', [
            'enfants' => $parents
        ]);
    }
}