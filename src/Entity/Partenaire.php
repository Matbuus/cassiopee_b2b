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
     * @ORM\OneToOne(targetEntity="App\Entity\Prestation", inversedBy="partenaire", cascade={"persist", "remove"})
     */
    private $prestationProposee;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TypePrestation", mappedBy="partenaire")
     */
    private $typesPrestationsEnCatalogue;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Metier", inversedBy="partenaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $metier;

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
     * @return Metier
     */
    public function getMetier(): Collection
    {
        return $this->metiers;
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

    public function setMetier(?Metier $metier): self
    {
        $this->metier = $metier;

        return $this;
    }

}
