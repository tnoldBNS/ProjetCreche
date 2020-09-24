<?php

namespace App\Entity;

use App\Entity\Users;
use App\Entity\Absences;
use App\Entity\Pointeuse;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EffectifsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=EffectifsRepository::class)
 * @Vich\Uploadable
 */
class Effectifs
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
     * @ORM\Column(type="string", length=50)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne peut pas contenir de nombre"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre prénom ne peut pas contenir de nombre"
     * )
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Regex(
     *     pattern="/[a-zA-Z]/",
     *     match=false,
     *     message="Votre code-postal ne peut contenir que des chiffres"
     * )
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="le nom de votre ville ne peut pas contenir de chiffre"
     * )
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity=Pointeuse::class, mappedBy="effectifs")
     */
    private $pointeuse;

    /**
     * @ORM\OneToMany(targetEntity=Absences::class, mappedBy="effectifs")
     */
    private $absences;

    /**
     * @ORM\OneToOne(targetEntity=Users::class, inversedBy="effectifs", cascade={"persist", "remove"})
     */
    private $Users;

    /**
    * @ORM\Column(type="datetime")
    */
    private $updated_at;

    public function __construct()
    {
        $this->pointeuse = new ArrayCollection();
        $this->absences = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

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

    public function getAdresseComplete() {
        return $this->adresse." ".$this->cp." ".$this->ville;
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
            $pointeuse->setEffectifs($this);
        }

        return $this;
    }

    public function removePointeuse(Pointeuse $pointeuse): self
    {
        if ($this->pointeuse->contains($pointeuse)) {
            $this->pointeuse->removeElement($pointeuse);
            // set the owning side to null (unless already changed)
            if ($pointeuse->getEffectifs() === $this) {
                $pointeuse->setEffectifs(null);
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
            $absence->setEffectifs($this);
        }

        return $this;
    }

    public function removeAbsence(Absences $absence): self
    {
        if ($this->absences->contains($absence)) {
            $this->absences->removeElement($absence);
            // set the owning side to null (unless already changed)
            if ($absence->getEffectifs() === $this) {
                $absence->setEffectifs(null);
            }
        }

        return $this;
    }

    public function __toString() 
    {
        return $this->nom." ".$this->prenom;
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
