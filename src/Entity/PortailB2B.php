<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PortailB2BRepository")
 */
class PortailB2B
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
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="portailB2B", orphanRemoval=true)
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partenaire", mappedBy="portailB2B")
     */
    private $partenaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Metier", mappedBy="portailB2B", orphanRemoval=true)
     */
    private $metiers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TypeEvenement", mappedBy="portailB2B", orphanRemoval=true)
     */
    private $typesEvenements;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evenement", mappedBy="portailB2B", orphanRemoval=true)
     */
    private $evenements;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->partenaires = new ArrayCollection();
        $this->metiers = new ArrayCollection();
        $this->typesEvenements = new ArrayCollection();
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

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setPortailB2B($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getPortailB2B() === $this) {
                $client->setPortailB2B(null);
            }
        }

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
            $partenaire->setPortailB2B($this);
        }

        return $this;
    }

    public function removePartenaire(Partenaire $partenaire): self
    {
        if ($this->partenaires->contains($partenaire)) {
            $this->partenaires->removeElement($partenaire);
            // set the owning side to null (unless already changed)
            if ($partenaire->getPortailB2B() === $this) {
                $partenaire->setPortailB2B(null);
            }
        }

        return $this;
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
            $metier->setPortailB2B($this);
        }

        return $this;
    }

    public function removeMetier(Metier $metier): self
    {
        if ($this->metiers->contains($metier)) {
            $this->metiers->removeElement($metier);
            // set the owning side to null (unless already changed)
            if ($metier->getPortailB2B() === $this) {
                $metier->setPortailB2B(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TypeEvenement[]
     */
    public function getTypesEvenements(): Collection
    {
        return $this->typesEvenements;
    }

    public function addTypesEvenement(TypeEvenement $typesEvenement): self
    {
        if (!$this->typesEvenements->contains($typesEvenement)) {
            $this->typesEvenements[] = $typesEvenement;
            $typesEvenement->setPortailB2B($this);
        }

        return $this;
    }

    public function removeTypesEvenement(TypeEvenement $typesEvenement): self
    {
        if ($this->typesEvenements->contains($typesEvenement)) {
            $this->typesEvenements->removeElement($typesEvenement);
            // set the owning side to null (unless already changed)
            if ($typesEvenement->getPortailB2B() === $this) {
                $typesEvenement->setPortailB2B(null);
            }
        }

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
            $evenement->setPortailB2B($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->contains($evenement)) {
            $this->evenements->removeElement($evenement);
            // set the owning side to null (unless already changed)
            if ($evenement->getPortailB2B() === $this) {
                $evenement->setPortailB2B(null);
            }
        }

        return $this;
    }
    

}
