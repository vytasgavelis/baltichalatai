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
     * @ORM\ManyToOne(targetEntity="App\Entity\Users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Specialties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specialty_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?Users
    {
        return $this->user_id;
    }

    public function setUserId(?Users $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getSpecialtyId(): ?Specialties
    {
        return $this->specialty_id;
    }

    public function setSpecialtyId(?Specialties $specialty_id): self
    {
        $this->specialty_id = $specialty_id;

        return $this;
    }
}
