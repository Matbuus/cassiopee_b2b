<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @ORM\MappedSuperclass()
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $prenom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PortailB2B", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $portailB2B;


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

    public function getPortailB2B(): ?PortailB2B
    {
        return $this->portailB2B;
    }

    public function setPortailB2B(?PortailB2B $portailB2B): self
    {
        $this->portailB2B = $portailB2B;

        return $this;
    }

}
