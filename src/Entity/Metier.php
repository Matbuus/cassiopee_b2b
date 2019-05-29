<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MetierRepository")
 */
class Metier implements JsonSerializable
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
    private $titre;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TypePrestation", mappedBy="metier")
     */
    private $typesPrestations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partenaire", mappedBy="metier")
     */
    private $partenaires;

    public function __construct()
    {
        $this->typesPrestations = new ArrayCollection();
        $this->partenaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }


    /**
     * @return Collection|TypePrestation[]
     */
    public function getTypesPrestations(): Collection
    {
        return $this->typesPrestations;
    }

    public function addTypesPrestation(TypePrestation $typesPrestation): self
    {
        if (!$this->typesPrestations->contains($typesPrestation)) {
            $this->typesPrestations[] = $typesPrestation;
            $typesPrestation->setMetier($this);
        }

        return $this;
    }

    public function removeTypesPrestation(TypePrestation $typesPrestation): self
    {
        if ($this->typesPrestations->contains($typesPrestation)) {
            $this->typesPrestations->removeElement($typesPrestation);
            // set the owning side to null (unless already changed)
            if ($typesPrestation->getMetier() === $this) {
                $typesPrestation->setMetier(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->getTitre();
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
            $partenaire->setMetier($this);
        }

        return $this;
    }

    public function removePartenaire(Partenaire $partenaire): self
    {
        if ($this->partenaires->contains($partenaire)) {
            $this->partenaires->removeElement($partenaire);
            // set the owning side to null (unless already changed)
            if ($partenaire->getMetier() === $this) {
                $partenaire->setMetier(null);
            }
        }

        return $this;
    }
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'titre' => $this->getTitre(),
            'typesPrestations' => $this->getTypesPrestations(),
            'partenaires' => $this->getPartenaires(),
        ];
    }

}
