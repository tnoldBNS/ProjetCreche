<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SondagesController extends AbstractController
{
    /**
     * @Route("/sondages", name="sondages")
     */
    public function index()
    {
        return $this->render('sondages/index.html.twig', [
            'controller_name' => 'SondagesController',
        ]);
    }
}
