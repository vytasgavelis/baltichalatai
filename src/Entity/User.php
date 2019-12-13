<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\UserInfo;
use App\Entity\ClinicInfo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="Šis el. paštas jau yra užimtas.")
 * @ORM\Table(
 *      name="user",
 *      indexes={
 *          @ORM\Index(name="idx_email", columns={"email"})
 *     }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

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
     * @ORM\OneToMany(targetEntity="App\Entity\UserVisit", mappedBy="clientId")
     */
    private $userVisits;

    /* /**
      * @ORM\OneToOne(targetEntity="App\Entity\SendingToDoctor", mappedBy="clientId")

     private $sendingToDoctors;*/

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserInfo", mappedBy="userId")
     */
    private $userInfo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ClinicInfo", mappedBy="userId")
     */
    private $clinicInfo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClinicSpecialists", mappedBy="clinicId")
     */
    private $clinicSpecialists;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClinicWorkHours", mappedBy="clinicId")
     */
    private $clinicWorkHours;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClinicSpecialists", mappedBy="specialistId")
     */
    private $specialistClinics;
    /**
     * @var ArrayCollection
     */
    private $sendingToDoctors;

    public function getClinicInfo()
    {
        return $this->clinicInfo;
    }

    /**
     * @param mixed $clinicInfo
     */
    public function setClinicInfo($clinicInfo): void
    {
        $this->clinicInfo = $clinicInfo;
    }

    public function __construct()
    {
        $this->userSpecialties = new ArrayCollection();
        $this->userLanguages = new ArrayCollection();
        $this->userVisits = new ArrayCollection();
        $this->sendingToDoctors = new ArrayCollection();
        $this->clinicSpecialists = new ArrayCollection();
        $this->clinicWorkHours = new ArrayCollection();
        $this->specialistClinics = new ArrayCollection();
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

    /**
     * @return Collection|ClinicSpecialists[]
     */
    public function getSpecialistClinics(): Collection
    {
        return $this->specialistClinics;
    }

    public function getUserInfo(): Collection
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
     * @return Collection|ClinicSpecialists[]
     */
    public function getClinicSpecialists(): Collection
    {
        return $this->clinicSpecialists;
    }

    public function addClinicSpecialist(ClinicSpecialists $clinicSpecialist): self
    {
        if (!$this->clinicSpecialists->contains($clinicSpecialist)) {
            $this->clinicSpecialists[] = $clinicSpecialist;
            $clinicSpecialist->setClinicId($this);
        }

        return $this;
    }

    public function removeClinicSpecialist(ClinicSpecialists $clinicSpecialist): self
    {
        if ($this->clinicSpecialists->contains($clinicSpecialist)) {
            $this->clinicSpecialists->removeElement($clinicSpecialist);
            // set the owning side to null (unless already changed)
            if ($clinicSpecialist->getClinicId() === $this) {
                $clinicSpecialist->setClinicId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ClinicWorkHours[]
     */
    public function getClinicWorkHours(): Collection
    {
        return $this->clinicWorkHours;
    }

    public function addClinicWorkHour(ClinicWorkHours $clinicWorkHour): self
    {
        if (!$this->clinicWorkHours->contains($clinicWorkHour)) {
            $this->clinicWorkHours[] = $clinicWorkHour;
            $clinicWorkHour->setClinicId($this);
        }

        return $this;
    }

    public function removeClinicWorkHour(ClinicWorkHours $clinicWorkHour): self
    {
        if ($this->clinicWorkHours->contains($clinicWorkHour)) {
            $this->clinicWorkHours->removeElement($clinicWorkHour);
            // set the owning side to null (unless already changed)
            if ($clinicWorkHour->getClinicId() === $this) {
                $clinicWorkHour->setClinicId(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
