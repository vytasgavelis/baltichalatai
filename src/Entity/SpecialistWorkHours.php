<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecialistWorkHoursRepository")
 */
class SpecialistWorkHours
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
    private $specialist_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clinic_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $day;

    /**
     * @ORM\Column(type="time")
     */
    private $start_time;

    /**
     * @ORM\Column(type="time")
     */
    private $end_time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecialistId(): ?Users
    {
        return $this->specialist_id;
    }

    public function setSpecialistId(?Users $specialist_id): self
    {
        $this->specialist_id = $specialist_id;

        return $this;
    }

    public function getClinicId(): ?Users
    {
        return $this->clinic_id;
    }

    public function setClinicId(?Users $clinic_id): self
    {
        $this->clinic_id = $clinic_id;

        return $this;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(int $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeInterface $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeInterface $end_time): self
    {
        $this->end_time = $end_time;

        return $this;
    }
}
