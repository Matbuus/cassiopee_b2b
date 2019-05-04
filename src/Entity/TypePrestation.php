<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     */
    private $metier;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Partenaire", inversedBy="typePrestations")
     */
    private $partenaires;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeEvenement", inversedBy="typePrestations")
     */
    private $typeEvent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Prestation", mappedBy="typePrestation", orphanRemoval=true)
     */
    private $prestations;

    public function __construct()
    {
        $this->partenaires = new ArrayCollection();
        $this->prestations = new ArrayCollection();
    }


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

    /**
     * @return Collection|Partenaire[]
     */
    public function getPartenaires(): Collection
    {
        return $this->partenaires;
    }

    public function addPartenaire(Partenaire $partenaire): self
    {
        if (!$this->partenaires->contains($partenaire)) {
            $this->partenaires[] = $partenaire;
        }

        return $this;
    }

    public function removePartenaire(Partenaire $partenaire): self
    {
        if ($this->partenaires->contains($partenaire)) {
            $this->partenaires->removeElement($partenaire);
        }

        return $this;
    }

    public function getTypeEvent(): ?TypeEvenement
    {
        return $this->typeEvent;
    }

    public function setTypeEvent(?TypeEvenement $typeEvent): self
    {
        $this->typeEvent = $typeEvent;

        return $this;
    }

    public function __toString(): string{
        return $this->nomType;
    }

    /**
     * @return Collection|Prestation[]
     */
    public function getPrestations(): Collection
    {
        return $this->prestations;
    }

    public function addPrestation(Prestation $prestation): self
    {
        if (!$this->prestations->contains($prestation)) {
            $this->prestations[] = $prestation;
            $prestation->setTypePrestation($this);
        }

        return $this;
    }

    public function removePrestation(Prestation $prestation): self
    {
        if ($this->prestations->contains($prestation)) {
            $this->prestations->removeElement($prestation);
            // set the owning side to null (unless already changed)
            if ($prestation->getTypePrestation() === $this) {
                $prestation->setTypePrestation(null);
            }
        }

        return $this;
    }



}
