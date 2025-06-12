<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Enum\PtfTypeEnum;

#[ORM\Entity]
#[ORM\Table(name: 'ptf')]
class Ptf extends Organization
{
    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(nullable: true)]
    private ?int $annee = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $abreviation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieux = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mission = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $facebook = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $twitter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtube = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkedin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteWeb = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $prioritesStrategiques = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $missionThemePrioritaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomContact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poste = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $numeroTelephoneContact = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $fax = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $domaine = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $priorites = [];

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $particularites = [];

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $mecanisme = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numeroJort = null;

    #[ORM\Column(length: 255)]
    private ?string $president = null;

    #[ORM\Column(length: 20)]
    private ?string $telephone2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $google = null;

    #[ORM\Column(nullable: true)]
    private ?int $anneeFondation = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?self $parent = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastUpdateDate = null;

    #[ORM\Column(type: 'string', enumType: PtfTypeEnum::class, nullable: true)]
    private ?PtfTypeEnum $ptfType = null;

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(?int $annee): static
    {
        $this->annee = $annee;
        return $this;
    }

    public function getAbreviation(): ?string
    {
        return $this->abreviation;
    }

    public function setAbreviation(?string $abreviation): static
    {
        $this->abreviation = $abreviation;
        return $this;
    }

    public function getLieux(): ?string
    {
        return $this->lieux;
    }

    public function setLieux(?string $lieux): static
    {
        $this->lieux = $lieux;
        return $this;
    }

    public function getMission(): ?string
    {
        return $this->mission;
    }

    public function setMission(?string $mission): static
    {
        $this->mission = $mission;
        return $this;
    }

    public function getTelephone1(): ?string
    {
        return $this->telephone1;
    }

    public function setTelephone1(?string $telephone1): static
    {
        $this->telephone1 = $telephone1;
        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): static
    {
        $this->facebook = $facebook;
        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): static
    {
        $this->twitter = $twitter;
        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): static
    {
        $this->youtube = $youtube;
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

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(?string $siteWeb): static
    {
        $this->siteWeb = $siteWeb;
        return $this;
    }

    public function getPrioritesStrategiques(): ?string
    {
        return $this->prioritesStrategiques;
    }

    public function setPrioritesStrategiques(?string $prioritesStrategiques): static
    {
        $this->prioritesStrategiques = $prioritesStrategiques;
        return $this;
    }

    public function getMissionThemePrioritaire(): ?string
    {
        return $this->missionThemePrioritaire;
    }

    public function setMissionThemePrioritaire(?string $missionThemePrioritaire): static
    {
        $this->missionThemePrioritaire = $missionThemePrioritaire;
        return $this;
    }

    public function getNomContact(): ?string
    {
        return $this->nomContact;
    }

    public function setNomContact(?string $nomContact): static
    {
        $this->nomContact = $nomContact;
        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(?string $poste): static
    {
        $this->poste = $poste;
        return $this;
    }

    public function getNumeroTelephoneContact(): ?string
    {
        return $this->numeroTelephoneContact;
    }

    public function setNumeroTelephoneContact(?string $numeroTelephoneContact): static
    {
        $this->numeroTelephoneContact = $numeroTelephoneContact;
        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): static
    {
        $this->fax = $fax;
        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(?string $domaine): static
    {
        $this->domaine = $domaine;
        return $this;
    }

    public function getPriorites(): ?array
    {
        return $this->priorites;
    }

    public function setPriorites(?array $priorites): static
    {
        $this->priorites = $priorites;
        return $this;
    }

    public function getParticularites(): ?array
    {
        return $this->particularites;
    }

    public function setParticularites(?array $particularites): static
    {
        $this->particularites = $particularites;
        return $this;
    }

    public function getMecanisme(): ?array
    {
        return $this->mecanisme;
    }

    public function setMecanisme(?array $mecanisme): static
    {
        $this->mecanisme = $mecanisme;
        return $this;
    }

    public function getNumeroJort(): ?string
    {
        return $this->numeroJort;
    }

    public function setNumeroJort(?string $numeroJort): static
    {
        $this->numeroJort = $numeroJort;
        return $this;
    }

    public function getPresident(): ?string
    {
        return $this->president;
    }

    public function setPresident(?string $president): static
    {
        $this->president = $president;
        return $this;
    }

    public function getTelephone2(): ?string
    {
        return $this->telephone2;
    }

    public function setTelephone2(?string $telephone2): static
    {
        $this->telephone2 = $telephone2;
        return $this;
    }

    public function getGoogle(): ?string
    {
        return $this->google;
    }

    public function setGoogle(?string $google): static
    {
        $this->google = $google;
        return $this;
    }

    public function getAnneeFondation(): ?int
    {
        return $this->anneeFondation;
    }

    public function setAnneeFondation(?int $anneeFondation): static
    {
        $this->anneeFondation = $anneeFondation;
        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;
        return $this;
    }

    public function getLastUpdateDate(): ?\DateTimeInterface
    {
        return $this->lastUpdateDate;
    }

    public function setLastUpdateDate(?\DateTimeInterface $lastUpdateDate): static
    {
        $this->lastUpdateDate = $lastUpdateDate;
        return $this;
    }

    public function getPtfType(): ?PtfTypeEnum
    {
        return $this->ptfType;
    }

    public function setPtfType(?PtfTypeEnum $ptfType): static
    {
        $this->ptfType = $ptfType;
        return $this;
    }

    public function __toString(): string
    {
        return $this->titre ?? '';
    }
}
