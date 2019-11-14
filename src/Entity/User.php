<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\UserInfo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $role;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserSpecialty", mappedBy="userId")
     */
    private $userSpecialties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserLanguage", mappedBy="userId")
     */
    private $userLanguages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserVisit", mappedBy="clientId", orphanRemoval=true)
     */
    private $userVisits;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SendingToDoctor", mappedBy="clientId", orphanRemoval=true)
     */
    private $sendingToDoctors;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserInfo", mappedBy="userId")
     */
    private $userInfo;


    public function __construct()
    {
        $this->userSpecialties = new ArrayCollection();
        $this->userLanguages = new ArrayCollection();
        $this->userVisits = new ArrayCollection();
        $this->sendingToDoctors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(int $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|UserSpecialty[]
     */
    public function getUserSpecialties(): Collection
    {
        return $this->userSpecialties;
    }

    public function addUserSpecialty(UserSpecialty $userSpecialty): self
    {
        if (!$this->userSpecialties->contains($userSpecialty)) {
            $this->userSpecialties[] = $userSpecialty;
            $userSpecialty->setUserId($this);
        }

        return $this;
    }

    public function removeUserSpecialty(UserSpecialty $userSpecialty): self
    {
        if ($this->userSpecialties->contains($userSpecialty)) {
            $this->userSpecialties->removeElement($userSpecialty);
            // set the owning side to null (unless already changed)
            if ($userSpecialty->getUserId() === $this) {
                $userSpecialty->setUserId(null);
            }
        }

        return $this;
    }

    public function getUserInfo(): ?UserInfo
    {
        return $this->userInfo;
    }

    /**
     * @return Collection|UserLanguage[]
     */
    public function getUserLanguages(): Collection
    {
        return $this->userLanguages;
    }

    public function addUserLanguage(UserLanguage $userLanguage): self
    {
        if (!$this->userLanguages->contains($userLanguage)) {
            $this->userLanguages[] = $userLanguage;
            $userLanguage->setUserId($this);
        }

        return $this;
    }

    public function removeUserLanguage(UserLanguage $userLanguage): self
    {
        if ($this->userLanguages->contains($userLanguage)) {
            $this->userLanguages->removeElement($userLanguage);
            // set the owning side to null (unless already changed)
            if ($userLanguage->getUserId() === $this) {
                $userLanguage->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserVisit[]
     */
    public function getUserVisits(): Collection
    {
        return $this->userVisits;
    }

    public function addUserVisit(UserVisit $userVisit): self
    {
        if (!$this->userVisits->contains($userVisit)) {
            $this->userVisits[] = $userVisit;
            $userVisit->setClientId($this);
        }

        return $this;
    }

    public function removeUserVisit(UserVisit $userVisit): self
    {
        if ($this->userVisits->contains($userVisit)) {
            $this->userVisits->removeElement($userVisit);
            // set the owning side to null (unless already changed)
            if ($userVisit->getClientId() === $this) {
                $userVisit->setClientId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SendingToDoctor[]
     */
    public function getSendingToDoctors(): Collection
    {
        return $this->sendingToDoctors;
    }

    public function addSendingToDoctor(SendingToDoctor $sendingToDoctor): self
    {
        if (!$this->sendingToDoctors->contains($sendingToDoctor)) {
            $this->sendingToDoctors[] = $sendingToDoctor;
            $sendingToDoctor->setClientId($this);
        }

        return $this;
    }

    public function removeSendingToDoctor(SendingToDoctor $sendingToDoctor): self
    {
        if ($this->sendingToDoctors->contains($sendingToDoctor)) {
            $this->sendingToDoctors->removeElement($sendingToDoctor);
            // set the owning side to null (unless already changed)
            if ($sendingToDoctor->getClientId() === $this) {
                $sendingToDoctor->setClientId(null);
            }
        }

        return $this;
    }
}
