<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MetierRepository")
 */
class Metier
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
    private $partenaires2;

    public function __construct()
    {
        $this->typesPrestations = new ArrayCollection();
        $this->partenaires2 = new ArrayCollection();
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
    public function getPartenaires2(): Collection
    {
        return $this->partenaires2;
    }

    public function addPartenaires2(Partenaire $partenaires2): self
    {
        if (!$this->partenaires2->contains($partenaires2)) {
            $this->partenaires2[] = $partenaires2;
            $partenaires2->setMetier($this);
        }

        return $this;
    }

    public function removePartenaires2(Partenaire $partenaires2): self
    {
        if ($this->partenaires2->contains($partenaires2)) {
            $this->partenaires2->removeElement($partenaires2);
            // set the owning side to null (unless already changed)
            if ($partenaires2->getMetier() === $this) {
                $partenaires2->setMetier(null);
            }
        }

        return $this;
    }
}
