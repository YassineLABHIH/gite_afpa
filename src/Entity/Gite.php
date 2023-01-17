<?php

namespace App\Entity;

use App\Repository\GiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GiteRepository::class)]
class Gite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $surface = null;

    #[ORM\Column]
    private ?int $nbrRoom = null;

    #[ORM\Column]
    private ?int $nbrBed = null;

    #[ORM\Column]
    private ?bool $isAnimalAllowed = null;

    #[ORM\Column(nullable: true)]
    private ?float $animalPrice = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'gites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\ManyToOne]
    private ?User $contact = null;

    #[ORM\ManyToMany(targetEntity: EquipementExt::class, inversedBy: 'gites')]
    private Collection $equipementExts;

    #[ORM\ManyToMany(targetEntity: EquipementInt::class, inversedBy: 'gites')]
    private Collection $EquipementInts;

    #[ORM\OneToMany(mappedBy: 'gite', targetEntity: Photo::class, orphanRemoval: true)]
    private Collection $photos;

    #[ORM\OneToMany(mappedBy: 'gite', targetEntity: GiteService::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $giteServices;

    public function __construct()
    {
        $this->equipementExts = new ArrayCollection();
        $this->EquipementInts = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->giteServices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getNbrRoom(): ?int
    {
        return $this->nbrRoom;
    }

    public function setNbrRoom(int $nbrRoom): self
    {
        $this->nbrRoom = $nbrRoom;

        return $this;
    }

    public function getNbrBed(): ?int
    {
        return $this->nbrBed;
    }

    public function setNbrBed(int $nbrBed): self
    {
        $this->nbrBed = $nbrBed;

        return $this;
    }

    public function isIsAnimalAllowed(): ?bool
    {
        return $this->isAnimalAllowed;
    }

    public function setIsAnimalAllowed(bool $isAnimalAllowed): self
    {
        $this->isAnimalAllowed = $isAnimalAllowed;

        return $this;
    }

    public function getAnimalPrice(): ?float
    {
        return $this->animalPrice;
    }

    public function setAnimalPrice(float $animalPrice): self
    {
        $this->animalPrice = $animalPrice;

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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getContact(): ?User
    {
        return $this->contact;
    }

    public function setContact(?User $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection<int, EquipementExt>
     */
    public function getEquipementExts(): Collection
    {
        return $this->equipementExts;
    }

    public function addEquipementExt(EquipementExt $equipementExt): self
    {
        if (!$this->equipementExts->contains($equipementExt)) {
            $this->equipementExts->add($equipementExt);
        }

        return $this;
    }

    public function removeEquipementExt(EquipementExt $equipementExt): self
    {
        $this->equipementExts->removeElement($equipementExt);

        return $this;
    }

    /**
     * @return Collection<int, EquipementInt>
     */
    public function getEquipementInts(): Collection
    {
        return $this->EquipementInts;
    }

    public function addEquipementInt(EquipementInt $equipementInt): self
    {
        if (!$this->EquipementInts->contains($equipementInt)) {
            $this->EquipementInts->add($equipementInt);
        }

        return $this;
    }

    public function removeEquipementInt(EquipementInt $equipementInt): self
    {
        $this->EquipementInts->removeElement($equipementInt);

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setGite($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getGite() === $this) {
                $photo->setGite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GiteService>
     */
    public function getGiteServices(): Collection
    {
        return $this->giteServices;
    }

    public function addGiteService(GiteService $giteService): self
    {
        if (!$this->giteServices->contains($giteService)) {
            $this->giteServices->add($giteService);
            $giteService->setGite($this);
        }

        return $this;
    }

    public function removeGiteService(GiteService $giteService): self
    {
        if ($this->giteServices->removeElement($giteService)) {
            // set the owning side to null (unless already changed)
            if ($giteService->getGite() === $this) {
                $giteService->setGite(null);
            }
        }

        return $this;
    }
}
