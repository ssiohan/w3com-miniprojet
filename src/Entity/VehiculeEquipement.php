<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehiculeEquipementRepository")
 */
class VehiculeEquipement
{

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Vehicule", inversedBy="vehiculeEquipements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicule;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipement", inversedBy="equipementVehicule")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomLong;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $poids;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getEquipement(): ?Equipement
    {
        return $this->equipement;
    }

    public function setEquipement(?Equipement $equipement): self
    {
        $this->equipement = $equipement;

        return $this;
    }
}
