<?php

namespace App\Entity;

use App\Entity\Enfants;
use App\Entity\Parents;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FamillesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=FamillesRepository::class)
 */
class Familles
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Parents::class, mappedBy="familles")
     */
    private $parents;

    /**
     * @ORM\OneToMany(targetEntity=Enfants::class, mappedBy="familles")
     */
    private $enfants;

    /**
     * @ORM\OneToOne(targetEntity=Users::class, inversedBy="familles", cascade={"persist", "remove"})
     */
    private $Users;

    public function __construct($user_id)
    {
        $this->Users = $user_id;
        $this->parents = new ArrayCollection();
        $this->enfants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Parents[]
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(Parents $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents[] = $parent;
            $parent->setFamilles($this);
        }

        return $this;
    }

    public function removeParent(Parents $parent): self
    {
        if ($this->parents->contains($parent)) {
            $this->parents->removeElement($parent);
            // set the owning side to null (unless already changed)
            if ($parent->getFamilles() === $this) {
                $parent->setFamilles(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Enfants[]
     */
    public function getEnfants(): Collection
    {
        return $this->enfants;
    }

    public function addEnfant(Enfants $enfant): self
    {
        if (!$this->enfants->contains($enfant)) {
            $this->enfants[] = $enfant;
            $enfant->setFamilles($this);
        }

        return $this;
    }

    public function removeEnfant(Enfants $enfant): self
    {
        if ($this->enfants->contains($enfant)) {
            $this->enfants->removeElement($enfant);
            // set the owning side to null (unless already changed)
            if ($enfant->getFamilles() === $this) {
                $enfant->setFamilles(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->Users;
    }

    public function setUsers(?Users $Users): self
    {
        $this->Users = $Users;

        return $this;
    }
}
