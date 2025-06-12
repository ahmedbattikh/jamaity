<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'opportunity')]
class Opportunity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $opportunityDetails = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $eligibilityCriteria = [];

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $howToApply = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dueDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeOfOpportunities = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $regions = [];

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $interventionThemes = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $organisme = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateModification = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $budget = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contactEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contactTelephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteWeb = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $slug = null;

    #[ORM\ManyToOne(targetEntity: Organization::class)]
    #[ORM\JoinColumn(name: 'organization_id', referencedColumnName: 'id', nullable: true)]
    private ?Organization $organizationRelated = null;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
        return $this;
    }

    public function getOpportunityDetails(): ?string
    {
        return $this->opportunityDetails;
    }

    public function setOpportunityDetails(?string $opportunityDetails): static
    {
        $this->opportunityDetails = $opportunityDetails;
        return $this;
    }

    public function getEligibilityCriteria(): ?array
    {
        return $this->eligibilityCriteria;
    }

    public function setEligibilityCriteria(?array $eligibilityCriteria): static
    {
        $this->eligibilityCriteria = $eligibilityCriteria;
        return $this;
    }

    public function getHowToApply(): ?string
    {
        return $this->howToApply;
    }

    public function setHowToApply(?string $howToApply): static
    {
        $this->howToApply = $howToApply;
        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTimeInterface $dueDate): static
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    public function getTypeOfOpportunities(): ?string
    {
        return $this->typeOfOpportunities;
    }

    public function setTypeOfOpportunities(?string $typeOfOpportunities): static
    {
        if ($typeOfOpportunities !== null && !in_array($typeOfOpportunities, self::getValidOpportunityTypes())) {
            throw new \InvalidArgumentException('Invalid opportunity type. Must be one of: ' . implode(', ', self::getValidOpportunityTypes()));
        }
        
        $this->typeOfOpportunities = $typeOfOpportunities;
        return $this;
    }

    public function getRegions(): ?array
    {
        return $this->regions;
    }

    public function setRegions(?array $regions): static
    {
        if ($regions !== null) {
            foreach ($regions as $region) {
                if (!in_array($region, self::getValidRegions())) {
                    throw new \InvalidArgumentException('Invalid region: ' . $region . '. Must be one of the Tunisian regions.');
                }
            }
        }
        
        $this->regions = $regions;
        return $this;
    }

    public function getInterventionThemes(): ?array
    {
        return $this->interventionThemes;
    }

    public function setInterventionThemes(?array $interventionThemes): static
    {
        $this->interventionThemes = $interventionThemes;
        return $this;
    }

    public function getOrganisme(): ?string
    {
        return $this->organisme;
    }

    public function setOrganisme(?string $organisme): static
    {
        $this->organisme = $organisme;
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(?\DateTimeInterface $dateModification): static
    {
        $this->dateModification = $dateModification;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }

    public function getBudget(): ?string
    {
        return $this->budget;
    }

    public function setBudget(?string $budget): static
    {
        $this->budget = $budget;
        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(?string $contactEmail): static
    {
        $this->contactEmail = $contactEmail;
        return $this;
    }

    public function getContactTelephone(): ?string
    {
        return $this->contactTelephone;
    }

    public function setContactTelephone(?string $contactTelephone): static
    {
        $this->contactTelephone = $contactTelephone;
        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(?string $siteWeb): static
    {
        $this->siteWeb = $siteWeb;
        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    public function getOrganizationRelated(): ?Organization
    {
        return $this->organizationRelated;
    }

    public function setOrganizationRelated(?Organization $organizationRelated): static
    {
        $this->organizationRelated = $organizationRelated;
        return $this;
    }

    public static function getValidOpportunityTypes(): array
    {
        return \App\Enum\OpportunityTypeEnum::getValues();
    }

    public static function getValidRegions(): array
    {
        return [
            'Tunis',
            'Ariana',
            'Ben Arous',
            'Manouba',
            'Nabeul',
            'Zaghouan',
            'Bizerte',
            'Béja',
            'Jendouba',
            'Kef',
            'Siliana',
            'Sousse',
            'Monastir',
            'Mahdia',
            'Sfax',
            'Kairouan',
            'Kasserine',
            'Sidi Bouzid',
            'Gabès',
            'Médenine',
            'Tataouine',
            'Gafsa',
            'Tozeur',
            'Kébili'
        ];
    }

    public function __toString(): string
    {
        return $this->titre ?? '';
    }
}