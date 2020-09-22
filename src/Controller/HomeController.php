<?php

namespace App\Controller;

use App\Entity\Galleries;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $galleries = $this->getDoctrine()
        ->getRepository(Galleries::class)
        ->getAllRgpd();

        // return $this->render('home/accueil.html.twig');
        return $this->render('home/accueil.html.twig', [
            'galleries' => $galleries,
        ]);
    }
 
    /**
     * @Route("/mentions", name="mentions")
     */
    public function mentions()
    {
        return $this->render('home/mentions.html.twig');
    }
    
}
