<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 */
class Partenaire extends Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PortailB2B", inversedBy="partenaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $portailB2B;


    public function getId(): ?int
    {
        return $this->id;
    }

}
