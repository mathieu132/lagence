<?php

namespace App\Entity;

use App\Repository\PhotosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotosRepository::class)
 */
class Photos
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
     * @ORM\ManyToOne(targetEntity=Lieu::class, inversedBy="picture")
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
