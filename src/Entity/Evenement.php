<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
 */
class Evenement
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
     * @ORM\Column(type="date")
     */
    private $date;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeEvenement", inversedBy="evenements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeevenement;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Prestation", mappedBy="evenement", orphanRemoval=true)
     */
    private $prestations;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="evenements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;
    public function __construct()
    {
        $this->prestations = new ArrayCollection();
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
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }
    public function getTypeevenement(): ?TypeEvenement
    {
        return $this->typeevenement;
    }
    public function setTypeevenement(?TypeEvenement $typeevenement): self
    {
        $this->typeevenement = $typeevenement;
        return $this;
    }
    /**
     * @return Collection|Prestation[]
     */
    public function getPrestations(): Collection
    {
        return $this->prestations;
    }
    public function addPrestation(Prestation $prestation): self
    {
        if (!$this->prestations->contains($prestation)) {
            $this->prestations[] = $prestation;
            $prestation->setEvenement($this);
        }
        return $this;
    }
    public function removePrestation(Prestation $prestation): self
    {
        if ($this->prestations->contains($prestation)) {
            $this->prestations->removeElement($prestation);
            // set the owning side to null (unless already changed)
            if ($prestation->getEvenement() === $this) {
                $prestation->setEvenement(null);
            }
        }
        return $this;
    }
    public function getClient(): ?Client
    {
        return $this->client;
    }
    public function setClient(?Client $client): self
    {
        $this->client = $client;
        return $this;
    }
}