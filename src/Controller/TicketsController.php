<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Commissions;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @security("is_granted('ROLE_USER')")
 */
class TicketsController extends AbstractController
{
    /**
     * @Route("/email")
     * @security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN') or is_granted('ROLE_EFFECTIF')")
     */
    public function sendEmail(MailerInterface $mailer)
    {
        $message = $_POST["user_message"];
        $user_id = $this->getUser()->getId();
        $commission_id = $_POST["id_commission"];
        
        $commission_email = $this->getDoctrine()
                ->getRepository(Commissions::class)
                ->getAllEmailByCommission($commission_id);
                

        foreach ($commission_email as $key => $arr) {
            foreach ($arr as $key => $value) {
                    $array[] = $value;   
            }
        }       
        
        $email = (new Email())
            ->from('info@creche-lasourisverte.eu')
            ->to(...$array)
            ->subject('Commissions Crèche la Souris Verte')
            ->text(' ')
            ->html("$message");
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            echo "erreur d'envoi";
        };
        return $this->redirectToRoute('commissions');
    }

     /**
     * @Route("/emailAcces")
     */
    public function sendEmailForRequestAcces(MailerInterface $mailer)
    {
        $message = $_POST["user_message"];
        $user_id = $this->getUser()->getId();
        $espace = $_POST["espace"];

        $admin_email = $this->getDoctrine()
                ->getRepository(Users::class)
                ->getAllEmailWhereAdmin();
                      
        foreach ($admin_email as $key => $arr) {
            foreach ($arr as $key => $value) {
                    $array1[] = $value;   
            }
        }       
        
        $email = (new Email())
            ->from('info@creche-lasourisverte.eu')
            ->to(...$array1)
            ->subject("Demande d'acces espace reservé appli Souris Verte")
            ->text(' ')
            ->html("l'utilisateur $user_id, demande l'acces à l'espace : $espace avec le message suivant : <br>
            <p>$message</p>");
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            echo "erreur d'envoi";
        };
        return $this->redirectToRoute('home');
    }
}