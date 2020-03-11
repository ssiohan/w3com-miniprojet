<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipementRepository")
 */
class Equipement
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
    private $nomCourt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomLong;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $poids;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VehiculeEquipement", mappedBy="equipement")
     */
    private $equipementVehicule;

    public function __construct()
    {
        $this->equipementVehicule = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return
            $this->id . " - " .
            $this->nomCourt . " / " .
            $this->nomLong . ' (' .
            $this->poids . ' Kg)';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCourt(): ?string
    {
        return $this->nomCourt;
    }

    public function setNomCourt(string $nomCourt): self
    {
        $this->nomCourt = $nomCourt;

        return $this;
    }

    public function getNomLong(): ?string
    {
        return $this->nomLong;
    }

    public function setNomLong(string $nomLong): self
    {
        $this->nomLong = $nomLong;

        return $this;
    }

    public function getPoids(): ?string
    {
        return $this->poids;
    }

    public function setPoids(string $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    /**
     * @return Collection|VehiculeEquipement[]
     */
    public function getEquipementVehicule(): Collection
    {
        return $this->equipementVehicule;
    }

    public function addEquipementVehicule(VehiculeEquipement $equipementVehicule): self
    {
        if (!$this->equipementVehicule->contains($equipementVehicule)) {
            $this->equipementVehicule[] = $equipementVehicule;
            $equipementVehicule->setEquipement($this);
        }

        return $this;
    }

    public function removeEquipementVehicule(VehiculeEquipement $equipementVehicule): self
    {
        if ($this->equipementVehicule->contains($equipementVehicule)) {
            $this->equipementVehicule->removeElement($equipementVehicule);
            // set the owning side to null (unless already changed)
            if ($equipementVehicule->getEquipement() === $this) {
                $equipementVehicule->setEquipement(null);
            }
        }

        return $this;
    }
}
