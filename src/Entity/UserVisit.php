<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserVisitRepository")
 */
class UserVisit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="userVisits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clientId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="userVisits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specialistId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="userVisits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clinicId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $visitDate;

    /**
     * @ORM\Column(type="string", length=2000)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SendingToDoctor", inversedBy="userVisits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sendingToDoctorId;

    /**
     * @return mixed
     */
    public function getSendingToDoctorId()
    {
        return $this->sendingToDoctorId;
    }

    /**
     * @param mixed $sendingToDoctorId
     */
    public function setSendingToDoctorId($sendingToDoctorId): void
    {
        $this->sendingToDoctorId = $sendingToDoctorId;
    }

    /**
     * @return mixed
     */
    public function getRecipeId()
    {
        return $this->recipeId;
    }

    /**
     * @param mixed $recipeId
     */
    public function setRecipeId($recipeId): void
    {
        $this->recipeId = $recipeId;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipe", inversedBy="userVisits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipeId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientId(): ?Users
    {
        return $this->clientId;
    }

    public function setClientId(?Users $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function getSpecialistId(): ?Users
    {
        return $this->specialistId;
    }

    public function setSpecialistId(?Users $specialistId): self
    {
        $this->specialistId = $specialistId;

        return $this;
    }

    public function getClinicId(): ?Users
    {
        return $this->clinicId;
    }

    public function setClinicId(?Users $clinicId): self
    {
        $this->clinicId = $clinicId;

        return $this;
    }

    public function getVisitDate(): ?\DateTimeInterface
    {
        return $this->visitDate;
    }

    public function setVisitDate(\DateTimeInterface $visitDate): self
    {
        $this->visitDate = $visitDate;

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
}
