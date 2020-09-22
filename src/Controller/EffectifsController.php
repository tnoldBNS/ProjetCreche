<?php

namespace App\Controller;

use App\Entity\Effectifs;
use App\Form\EffectifsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EffectifsController extends AbstractController
{
    /**
     * @Route("/effectifs", name="effectifs_list")
     */
    public function index(UserInterface $user)
    {
        $effectifs = $this->getDoctrine()
            ->getRepository(Effectifs::class)
            ->getOneByIdUser($user->getId());

        return $this->render('effectifs/index.html.twig', [
            'effectifs' => $effectifs,
            
        ]);
    }

    /**
     * @Route("/{id}/delete", name="effectifs_delete")
     */
    public function delete(Effectifs $effectifs)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($effectifs);
        $entityManager->flush();
        return $this->redirectToRoute('effectifs_list');
    }

    /**
     * @Route("/add", name="effectifs_add")
     * @Route("/{id}/edit", name="effectifs_edit")
     */
    public function add_edit(UserInterface $user, Effectifs $effectifs = null, Request $request)
    {
        // si le effectifs n'existe pas, on instancie un nouveau Effectifs (on est dans le cas d'un ajout)
        if (!$effectifs) {
            $effectifs = new Effectifs();
            
        }

        // il faut créer un EffectifsType au préalable (php bin/console make:form
        $form = $this->createForm(EffectifsType::class, $effectifs);

        $form->handleRequest($request);
        // si on soumet le formulaire et que le form est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère les données du formulaire
            $effectifs = $form->getData();
            $effectifs->setUsers($user);
            // on ajoute le nouveau effectifs
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($effectifs);
            $entityManager->flush();
            // on redirige vers la liste des Effectifs (effectifs étant le nom de la route qui liste tous les effectifs dans EffectifsController)
            return $this->redirectToRoute('effectifs_list');
        }

        /* on renvoie à la vue correspondante : 
            - le formulaire
            - le booléen editMode (si vrai, on est dans le cas d'une édition sinon on est dans le cas d'un ajout)
        */
        return $this->render('effectifs/add_edit.html.twig', [
            'formEffectifs' => $form->createView(),
            'editMode' => $effectifs->getId() !== null
        ]);
    }

    // /**
    //  * @Route("/{id}", name="effectifs_show", methods="GET")
    //  */
    // public function show(Effectifs $effectifs): Response
    // {
    //     return $this->render('effectifs/show.html.twig', [
    //         'effectifs' => $effectifs
    //     ]);
    // }
}
