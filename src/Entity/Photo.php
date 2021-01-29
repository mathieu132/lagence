<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 */
class Photo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lesphotos;

    /**
     * @ORM\ManyToOne(targetEntity=Lieu::class, inversedBy="photoss")
     */
    private $lieu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLesphotos(): ?string
    {
        return $this->lesphotos;
    }

    public function setLesphotos(?string $lesphotos): self
    {
        $this->lesphotos = $lesphotos;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }
}
