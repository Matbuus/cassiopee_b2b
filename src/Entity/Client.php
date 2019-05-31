<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @ORM\MappedSuperclass()
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class Client implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $prenom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evenement", mappedBy="client")
     */
    protected $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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
            $evenement->setClient($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->contains($evenement)) {
            $this->evenements->removeElement($evenement);
            // set the owning side to null (unless already changed)
            if ($evenement->getClient() === $this) {
                $evenement->setClient(null);
            }
        }

        return $this;
    }
    
    public function __toString():string
    {
        return $this->getNom()." ".$this->getPrenom();
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'evenements' => $this->getEvenements(),
        ];
        
    }



}
