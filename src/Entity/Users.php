<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string The plain password
     * @Assert\Length(
     *      min=6,
     *      minMessage = "Le mot de passe doit faire au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $telephone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $RegisterDate;

    /**
     * @ORM\OneToMany(targetEntity=Tickets::class, mappedBy="users")
     */
    private $tickets;

    /**
     * @ORM\OneToMany(targetEntity=Sujets::class, mappedBy="users")
     */
    private $Sujets;

    /**
     * @ORM\OneToOne(targetEntity=Familles::class, mappedBy="Users", cascade={"persist", "remove"})
     */
    private $familles;

    /**
     * @ORM\OneToOne(targetEntity=Effectifs::class, mappedBy="Users", cascade={"persist", "remove"})
     */
    private $effectifs;

    /**
     * @ORM\OneToMany(targetEntity=Messages::class, mappedBy="Users")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=Reponses::class, mappedBy="Users")
     */
    private $reponses;

    

    public function __construct()
    {
        //ajouter date et heure courante
        if ($this->RegisterDate == null) {
            $this->RegisterDate = new \DateTime();
        }
        //ajouter le rôle ROLE_USER par defaut
        $this->addRole("ROLE_USER");
        $this->tickets = new ArrayCollection();
        $this->Sujets = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->reponses = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole($role)
    {
        $this->roles[] = $role;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getRegisterDate(): ?\DateTimeInterface
    {
        return $this->RegisterDate;
    }

    public function setRegisterDate(\DateTimeInterface $RegisterDate): self
    {
        $this->RegisterDate = $RegisterDate;

        return $this;
    }
        /**
     * Get the value of plainPassword
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

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
            $ticket->setUsers($this);
        }

        return $this;
    }

    public function removeTicket(Tickets $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getUsers() === $this) {
                $ticket->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sujets[]
     */
    public function getSujets(): Collection
    {
        return $this->Sujets;
    }

    public function addSujet(Sujets $sujet): self
    {
        if (!$this->Sujets->contains($sujet)) {
            $this->Sujets[] = $sujet;
            $sujet->setUsers($this);
        }

        return $this;
    }

    public function removeSujet(Sujets $sujet): self
    {
        if ($this->Sujets->contains($sujet)) {
            $this->Sujets->removeElement($sujet);
            // set the owning side to null (unless already changed)
            if ($sujet->getUsers() === $this) {
                $sujet->setUsers(null);
            }
        }

        return $this;
    }

    public function getFamilles(): ?Familles
    {
        return $this->familles;
    }

    public function setFamilles(?Familles $familles): self
    {
        $this->familles = $familles;

        // set (or unset) the owning side of the relation if necessary
        $newUsers = null === $familles ? null : $this;
        if ($familles->getUsers() !== $newUsers) {
            $familles->setUsers($newUsers);
        }

        return $this;
    }

    public function getEffectifs(): ?Effectifs
    {
        return $this->effectifs;
    }

    public function setEffectifs(?Effectifs $effectifs): self
    {
        $this->effectifs = $effectifs;

        // set (or unset) the owning side of the relation if necessary
        $newUsers = null === $effectifs ? null : $this;
        if ($effectifs->getUsers() !== $newUsers) {
            $effectifs->setUsers($newUsers);
        }

        return $this;
    }
    public function __toString() 
    {
        return $this->nom;
    }

    /**
     * @return Collection|Messages[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUsers($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getUsers() === $this) {
                $message->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reponses[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponses $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->addUser($this);
        }

        return $this;
    }

    public function removeReponse(Reponses $reponse): self
    {
        if ($this->reponses->contains($reponse)) {
            $this->reponses->removeElement($reponse);
            $reponse->removeUser($this);
        }

        return $this;
    }

}
