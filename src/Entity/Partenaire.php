<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 */

class Partenaire extends Client implements JsonSerializable
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
    
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'evenements' => $this->getEvenements(),
            'address' => $this->getAddress(),
            'lat' => $this->getLat(),
            'lng' => $this->getLng(),
            'city' => $this->getCity(),
            'postal' => $this->getPostal(),
            'email' => $this->getEmail(),
            'metier' => $this->getMetier(),
            'typePrestations' => $this->getTypePrestations(),
            'prestationProposees' => $this->getPrestationsProposees(),
            'note' => $this->getNoteTotale(),
            
        ];
        
    }
    
    public function getNoteTotale() : float
    {
        $note = 0;
        $nb = 0;
        foreach ($this->getPrestationsProposees() as $prestation) {
            if ($prestation->getEtatPrestation()->getTitre() == 'Termine' && $prestation->getNote() != null){
               $nb++;
               $note += $prestation->getNote();
            }
        }
        if($nb != 0) {
        $this->setNote($note/$nb);
        return $this->getNote();
        } else {
            return 0;
        }
    }
    
    public function getRoles()
    {
        return ['ROLE_PARTENAIRE'];
    }


}
