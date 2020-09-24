<?php

namespace App\Controller;

use App\Entity\Enfants;
use App\Form\EnfantsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/enfants")
 * @security("is_granted('ROLE_FAMILLE') or is_granted('ROLE_ADMIN')")
 * 
 */
class EnfantsController extends AbstractController
{
    /**
     * @Route("/", name="enfants")
     */
    public function index()
    {

        echo "reussi";
        die;
        $enfants = $this->getDoctrine()
            ->getRepository(Enfants::class)
            ->getAll();

        return $this->render('enfants/index.html.twig', [
            'enfants' => $enfants,
        ]);
    }

    /**
     * @Route("/{id}/deleteEnfants", name="enfants_delete")
     */
    public function delete(UserInterface $user, AuthorizationCheckerInterface $authChecker, Enfants $enfants)
    {
        if ($enfants->getFamilles()->getUsers()->getId() == $user->getId() || true === $authChecker->isGranted('ROLE_ADMIN')) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($enfants);
            $entityManager->flush();
        } else {
        }
        return $this->redirectToRoute('familles');
    }


    /**
     * @Route("/addEnfant", name="enfants_add")
     * @Route("/{id}/editEnfant", name="enfants_edit")
     */
    public function add_edit(UserInterface $user, AuthorizationCheckerInterface $authChecker, Enfants $enfants = null, Request $request)
    {
        if (($enfants && $enfants->getFamilles()->getUsers()->getId() != $user->getId()) && false === $authChecker->isGranted('ROLE_ADMIN')) {     
            return $this->redirectToRoute('familles');
        }

        // si le Enfant n'existe pas, on instancie un nouveau Enfant (on est dans le cas d'un ajout)
        if (!$enfants) {
            $enfants = new Enfants($user->getFamilles());
        }

        // il faut créer un EnfantsType au préalable (php bin/console make:form
        $form = $this->createForm(EnfantsType::class, $enfants);

        $form->handleRequest($request);
        // si on soumet le formulaire et que le form est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère les données du formulaire
            $enfants = $form->getData();

            // on ajoute le nouvel enfant
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enfants);
            $entityManager->flush();
            // on redirige vers la liste des enfants (Enfants_list étant le nom de la route qui liste tous les enfants dans EnfantsController)
            return $this->redirectToRoute('familles');
        }

        /* on renvoie à la vue correspondante : 
            - le formulaire
            - le booléen editMode (si vrai, on est dans le cas d'une édition sinon on est dans le cas d'un ajout)
        */
        return $this->render('enfants/add_edit.html.twig', [
            'formEnfants' => $form->createView(),
            'editMode' => $enfants->getId() !== null
        ]);
    }
}
