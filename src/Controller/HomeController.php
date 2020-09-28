<?php

namespace App\Controller;

use App\Entity\Galleries;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @security("is_granted('ROLE_USER')")
     */
    public function index(AuthorizationCheckerInterface $authChecker)
    {
        if (true === $authChecker->isGranted('ROLE_ADMIN') || true === $authChecker->isGranted('ROLE_EFFECTIF') || true === $authChecker->isGranted('ROLE_FAMILLE') || true === $authChecker->isGranted('ROLE_ACCUEIL')) {     
          $galleries = $this->getDoctrine()
        ->getRepository(Galleries::class)
        ->getAllRgpdIfNoAlbum(); 

        return $this->render('home/accueil.html.twig', [
            'galleries' => $galleries,
        ]);
        }
        return $this->render('home/accueil.html.twig');
        
    }
 
    /**
     * @Route("/mentions", name="mentions")
     */
    public function mentions()
    {
        return $this->render('home/mentions.html.twig');
    }
    
}
