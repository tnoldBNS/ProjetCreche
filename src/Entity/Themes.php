<?php

namespace App\Entity;

use App\Repository\ThemesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThemesRepository::class)
 */
class Themes
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
    private $nomTheme;

    /**
     * @ORM\OneToMany(targetEntity=Sujets::class, mappedBy="themes")
     */
    private $sujets;

    public function __construct()
    {
        $this->sujets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTheme(): ?string
    {
        return $this->nomTheme;
    }

    public function setNomTheme(string $nomTheme): self
    {
        $this->nomTheme = $nomTheme;

        return $this;
    }

    /**
     * @return Collection|Sujets[]
     */
    public function getSujets(): Collection
    {
        return $this->sujets;
    }

    public function addSujet(Sujets $sujet): self
    {
        if (!$this->sujets->contains($sujet)) {
            $this->sujets[] = $sujet;
            $sujet->setThemes($this);
        }

        return $this;
    }

    public function removeSujet(Sujets $sujet): self
    {
        if ($this->sujets->contains($sujet)) {
            $this->sujets->removeElement($sujet);
            // set the owning side to null (unless already changed)
            if ($sujet->getThemes() === $this) {
                $sujet->setThemes(null);
            }
        }

        return $this;
    }
    public function __toString() 
    {
        return $this->nomTheme;
    }
}
