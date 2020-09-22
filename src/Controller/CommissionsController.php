<?php

namespace App\Controller;

use App\Entity\Commissions;
use App\Form\CommissionsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommissionsController extends AbstractController
{

        /**
     * Afficher la liste des commissions
     */
    public function getAll() {
        $entityManager = $this->getEntityManager();
        // requête DQL : liste des commissions triés par ordre alphabetique
        $query = $entityManager->createQuery(
            "SELECT c
                FROM App\Entity\Commissions c
                ORDER BY c.nomCommission"
        );
        return $query->execute();
    }
    /**
     * @Route("/commissions", name="commissions")
     */
    public function index()
    {

        $commissions = $this->getDoctrine()
            ->getRepository(Commissions::class)
            ->getAll();

        return $this->render('commissions/index.html.twig', [
            'commissions' => $commissions,
        ]);
    }
    /**
     * @Route("/{id}/delete", name="commissions_delete")
     */
    public function delete(Commissions $commissions)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($commissions);
        $entityManager->flush();
        return $this->redirectToRoute('commissions');
    }

    /**
     * @Route("/commission/add", name="commissions_add")
     * @Route("/commission/{id}/edit", name="commissions_edit")
     */
    public function add_edit(UserInterface $user, Commissions $commissions = null, Request $request)
    {
        // si le commission n'existe pas, on instancie une nouvelle commission (on est dans le cas d'un ajout)
        if (!$commissions) {
            $commissions = new Commissions();
            
        }

        // il faut créer un VommissionsType au préalable (php bin/console make:form
        $form = $this->createForm(CommissionsType::class, $commissions);
         $form->handleRequest($request);
        // si on soumet le formulaire et que le form est valide
        if ($form->isSubmitted() ) {
            
            // on récupère les données du formulaire
            $commissions = $form->getData();
            // on ajoute une nouvelle commission
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commissions);
            $entityManager->flush();
            // on redirige vers la liste des commissions (commissions étant le nom de la route qui liste toutes les commission dans CommissionsController)
            return $this->redirectToRoute('commissions');
        }

        /* on renvoie à la vue correspondante : 
            - le formulaire
            - le booléen editMode (si vrai, on est dans le cas d'une édition sinon on est dans le cas d'un ajout)
        */
        return $this->render('commissions/add_edit.html.twig', [
            'formCommissions' => $form->createView(),
            'editMode' => $commissions->getId() !== null
        ]);
    }
}
