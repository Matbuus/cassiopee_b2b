<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Repository\TypePrestationRepository")
 */
class TypePrestation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomType;
    /**
     * @ORM\Column(type="text")
     */
    private $description;
    /**
     * @ORM\Column(type="float")
     */
    private $tarifPublic;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Metier", inversedBy="typesPrestations")
     * @ORM\JoinColumn(nullable=true)
     */
    private $metier;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Partenaire", inversedBy="typesPrestationsEnCatalogue")
     */
    private $partenaire;
    
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNomType(): ?string
    {
        return $this->nomType;
    }
    public function setNomType(string $nomType): self
    {
        $this->nomType = $nomType;
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
    public function getTarifPublic(): ?float
    {
        return $this->tarifPublic;
    }
    public function setTarifPublic(float $tarifPublic): self
    {
        $this->tarifPublic = $tarifPublic;
        return $this;
    }
    public function getMetier(): ?Metier
    {
        return $this->metier;
    }
    public function setMetier(?Metier $metier): self
    {
        $this->metier = $metier;
        return $this;
    }
    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }
    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;
        return $this;
    }
}