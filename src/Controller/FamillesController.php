<?php

namespace App\Controller;

use App\Entity\Enfants;
use App\Entity\Parents;
use App\Entity\Familles;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FamillesController extends AbstractController
{
    /**
     * @Route("/familles", name="familles")
     */
    public function index(UserInterface $user)
    {
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
