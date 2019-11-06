<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users
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
     * @ORM\OneToMany(targetEntity="App\Entity\UserSpecialty", mappedBy="user_id")
     */
    private $userSpecialties;

    public function __construct()
    {
        $this->userSpecialties = new ArrayCollection();
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
}
