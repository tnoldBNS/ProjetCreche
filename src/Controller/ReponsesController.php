<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @security("is_granted('ROLE_EFFECTIF') or is_granted('ROLE_FAMILLE') or is_granted('ROLE_ADMIN') or is_granted('ROLE_ACCUEIL')")
 */
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
