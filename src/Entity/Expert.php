<?php

namespace App\Entity;

use App\Repository\ExpertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: ExpertRepository::class)]
#[ORM\Table(name: 'expert')]
class Expert
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkedin = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resume = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $professionalExperience = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $training = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $areaOfExpertise = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $region = null;

    #[ORM\ManyToMany(targetEntity: Organization::class)]
    #[ORM\JoinTable(name: 'expert_organization')]
    private Collection $workedWith;

    public function __construct()
    {
        $this->workedWith = new ArrayCollection();
        $this->professionalExperience = [];
        $this->training = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): static
    {
        $this->linkedin = $linkedin;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;
        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): static
    {
        $this->resume = $resume;
        return $this;
    }

    public function getProfessionalExperience(): ?array
    {
        return $this->professionalExperience;
    }

    public function setProfessionalExperience(?array $professionalExperience): static
    {
        $this->professionalExperience = $professionalExperience;
        return $this;
    }

    public function addProfessionalExperience(string $title, string $description): static
    {
        if ($this->professionalExperience === null) {
            $this->professionalExperience = [];
        }
        
        $this->professionalExperience[] = [
            'title' => $title,
            'description' => $description
        ];
        
        return $this;
    }

    public function removeProfessionalExperience(int $index): static
    {
        if (isset($this->professionalExperience[$index])) {
            unset($this->professionalExperience[$index]);
            $this->professionalExperience = array_values($this->professionalExperience);
        }
        
        return $this;
    }

    public function getTraining(): ?array
    {
        return $this->training;
    }

    public function setTraining(?array $training): static
    {
        $this->training = $training;
        return $this;
    }

    public function addTraining(string $training): static
    {
        if ($this->training === null) {
            $this->training = [];
        }
        
        if (!in_array($training, $this->training)) {
            $this->training[] = $training;
        }
        
        return $this;
    }

    public function removeTraining(string $training): static
    {
        if ($this->training !== null) {
            $key = array_search($training, $this->training);
            if ($key !== false) {
                unset($this->training[$key]);
                $this->training = array_values($this->training);
            }
        }
        
        return $this;
    }

    /**
     * @return Collection<int, Organization>
     */
    public function getWorkedWith(): Collection
    {
        return $this->workedWith;
    }

    public function addWorkedWith(Organization $workedWith): static
    {
        if (!$this->workedWith->contains($workedWith)) {
            $this->workedWith->add($workedWith);
        }

        return $this;
    }

    public function removeWorkedWith(Organization $workedWith): static
    {
        $this->workedWith->removeElement($workedWith);

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;
        return $this;
    }

    public function getAreaOfExpertise(): ?string
    {
        return $this->areaOfExpertise;
    }

    public function setAreaOfExpertise(?string $areaOfExpertise): static
    {
        $this->areaOfExpertise = $areaOfExpertise;
        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): static
    {
        $this->region = $region;
        return $this;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }
}