<?php

namespace App\Controller;

use App\Entity\Commissions;
use App\Form\CommissionsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
* @security("is_granted('ROLE_EFFECTIF') or is_granted('ROLE_FAMILLE') or is_granted('ROLE_ADMIN')")
*/ 
class CommissionsController extends AbstractController
{
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
     * @Route("/{id}/deletecommissions", name="commissions_delete")
     * @security("is_granted('ROLE_ADMIN')")
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
     * @security("is_granted('ROLE_ADMIN')")
     */
    public function add_edit(Commissions $commissions = null, Request $request)
    {
        // si le commission n'existe pas, on instancie une nouvelle commission (on est dans le cas d'un ajout)
        if (!$commissions) {
            $commissions = new Commissions();
            
        }

        // il faut créer un CommissionsType au préalable (php bin/console make:form
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
