<?php

namespace App\Controller;

use App\Entity\Enfants;
use App\Entity\Parents;
use App\Entity\Familles;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * @security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")
 */
class FamillesController extends AbstractController
{
    /**
     * @Route("/familles", name="familles")
     */
    public function index(UserInterface $user, AuthorizationCheckerInterface $authChecker)
    {
        if (false === $authChecker->isGranted('ROLE_FAMILLE')) {
            if (true === $authChecker->isGranted('ROLE_ADMIN')) {
                $enfants = $this->getDoctrine()
                    ->getRepository(Enfants::class)
                    ->getAll();

                $parents = $this->getDoctrine()
                    ->getRepository(Parents::class)
                    ->getAll();

                return $this->render('familles\index.html.twig', [
                    'enfants' => $enfants,
                    'parents' => $parents,
                ]);
            }
            return $this->render('familles\index.html.twig');
        }

        $enfants = $this->getDoctrine()
            ->getRepository(Enfants::class)
            ->getAllByFamille($user->getFamilles());

        $parents = $this->getDoctrine()
            ->getRepository(Parents::class)
            ->getAllByFamille($user->getFamilles());

        $familles = $this->getDoctrine()
            ->getRepository(Familles::class)
            ->getFamilleByIdUser($user = $this->getUser());

        if (!$familles) {
            $familles = new Familles($user = $this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($familles);
            $entityManager->flush();
        }
        return $this->render('familles\index.html.twig', [
            'enfants' => $enfants,
            'parents' => $parents,
        ]);
    }
}
