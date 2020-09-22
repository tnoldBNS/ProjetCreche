<?php

namespace App\Entity;

use App\Repository\CommissionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommissionsRepository::class)
 */
class Commissions
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
    private $nomCommission;

    /**
     * @ORM\ManyToMany(targetEntity=Tickets::class, mappedBy="commissions")
     */
    private $tickets;

    /**
     * @ORM\OneToMany(targetEntity=Enfants::class, mappedBy="commissions")
     */
    private $enfants;

    public function __construct()
    {
        $this->parents = new ArrayCollection();
        $this->tickets = new ArrayCollection();
        $this->enfants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCommission(): ?string
    {
        return $this->nomCommission;
    }

    public function setNomCommission(string $nomCommission): self
    {
        $this->nomCommission = $nomCommission;

        return $this;
    }

    public function getFamilles(): ?Familles
    {
        return $this->familles;
    }

    public function setFamilles(?Familles $familles): self
    {
        $this->familles = $familles;

        return $this;
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
            $parent->addCommission($this);
        }

        return $this;
    }

    public function removeParent(Parents $parent): self
    {
        if ($this->parents->contains($parent)) {
            $this->parents->removeElement($parent);
            $parent->removeCommission($this);
        }

        return $this;
    }

    /**
     * @return Collection|Tickets[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Tickets $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->addCommission($this);
        }

        return $this;
    }

    public function removeTicket(Tickets $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            $ticket->removeCommission($this);
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
        }

        return $this;
    }

    public function removeEnfant(Enfants $enfant): self
    {
        if ($this->enfants->contains($enfant)) {
            $this->enfants->removeElement($enfant);
        }

        return $this;
    }
}
