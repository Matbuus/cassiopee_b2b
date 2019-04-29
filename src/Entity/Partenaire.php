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
     * @ORM\ManyToOne(targetEntity="App\Entity\Metier", inversedBy="partenaires")
     */
    private $metier;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TypePrestation", mappedBy="partenaires")
     */
    private $typePrestations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Prestation", mappedBy="partenaire", orphanRemoval=true)
     */
    private $prestationsProposees;

    public function __construct()
    {
        $this->metiers = new ArrayCollection();
        $this->typesPrestationsEnCatalogue = new ArrayCollection();
        $this->typesPrestation = new ArrayCollection();
        $this->typePrestations = new ArrayCollection();
        $this->prestationsProposees = new ArrayCollection();
    }


  
    /**
     * @return Collection|Metier[]
     */
    public function getMetiers(): Collection
    {
        return $this->metiers;
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

    /**
     * @return Collection|Prestation[]
     */
    public function getPrestationsProposees(): Collection
    {
        return $this->prestationsProposees;
    }

    public function addPrestationsProposee(Prestation $prestationsProposee): self
    {
        if (!$this->prestationsProposees->contains($prestationsProposee)) {
            $this->prestationsProposees[] = $prestationsProposee;
            $prestationsProposee->setPartenaire($this);
        }

        return $this;
    }

    public function removePrestationsProposee(Prestation $prestationsProposee): self
    {
        if ($this->prestationsProposees->contains($prestationsProposee)) {
            $this->prestationsProposees->removeElement($prestationsProposee);
            // set the owning side to null (unless already changed)
            if ($prestationsProposee->getPartenaire() === $this) {
                $prestationsProposee->setPartenaire(null);
            }
        }

        return $this;
    }


}
