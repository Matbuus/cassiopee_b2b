<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 */
class Partenaire extends Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PortailB2B", inversedBy="partenaires")
     * @ORM\JoinColumn(nullable=true)
     */
    private $portailB2B;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Metier", mappedBy="partenaires")
     */
    private $metiers;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Prestation", inversedBy="partenaire", cascade={"persist", "remove"})
     */
    private $prestationProposee;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TypePrestation", mappedBy="partenaire")
     */
    private $typesPrestationsEnCatalogue;

    public function __construct()
    {
        $this->metiers = new ArrayCollection();
        $this->typesPrestationsEnCatalogue = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Metier[]
     */
    public function getMetiers(): Collection
    {
        return $this->metiers;
    }

    public function addMetier(Metier $metier): self
    {
        if (!$this->metiers->contains($metier)) {
            $this->metiers[] = $metier;
            $metier->setPartenaires($this);
        }

        return $this;
    }

    public function removeMetier(Metier $metier): self
    {
        if ($this->metiers->contains($metier)) {
            $this->metiers->removeElement($metier);
            // set the owning side to null (unless already changed)
            if ($metier->getPartenaires() === $this) {
                $metier->setPartenaires(null);
            }
        }

        return $this;
    }

    public function getPrestationProposee(): ?Prestation
    {
        return $this->prestationProposee;
    }

    public function setPrestationProposee(?Prestation $prestationProposee): self
    {
        $this->prestationProposee = $prestationProposee;

        return $this;
    }

    /**
     * @return Collection|TypePrestation[]
     */
    public function getTypesPrestationsEnCatalogue(): Collection
    {
        return $this->typesPrestationsEnCatalogue;
    }

    public function addTypesPrestationsEnCatalogue(TypePrestation $typesPrestationsEnCatalogue): self
    {
        if (!$this->typesPrestationsEnCatalogue->contains($typesPrestationsEnCatalogue)) {
            $this->typesPrestationsEnCatalogue[] = $typesPrestationsEnCatalogue;
            $typesPrestationsEnCatalogue->setPartenaire($this);
        }

        return $this;
    }

    public function removeTypesPrestationsEnCatalogue(TypePrestation $typesPrestationsEnCatalogue): self
    {
        if ($this->typesPrestationsEnCatalogue->contains($typesPrestationsEnCatalogue)) {
            $this->typesPrestationsEnCatalogue->removeElement($typesPrestationsEnCatalogue);
            // set the owning side to null (unless already changed)
            if ($typesPrestationsEnCatalogue->getPartenaire() === $this) {
                $typesPrestationsEnCatalogue->setPartenaire(null);
            }
        }

        return $this;
    }

    public function getPortailB2B(): ?PortailB2B
    {
        return $this->portailB2B;
    }
    
    public function setPortailB2B(?PortailB2B $portailB2B)
    {
        $this->portailB2B = $portailB2B;
    }

}
