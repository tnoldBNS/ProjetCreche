<?php

namespace App\Entity;

use App\Repository\AbsencesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbsencesRepository::class)
 */
class Absences
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motif;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    /**
     * @ORM\ManyToOne(targetEntity=Effectifs::class, inversedBy="absences")
     */
    private $effectifs;

    /**
     * @ORM\ManyToOne(targetEntity=Enfants::class, inversedBy="absences")
     */
    private $enfants;

    
    public function __construct($user = null)
    {
        if ($user != null) {
            $this->user = $user;
    }
                
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getEffectifs(): ?Effectifs
    {
        return $this->effectifs;
    }

    public function setEffectifs(?Effectifs $effectifs): self
    {
        $this->effectifs = $effectifs;

        return $this;
    }

    public function getEnfants(): ?Enfants
    {
        return $this->enfants;
    }

    public function setEnfants(?Enfants $enfants): self
    {
        $this->enfants = $enfants;

        return $this;
    }
    public function getUser()
    {
        return $this->user;
    }
}
