<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeEvenementRepository")
 */
class TypeEvenement
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evenement", mappedBy="typeEvenement")
     */
    private $evenements;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TypePrestation", mappedBy="typeEvent")
     */
    private $typePrestations;



    public function __construct()
    {
        $this->evenements = new ArrayCollection();
        $this->typePrestations = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setTypeEvenement($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->contains($evenement)) {
            $this->evenements->removeElement($evenement);
            // set the owning side to null (unless already changed)
            if ($evenement->getTypeEvenement() === $this) {
                $evenement->setTypeEvenement(null);
            }
        }

        return $this;
    }
    
    public function __toString():string
    {
        return $this->getNom();
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
            $typePrestation->setTypeEvent($this);
        }

        return $this;
    }

    public function removeTypePrestation(TypePrestation $typePrestation): self
    {
        if ($this->typePrestations->contains($typePrestation)) {
            $this->typePrestations->removeElement($typePrestation);
            // set the owning side to null (unless already changed)
            if ($typePrestation->getTypeEvent() === $this) {
                $typePrestation->setTypeEvent(null);
            }
        }

        return $this;
    }



}
