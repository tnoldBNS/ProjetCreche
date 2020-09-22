<?php

namespace App\Controller;

use App\Entity\Pointeuse;
use App\Entity\Transmission;
use App\Form\TransmissionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TransmissionController extends AbstractController
{
    /**
     * @Route("/transmission", name="transmission")
     */
    public function index()
    {
        $pointeuse_id = $_POST["id_lastPointeuse"];
        $contenu = $_POST["user_message"];
        $type = $_POST["type"];
        $pointeuse = $this->getDoctrine()
            ->getRepository(Pointeuse::class)
            ->getPointeuseById($pointeuse_id);
        $transmission = new Transmission();
        $transmission->setPointeuse($pointeuse[0]);
        $transmission->setContenu($contenu);
        $transmission->setType($type);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($transmission);
        $entityManager->flush();
        return $this->redirectToRoute('pointageEnfants');
    }
}
