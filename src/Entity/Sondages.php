<?php

namespace App\Entity;

use App\Repository\SondagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SondagesRepository::class)
 */
class Sondages
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
    private $titre;

    /**
     * @ORM\OneToMany(targetEntity=Reponses::class, mappedBy="sondages")
     */
    private $Reponses;

    public function __construct()
    {
        $this->Reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return Collection|Reponses[]
     */
    public function getReponses(): Collection
    {
        return $this->Reponses;
    }

    public function addReponse(Reponses $reponse): self
    {
        if (!$this->Reponses->contains($reponse)) {
            $this->Reponses[] = $reponse;
            $reponse->setSondages($this);
        }

        return $this;
    }

    public function removeReponse(Reponses $reponse): self
    {
        if ($this->Reponses->contains($reponse)) {
            $this->Reponses->removeElement($reponse);
            // set the owning side to null (unless already changed)
            if ($reponse->getSondages() === $this) {
                $reponse->setSondages(null);
            }
        }

        return $this;
    }
}
