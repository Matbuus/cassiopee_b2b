<?php

namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtatRepository")
 */
class Etat implements JsonSerializable
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
    
    public function __toString(): string
    {
        return $this->getTitre();
    }
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'titre' => $this->getTitre(),
        ];
    }

}
