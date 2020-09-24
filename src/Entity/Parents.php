<?php

namespace App\Entity;

use App\Entity\Familles;
use App\Entity\Pointeuse;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ParentsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ParentsRepository::class)
 * @Vich\Uploadable
 */
class Parents
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

        /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $nomImage;

    /**
     * @var File|null
     * * @Vich\UploadableField(mapping="nomImage_image", fileNameProperty="nomImage")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $langueMaternelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\ManyToOne(targetEntity=Familles::class, inversedBy="parents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $familles;

    /**
     * @ORM\OneToMany(targetEntity=Pointeuse::class, mappedBy="parents")
     */
    private $pointeuse;

    /**
    * @ORM\Column(type="datetime")
    */
    private $updated_at;

    public function __construct($familles_id)
    {
        $this->familles = $familles_id;
        $this->pointeuse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getLangueMaternelle(): ?string
    {
        return $this->langueMaternelle;
    }

    public function setLangueMaternelle(string $langueMaternelle): self
    {
        $this->langueMaternelle = $langueMaternelle;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresseComplette(): ?string
    {
        return $this->adresse . " " . $this->cp . " " . $this->ville;
    }
    
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

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
     * @return Collection|Pointeuse[]
     */
    public function getPointeuse(): Collection
    {
        return $this->pointeuse;
    }

    public function addPointeuse(Pointeuse $pointeuse): self
    {
        if (!$this->pointeuse->contains($pointeuse)) {
            $this->pointeuse[] = $pointeuse;
            $pointeuse->setParents($this);
        }

        return $this;
    }

    public function removePointeuse(Pointeuse $pointeuse): self
    {
        if ($this->pointeuse->contains($pointeuse)) {
            $this->pointeuse->removeElement($pointeuse);
            // set the owning side to null (unless already changed)
            if ($pointeuse->getParents() === $this) {
                $pointeuse->setParents(null);
            }
        }

        return $this;
    }

    public function getLastPointeuse()
    {
        return $this->pointeuse->last();
    }

    public function __toString() 
    {
        return $this->nom." ".$this->prenom;
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
        
        if ($this->imageFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }

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
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }
    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}
