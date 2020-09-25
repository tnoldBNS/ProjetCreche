<?php

namespace App\Controller;

use App\Entity\Enfants;
use App\Entity\Parents;
use App\Entity\Effectifs;
use App\Entity\Pointeuse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\User\UserInterface;
// Include PhpSpreadsheet required namespaces
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @security("is_granted('ROLE_EFFECTIF') or is_granted('ROLE_FAMILLE') or is_granted('ROLE_ADMIN') or is_granted('ROLE_ACCUEIL')")
 */
class PointeuseController extends AbstractController
{
    /**
     * @Route("/pointeuse", name="pointeuse")
     */
    public function index()
    {
    }
    /**
     * @Route("/impression", name="impression")
     * @security("is_granted('ROLE_ADMIN')")
     */
    public function impression()
    {
        
        $impressionEntity = filter_var($_POST["type"], FILTER_SANITIZE_STRING);
        $firstDate = $_POST["FirstDate"];
        $lastDate = $_POST["LastDate"];

        if (!strtotime($firstDate) || !strtotime($lastDate)) {
            return $this->render('home');
        }
        if ($impressionEntity == "enfants") {
            $pointage = $this->getDoctrine()
                ->getRepository(Pointeuse::class)
                ->getAllEnfantsByDate($firstDate, $lastDate);
        }
        if ($impressionEntity == "parents") {
            $pointage = $this->getDoctrine()
                ->getRepository(Pointeuse::class)
                ->getAllParentsByDate($firstDate, $lastDate);
        }
        if ($impressionEntity == "effectifs") {
            $pointage = $this->getDoctrine()
                ->getRepository(Pointeuse::class)
                ->getAllEffectifsByDate($firstDate, $lastDate);
        }

        $spreadsheet = new Spreadsheet();

        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        if ($impressionEntity == "enfants") {
            $line = 1;
            foreach ($pointage as $value) {
                $nom = $value->getEnfants()->getNom();
                $prenom = $value->getEnfants()->getPrenom();
                $dateTimeArrivee = $value->getArrivee();
                $dateTimeDepart = $value->getDepart();
                $sheet->setCellValue("A$line", $nom);
                $sheet->setCellValue("B$line", $prenom);
                $sheet->setCellValue("C$line", $dateTimeArrivee);
                $sheet->setCellValue("D$line", $dateTimeDepart);
                $line++;
            }
        }
        if ($impressionEntity == "parents") {
            $line = 1;
            foreach ($pointage as $value) {
                $nom = $value->getParents()->getNom();
                $prenom = $value->getParents()->getPrenom();
                $dateTimeArrivee = $value->getArrivee();
                $dateTimeDepart = $value->getDepart();
                $sheet->setCellValue("A$line", $nom);
                $sheet->setCellValue("B$line", $prenom);
                $sheet->setCellValue("C$line", $dateTimeArrivee);
                $sheet->setCellValue("D$line", $dateTimeDepart);
                $line++;
            }
        }
        if ($impressionEntity == "effectifs") {
            $line = 1;
            foreach ($pointage as $value) {
                $nom = $value->getEffectifs()->getNom();
                $prenom = $value->getEffectifs()->getPrenom();
                $dateTimeArrivee = $value->getArrivee();
                $dateTimeDepart = $value->getDepart();
                $sheet->setCellValue("A$line", $nom);
                $sheet->setCellValue("B$line", $prenom);
                $sheet->setCellValue("C$line", $dateTimeArrivee);
                $sheet->setCellValue("D$line", $dateTimeDepart);
                $line++;
            }
        }
        $sheet->setTitle("$impressionEntity");
        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        // Create a Temporary file in the system
        $fileName = 'Extraction pointage.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);
        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * 
     * @Route("/pointageEnfants", name="pointageEnfants")
     */
    public function pointageEnfants()
    {
        $enfants = $this->getDoctrine()
            ->getRepository(Enfants::class)
            ->getAllSiDepartNull();

        return $this->render('pointeuse/index.html.twig', [
            'enfants' => $enfants,
        ]);
    }

    /**
     * 
     * @Route("/pointageParents", name="pointageParents")
     */
    public function pointageParents()
    {
        $parents = $this->getDoctrine()
            ->getRepository(Parents::class)
            ->getAll();

        return $this->render('pointeuse/index.html.twig', [
            'parents' => $parents,
        ]);
    }

    /**
     * 
     * @Route("/pointageEffectifs", name="pointageEffectifs")
     */
    public function pointageEffectifs()
    {
        $effectifs = $this->getDoctrine()
            ->getRepository(Effectifs::class)
            ->getAll();

        return $this->render('pointeuse/index.html.twig', [
            'effectifs' => $effectifs,
        ]);
    }

    /**
     * @Route("/{id}/enfants_pointage", name="enfants_pointage")
     */
    public function enfant_pointage(UserInterface $user, AuthorizationCheckerInterface $authChecker, Enfants $enfants)
    {
        if (($enfants && $enfants->getFamilles()->getUsers()->getId() == $user->getId()) || true === $authChecker->isGranted('ROLE_ADMIN') || true === $authChecker->isGranted('ROLE_ACCUEIL')) {
            $pointage = $this->getDoctrine()
                ->getRepository(Pointeuse::class)
                ->getAllByEnfantId($enfants->getId());

            if (!$pointage || $pointage[0]->getDepart()) {
                $pointage = new Pointeuse();
                $pointage->setEnfants($enfants);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($pointage);
                $entityManager->flush();
            } else {
                $dateTimeDepart = new \DateTime();
                $pointage = $pointage[0]->setDepart($dateTimeDepart);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($pointage);
                $entityManager->flush();
            }

            return $this->redirectToRoute('pointageEnfants');
        }
        return $this->redirectToRoute('pointageEnfants');
    }

    /**
     * @Route("/{id}/parents_pointage", name="parents_pointage")
     */
    public function parent_pointage(UserInterface $user, AuthorizationCheckerInterface $authChecker, Parents $parents)
    {
        if (($parents && $parents->getFamilles()->getUsers()->getId() == $user->getId()) || true === $authChecker->isGranted('ROLE_ADMIN') || true === $authChecker->isGranted('ROLE_ACCUEIL')) {
            $pointage = $this->getDoctrine()
                ->getRepository(Pointeuse::class)
                ->getAllByParentId($parents->getId());

            if (!$pointage || $pointage[0]->getDepart()) {
                $pointage = new Pointeuse();
                $pointage->setParents($parents);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($pointage);
                $entityManager->flush();
            } else {
                $dateTimeDepart = new \DateTime();
                $pointage = $pointage[0]->setDepart($dateTimeDepart);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($pointage);
                $entityManager->flush();
            }
            return $this->redirectToRoute('pointageParents');
        }
        return $this->redirectToRoute('pointageParents');
    }

    /**
     * @Route("/{id}/effectifs_pointage", name="effectifs_pointage")
     */
    public function effectif_pointage(UserInterface $user, AuthorizationCheckerInterface $authChecker, Effectifs $effectifs)
    {
        if (($effectifs && $effectifs->getUsers()->getId() == $user->getId()) && true === $authChecker->isGranted('ROLE_ADMIN') || true === $authChecker->isGranted('ROLE_ACCUEIL')) {
            $pointage = $this->getDoctrine()
                ->getRepository(Pointeuse::class)
                ->getAllByEffectifId($effectifs->getId());

            if (!$pointage || $pointage[0]->getDepart()) {
                $pointage = new Pointeuse();
                $pointage->setEffectifs($effectifs);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($pointage);
                $entityManager->flush();
            } else {
                $dateTimeDepart = new \DateTime();
                $pointage = $pointage[0]->setDepart($dateTimeDepart);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($pointage);
                $entityManager->flush();
            }
            return $this->redirectToRoute('pointageEffectifs');
        }
        return $this->redirectToRoute('pointageEffectifs');
    }
}
