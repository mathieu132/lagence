<?php

namespace App\Entity;

use App\Repository\LieuRepository;
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
}