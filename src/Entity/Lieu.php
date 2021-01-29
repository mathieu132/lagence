<?php

namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LieuRepository::class)
 */
class Lieu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $surface;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $capacite;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom_lieu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Selection::class, mappedBy="lieu", orphanRemoval=true)
     */
    private $selections;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="lieu", cascade={"remove","persist"})
     */
    private $photoss;

   
    

    public function __construct()
    {
        $this->selections = new ArrayCollection();
        $this->photoss = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getCapacite(): ?string
    {
        return $this->capacite;
    }

    public function setCapacite(string $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
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

    public function getNomLieu(): ?string
    {
        return $this->nom_lieu;
    }

    public function setNomLieu(string $nom_lieu): self
    {
        $this->nom_lieu = $nom_lieu;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Selection[]
     */
    public function getSelections(): Collection
    {
        return $this->selections;
    }

    public function addSelection(Selection $selection): self
    {
        if (!$this->selections->contains($selection)) {
            $this->selections[] = $selection;
            $selection->setLieu($this);
        }

        return $this;
    }

    public function removeSelection(Selection $selection): self
    {
        if ($this->selections->removeElement($selection)) {
            // set the owning side to null (unless already changed)
            if ($selection->getLieu() === $this) {
                $selection->setLieu(null);
            }
        }

        return $this;
    }

    public function getPhotos(): ?string
    {
        return $this->photos;
    }

    public function setPhotos(?string $photos): self
    {
        $this->photos = $photos;

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotoss(): Collection
    {
        return $this->photoss;
    }

    public function addPhotoss(Photo $photoss): self
    {
        if (!$this->photoss->contains($photoss)) {
            $this->photoss[] = $photoss;
            $photoss->setLieu($this);
        }

        return $this;
    }

    public function removePhotoss(Photo $photoss): self
    {
        if ($this->photoss->removeElement($photoss)) {
            // set the owning side to null (unless already changed)
            if ($photoss->getLieu() === $this) {
                $photoss->setLieu(null);
            }
        }

        return $this;
    }

   
}
