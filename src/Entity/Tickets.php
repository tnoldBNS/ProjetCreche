<?php

namespace App\Entity;

use App\Repository\TicketsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TicketsRepository::class)
 */
class Tickets
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
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="tickets")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=Commissions::class, inversedBy="tickets")
     */
    private $commissions;

    public function __construct()
    {
        $this->commissions = new ArrayCollection();
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

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection|Commissions[]
     */
    public function getCommissions(): Collection
    {
        return $this->commissions;
    }

    public function addCommission(Commissions $commission): self
    {
        if (!$this->commissions->contains($commission)) {
            $this->commissions[] = $commission;
        }

        return $this;
    }

    public function removeCommission(Commissions $commission): self
    {
        if ($this->commissions->contains($commission)) {
            $this->commissions->removeElement($commission);
        }

        return $this;
    }
}
