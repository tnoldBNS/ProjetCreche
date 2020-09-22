<?php

namespace App\Entity;

use App\Entity\Enfants;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GalleriesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=GalleriesRepository::class)
 * * @Vich\Uploadable
 */
class Galleries
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
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
    private $description;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $nomImage;

    /**
     * @var File|null
     * * @Vich\UploadableField(mapping="nomGallerie_image", fileNameProperty="nomImage")
     */
    private $imageFile;


    /**
     * @ORM\Column(type="datetime")
     */
    private $creaDate;

    /**
     * @ORM\ManyToMany(targetEntity=Enfants::class, inversedBy="galleries")
     */
    private $enfants;

   

    public function __construct()
    {
        $this->enfants = new ArrayCollection();
        $this->creaDate = new \DateTime('now');

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of imageFile
     *
     * @return  File|null
     */ 
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @param  File|null  $imageFile
     *
     * @return  self
     */ 
    public function setImageFile($imageFile): self
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    /**
     * Get the value of nomImage
     *
     * @return  string|null
     */ 
    public function getNomImage()
    {
        return $this->nomImage;
    }

    /**
     * Set the value of nomImage
     *
     * @param  string|null  $nomImage
     *
     * @return  self
     */ 
    public function setNomImage($nomImage)
    {
        $this->nomImage = $nomImage;
        return $this;
    }

    public function getCreaDate(): ?\DateTimeInterface
    {
        return $this->creaDate;
    }

    public function setCreaDate(\DateTimeInterface $creaDate): self
    {
        $this->creaDate = $creaDate;

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

    public function getCheckRGPD(){
        $check = $this->enfants->filter(function($enfant){
            return $enfant->getRgpd() != true;
        });

        return count($check) > 0 ? false : true;
    }
    
   
}
