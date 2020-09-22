<?php

namespace App\Entity;

use App\Repository\PointeuseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PointeuseRepository::class)
 */
class Pointeuse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $arrivee;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $depart;

    /**
     * @ORM\ManyToOne(targetEntity=Effectifs::class, inversedBy="pointeuse")
     */
    private $effectifs;

    /**
     * @ORM\ManyToOne(targetEntity=Parents::class, inversedBy="pointeuse")
     */
    private $parents;

    /**
     * @ORM\ManyToOne(targetEntity=Enfants::class, inversedBy="pointeuse")
     */
    private $enfants;

    /**
     * @ORM\OneToMany(targetEntity=Transmission::class, mappedBy="pointeuse")
     */
    private $transmission;

    public function __construct()
    {
        //ajouter date et heure courante
        $this->arrivee = new \DateTime();
        $this->transmission = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArrivee(): ?\DateTimeInterface
    {
        return $this->arrivee;
    }

    public function setArrivee(\DateTimeInterface $arrivee): self
    {
        $this->arrivee = $arrivee;

        return $this;
    }

    public function getDepart(): ?\DateTimeInterface
    {
        return $this->depart;
    }

    public function setDepart(?\DateTimeInterface $depart): self
    {
        $this->depart = $depart;

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

    public function getParents(): ?Parents
    {
        return $this->parents;
    }

    public function setParents(?Parents $parents): self
    {
        $this->parents = $parents;

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

    /**
     * @return Collection|Transmission[]
     */
    public function getTransmission(): Collection
    {
        return $this->transmission;
    }

    public function addTransmission(Transmission $transmission): self
    {
        if (!$this->transmission->contains($transmission)) {
            $this->transmission[] = $transmission;
            $transmission->setPointeuse($this);
        }

        return $this;
    }

    public function removeTransmission(Transmission $transmission): self
    {
        if ($this->transmission->contains($transmission)) {
            $this->transmission->removeElement($transmission);
            // set the owning side to null (unless already changed)
            if ($transmission->getPointeuse() === $this) {
                $transmission->setPointeuse(null);
            }
        }

        return $this;
    }

    public function getLastTransmission()
    {
        return $this->transmission->last();
    }
}
