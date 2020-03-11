<?php

namespace App\Entity;

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
}
