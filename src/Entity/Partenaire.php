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
     * @ORM\ManyToOne(targetEntity="App\Entity\Metier", inversedBy="partenaires")
     */
    private $metier;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TypePrestation", mappedBy="partenaires")
     */
    private $typePrestations;

    public function __construct()
    {
        $this->metiers = new ArrayCollection();
        $this->typesPrestationsEnCatalogue = new ArrayCollection();
        $this->typesPrestation = new ArrayCollection();
        $this->typePrestations = new ArrayCollection();
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


    public function getPrestationProposee(): ?Prestation
    {
        return $this->prestationProposee;
    }

    public function setPrestationProposee(?Prestation $prestationProposee): self
    {
        $this->prestationProposee = $prestationProposee;

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
     * @return Collection|TypePrestation[]
     */
    public function getTypePrestations(): Collection
    {
        return $this->typePrestations;
    }

    public function addTypePrestation(TypePrestation $typePrestation): self
    {
        if (!$this->typePrestations->contains($typePrestation)) {
            $this->typePrestations[] = $typePrestation;
            $typePrestation->addPartenaire($this);
        }

        return $this;
    }

    public function removeTypePrestation(TypePrestation $typePrestation): self
    {
        if ($this->typePrestations->contains($typePrestation)) {
            $this->typePrestations->removeElement($typePrestation);
            $typePrestation->removePartenaire($this);
        }

        return $this;
    }


}
