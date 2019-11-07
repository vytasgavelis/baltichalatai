<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SendingToDoctorRepository")
 */
class SendingToDoctor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="sendingToDoctors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clientId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="sendingToDoctors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specialistId;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     */
    private $description;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
