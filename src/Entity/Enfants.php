<?php

namespace App\Entity;

use App\Entity\Absences;
use App\Entity\Familles;
use App\Entity\Pointeuse;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EnfantsRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=EnfantsRepository::class)
 * @Vich\Uploadable
 */
class Enfants
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
    private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationnalit;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="date")
     */
    private $dateArrivee;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDepart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieuNaissance;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rgpd;

    /**
     * @ORM\ManyToOne(targetEntity=Familles::class, inversedBy="enfants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $familles;

    /**
     * @ORM\OneToMany(targetEntity=Pointeuse::class, mappedBy="enfants")
     */
    private $pointeuse;

    /**
     * @ORM\OneToMany(targetEntity=Absences::class, mappedBy="enfants")
     */
    private $absences;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Commissions::class, inversedBy="enfants")
     */
    private $commissions;

    /**
     * @ORM\ManyToMany(targetEntity=Galleries::class, mappedBy="enfants")
     */
    private $galleries;

    public function __construct($familles_id)
    {
        $this->familles = $familles_id;
        $this->pointeuse = new ArrayCollection();
        $this->absences = new ArrayCollection();
        $this->galleries = new ArrayCollection();
   
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

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getNationnalit(): ?string
    {
        return $this->nationnalit;
    }

    public function setNationnalit(string $nationnalit): self
    {
        $this->nationnalit = $nationnalit;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getDateArrivee(): ?\DateTimeInterface
    {
        return $this->dateArrivee;
    }

    public function setDateArrivee(\DateTimeInterface $dateArrivee): self
    {
        $this->dateArrivee = $dateArrivee;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(?\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getRgpd(): ?bool
    {
        return $this->rgpd;
    }

    public function setRgpd(bool $rgpd): self
    {
        $this->rgpd = $rgpd;

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
            $pointeuse->setEnfants($this);
        }

        return $this;
    }

    public function removePointeuse(Pointeuse $pointeuse): self
    {
        if ($this->pointeuse->contains($pointeuse)) {
            $this->pointeuse->removeElement($pointeuse);
            // set the owning side to null (unless already changed)
            if ($pointeuse->getEnfants() === $this) {
                $pointeuse->setEnfants(null);
            }
        }

        return $this;
    }

    public function getLastPointeuse()
    {
        return $this->pointeuse->last();
    }

    /**
     * @return Collection|Absences[]
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Absences $absence): self
    {
        if (!$this->absences->contains($absence)) {
            $this->absences[] = $absence;
            $absence->setEnfants($this);
        }

        return $this;
    }

    public function removeAbsence(Absences $absence): self
    {
        if ($this->absences->contains($absence)) {
            $this->absences->removeElement($absence);
            // set the owning side to null (unless already changed)
            if ($absence->getEnfants() === $this) {
                $absence->setEnfants(null);
            }
        }

        return $this;
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


    public function getCommissions(): ?Commissions
    {
        return $this->commissions;
    }

    public function setCommissions(?Commissions $commissions): self
    {
        $this->commissions = $commissions;

        return $this;
    }

    /**
     * @return Collection|Galleries[]
     */
    public function getGalleries(): Collection
    {
        return $this->galleries;
    }

    public function addGallery(Galleries $gallery): self
    {
        if (!$this->galleries->contains($gallery)) {
            $this->galleries[] = $gallery;
            $gallery->addEnfant($this);
        }

        return $this;
    }

    public function removeGallery(Galleries $gallery): self
    {
        if ($this->galleries->contains($gallery)) {
            $this->galleries->removeElement($gallery);
            $gallery->removeEnfant($this);
        }

        return $this;
    }





}
