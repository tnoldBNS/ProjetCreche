<?php

namespace App\Controller;

use App\Entity\Themes;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum")
     */
    public function index()
    {
        $themes = $this->getDoctrine()
        ->getRepository(Themes::class)
        ->getAll();


        return $this->render('forum/index.html.twig', [
            'themes' => $themes,
        ]);
    }
}