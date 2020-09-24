<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @security("is_granted('ROLE_EFFECTIF') or is_granted('ROLE_FAMILLE') or is_granted('ROLE_ADMIN') or is_granted('ROLE_ACCUEIL')")
 */
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
