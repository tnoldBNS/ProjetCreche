<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReponsesController extends AbstractController
{
    /**
     * @Route("/reponses", name="reponses")
     */
    public function index()
    {
        return $this->render('reponses/index.html.twig', [
            'controller_name' => 'ReponsesController',
        ]);
    }
}
