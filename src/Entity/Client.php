<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use phpDocumentor\Reflection\Types\This;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Evenement", mappedBy="client", orphanRemoval=true)
     */
    protected $evenements;

    /**
     * @ORM\Column(type="float", scale=5, precision=9)
     */
    protected $lat;

    /**
     * @ORM\Column(type="float", scale=5, precision=9)
     */
    protected $lng;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $city;

    /**
     * @ORM\Column(type="integer")
     */
    protected $postal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

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
            'address' => $this->getAddress(),
            'lat' => $this->getLat(),
            'lng' => $this->getLng(),
            'city' => $this->getCity(),
            'postal' => $this->getPostal(),
            'email' => $this->getEmail(),
        ];
        
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostal(): ?int
    {
        return $this->postal;
    }

    public function setPostal(int $postal): self
    {
        $this->postal = $postal;

        return $this;
    }
    
    

   
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    
    public function getPassword()
    {
        return $this->password;
    }



    public function getUsername()
    {
        return $this->email;
    }
    
 



}
