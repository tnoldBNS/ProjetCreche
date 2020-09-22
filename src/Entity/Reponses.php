<?php

namespace App\Entity;

use App\Repository\ReponsesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReponsesRepository::class)
 */
class Reponses
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
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=Sondages::class, inversedBy="Reponses")
     */
    private $sondages;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, inversedBy="reponses")
     */
    private $Users;

    public function __construct()
    {
        $this->Users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSondages(): ?Sondages
    {
        return $this->sondages;
    }

    public function setSondages(?Sondages $sondages): self
    {
        $this->sondages = $sondages;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getUsers(): Collection
    {
        return $this->Users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->Users->contains($user)) {
            $this->Users[] = $user;
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->Users->contains($user)) {
            $this->Users->removeElement($user);
        }

        return $this;
    }
}
