<?php

namespace App\Controller;

use App\Entity\Effectifs;
use App\Form\EffectifsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
* @security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
*/
class EffectifsController extends AbstractController
{
    /**
     * @Route("/effectifs", name="effectifs_list")
     */
    public function index(UserInterface $user, AuthorizationCheckerInterface $authChecker)
    {
        if (false === $authChecker->isGranted('ROLE_EFFECTIF')) {
            if (true === $authChecker->isGranted('ROLE_ADMIN')) {
                $effectifs = $this->getDoctrine()
                    ->getRepository(Effectifs::class)
                    ->getAll();

                return $this->render('effectifs/index.html.twig', [
                    'effectifs' => $effectifs,
                ]);
            }
            return $this->render('effectifs/index.html.twig');
        }

        $effectifs = $this->getDoctrine()
            ->getRepository(Effectifs::class)
            ->getAllByIdUser($user->getId());

        return $this->render('effectifs/index.html.twig', [
            'effectifs' => $effectifs,
        ]);
    }

    /**
     * @Route("/{id}/deleteEffectifs", name="effectifs_delete")
     */
    public function delete(UserInterface $user, AuthorizationCheckerInterface $authChecker, Effectifs $effectifs)
    {
        if ($effectifs->getUsers()->getId() != $user->getId() || true === $authChecker->isGranted('ROLE_ADMIN')) {
        $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($effectifs);
            $entityManager->flush();
        } else {
        }
        return $this->redirectToRoute('effectifs_list');
    }

    /**
     * @Route("/add", name="effectifs_add")
     * @Route("/{id}/edit", name="effectifs_edit")
     */
    public function add_edit(UserInterface $user, AuthorizationCheckerInterface $authChecker, Effectifs $effectifs = null, Request $request)
    {

        if (($effectifs && $effectifs->getUsers()->getId() != $user->getId()) && false === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('effectifs_list');
        }

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
}
