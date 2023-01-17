<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Gite::class, orphanRemoval: true)]
    private Collection $gites;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'contacts')]
    private ?self $owner = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: self::class, fetch: 'EAGER')]
    private Collection $contacts;

    public function __toString(): string
    {
        return $this->email;
    }

    public function __construct()
    {
        $this->gites = new ArrayCollection();
        $this->contacts = new ArrayCollection();
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
    public function getUserIdentifier(): string
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

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Gite>
     */
    public function getGites(): Collection
    {
        return $this->gites;
    }

    public function addGite(Gite $gite): self
    {
        if (!$this->gites->contains($gite)) {
            $this->gites->add($gite);
            $gite->setOwner($this);
        }

        return $this;
    }

    public function removeGite(Gite $gite): self
    {
        if ($this->gites->removeElement($gite)) {
            // set the owning side to null (unless already changed)
            if ($gite->getOwner() === $this) {
                $gite->setOwner(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?self
    {
        return $this->owner;
    }

    public function setOwner(?self $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(self $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setOwner($this);
        }

        return $this;
    }

    public function removeContact(self $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getOwner() === $this) {
                $contact->setOwner(null);
            }
        }

        return $this;
    }
}
