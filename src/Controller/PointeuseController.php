<?php

namespace App\Controller;

use App\Entity\Enfants;
use App\Entity\Parents;
use App\Entity\Effectifs;
use App\Entity\Pointeuse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @security("is_granted('ROLE_EFFECTIF') or is_granted('ROLE_FAMILLE') or is_granted('ROLE_ADMIN') or is_granted('ROLE_ACCUEIL')")
 */
class PointeuseController extends AbstractController
{
    /**
     * @Route("/pointeuse", name="pointeuse")
     */
    public function index()
    {
    }

    /**
     * 
     * @Route("/pointageEnfants", name="pointageEnfants")
     */
    public function pointageEnfants()
    {
        $enfants = $this->getDoctrine()
            ->getRepository(Enfants::class)
            ->getAllSiDepartNull();  

        return $this->render('pointeuse/index.html.twig', [
            'enfants' => $enfants,
        ]);
    }

        /**
     * 
     * @Route("/pointageParents", name="pointageParents")
     */
    public function pointageParents()
    {
        $parents = $this->getDoctrine()
            ->getRepository(Parents::class)
            ->getAll();

        return $this->render('pointeuse/index.html.twig', [
            'parents' => $parents,
        ]);
    }

     /**
     * 
     * @Route("/pointageEffectifs", name="pointageEffectifs")
     */
    public function pointageEffectifs()
    {
        $effectifs = $this->getDoctrine()
            ->getRepository(Effectifs::class)
            ->getAll();

        return $this->render('pointeuse/index.html.twig', [
            'effectifs' => $effectifs,
        ]);
    }

    /**
     * @Route("/{id}/enfants_pointage", name="enfants_pointage")
     */
    public function enfant_pointage(UserInterface $user, AuthorizationCheckerInterface $authChecker, Enfants $enfants)
    {
        if (($enfants && $enfants->getFamilles()->getUsers()->getId() != $user->getId()) && (false === $authChecker->isGranted('ROLE_ADMIN') || false === $authChecker->isGranted('ROLE_ACCUEIL')) ) {     
            return $this->redirectToRoute('pointageEnfants');
        }
        
        $pointage = $this->getDoctrine()
        ->getRepository(Pointeuse::class)
        ->getAllByEnfantId($enfants->getId());

        if (!$pointage || $pointage[0]->getDepart()) {
            $pointage = new Pointeuse();
            $pointage->setEnfants($enfants);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pointage);
            $entityManager->flush();
        } else {
            $dateTimeDepart = new \DateTime();
            $pointage = $pointage[0]->setDepart($dateTimeDepart);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pointage);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('pointageEnfants');
    }

        /**
     * @Route("/{id}/parents_pointage", name="parents_pointage")
     */
    public function parent_pointage(UserInterface $user, AuthorizationCheckerInterface $authChecker, Parents $parents)
    {
        if (($parents && $parents->getFamilles()->getUsers()->getId() != $user->getId()) && (false === $authChecker->isGranted('ROLE_ADMIN') || false === $authChecker->isGranted('ROLE_ACCUEIL')) ) {     
            return $this->redirectToRoute('pointageParents');
        }
        $pointage = $this->getDoctrine()
        ->getRepository(Pointeuse::class)
        ->getAllByParentId($parents->getId());

        if (!$pointage || $pointage[0]->getDepart()) {
            $pointage = new Pointeuse();
            $pointage->setParents($parents);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pointage);
            $entityManager->flush();
        } else {
            $dateTimeDepart = new \DateTime();
            $pointage = $pointage[0]->setDepart($dateTimeDepart);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pointage);
            $entityManager->flush();
        }
        return $this->redirectToRoute('pointageParents');
    }

        /**
     * @Route("/{id}/effectifs_pointage", name="effectifs_pointage")
     */
    public function effectif_pointage(UserInterface $user, AuthorizationCheckerInterface $authChecker, Effectifs $effectifs)
    {
        if (($effectifs && $effectifs->getUsers()->getId() != $user->getId()) && (false === $authChecker->isGranted('ROLE_ADMIN') || false === $authChecker->isGranted('ROLE_ACCUEIL')) ) {     
            return $this->redirectToRoute('pointageEffectifs');
        }
        $pointage = $this->getDoctrine()
        ->getRepository(Pointeuse::class)
        ->getAllByEffectifId($effectifs->getId());

        if (!$pointage || $pointage[0]->getDepart()) {
            $pointage = new Pointeuse();
            $pointage->setEffectifs($effectifs);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pointage);
            $entityManager->flush();
        } else {
            $dateTimeDepart = new \DateTime();
            $pointage = $pointage[0]->setDepart($dateTimeDepart);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pointage);
            $entityManager->flush();
        }
        return $this->redirectToRoute('pointageEffectifs');
    }
}

