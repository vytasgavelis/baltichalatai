<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserSpecialtyRepository")
 */
class UserSpecialty
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Specialty")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specialtyId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getSpecialtyId(): ?Specialty
    {
        return $this->specialtyId;
    }

    public function setSpecialtyId(?Specialty $specialtyId): self
    {
        $this->specialtyId = $specialtyId;

        return $this;
    }
}
