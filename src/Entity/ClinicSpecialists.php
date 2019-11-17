<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClinicSpecialistsRepository")
 */
class ClinicSpecialists
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
    private $clinicId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specialistId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClinicId(): ?User
    {
        return $this->clinicId;
    }

    public function setClinicId(?User $clinicId): self
    {
        $this->clinicId = $clinicId;

        return $this;
    }

    public function getSpecialistId(): ?User
    {
        return $this->specialistId;
    }

    public function setSpecialistId(?User $specialistId): self
    {
        $this->specialistId = $specialistId;

        return $this;
    }
}
