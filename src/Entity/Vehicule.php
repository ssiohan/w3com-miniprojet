<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehiculeRepository")
 */
class Vehicule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $immat;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $modele;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $couleur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VehiculeEquipement", mappedBy="vehicule")
     */
    private $vehiculeEquipements;

    public function __construct()
    {
        $this->vehiculeEquipements = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImmat(): ?string
    {
        return $this->immat;
    }

    public function setImmat(string $immat): self
    {
        $this->immat = $immat;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * @return Collection|VehiculeEquipement[]
     */
    public function getVehiculeEquipements(): Collection
    {
        return $this->vehiculeEquipements;
    }

    public function addVehiculeEquipement(VehiculeEquipement $vehiculeEquipement): self
    {
        if (!$this->vehiculeEquipements->contains($vehiculeEquipement)) {
            $this->vehiculeEquipements[] = $vehiculeEquipement;
            $vehiculeEquipement->setVehicule($this);
        }

        return $this;
    }

    public function removeVehiculeEquipement(VehiculeEquipement $vehiculeEquipement): self
    {
        if ($this->vehiculeEquipements->contains($vehiculeEquipement)) {
            $this->vehiculeEquipements->removeElement($vehiculeEquipement);
            // set the owning side to null (unless already changed)
            if ($vehiculeEquipement->getVehicule() === $this) {
                $vehiculeEquipement->setVehicule(null);
            }
        }

        return $this;
    }
}
