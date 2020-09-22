<?php

namespace App\Entity;

use App\Repository\TransmissionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransmissionRepository::class)
 */
class Transmission
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
    private $type;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=Pointeuse::class, inversedBy="transmission")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pointeuse;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getPointeuse(): ?Pointeuse
    {
        return $this->pointeuse;
    }

    public function setPointeuse(?Pointeuse $pointeuse): self
    {
        $this->pointeuse = $pointeuse;

        return $this;
    }
    public function __toString() 
    {
        return $this->contenu;
    }
}
