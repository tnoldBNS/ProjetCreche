<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessagesRepository::class)
 */
class Messages
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=Sujets::class, inversedBy="messages")
     */
    private $sujets;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="messages")
     */
    private $Users;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreaDate;

    /**
     * @ORM\OneToOne(targetEntity=Sondages::class, cascade={"persist", "remove"})
     */
    private $Sondages;

    public function __construct($user, $sujet)
    {
        $this->Users = $user;
        $this->sujets = $sujet;
        $this->CreaDate = new \DateTime();
        $this->Sondages = null;
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

    public function getSujets(): ?Sujets
    {
        return $this->sujets;
    }

    public function setSujets(?Sujets $sujets): self
    {
        $this->sujets = $sujets;

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

    public function getCreaDate(): ?\DateTimeInterface
    {
        return $this->CreaDate;
    }

    public function setCreaDate(\DateTimeInterface $CreaDate): self
    {
        $this->CreaDate = $CreaDate;

        return $this;
    }

    public function getSondages(): ?Sondages
    {
        return $this->Sondages;
    }

    public function setSondages(?Sondages $Sondages): self
    {
        $this->Sondages = $Sondages;

        return $this;
    }
}
