<?php

namespace App\Entity;

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
    private $nom_court;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_long;

    /**
     * @ORM\Column(type="integer")
     */
    private $poids;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCourt(): ?string
    {
        return $this->nom_court;
    }

    public function setNomCourt(string $nom_court): self
    {
        $this->nom_court = $nom_court;

        return $this;
    }

    public function getNomLong(): ?string
    {
        return $this->nom_long;
    }

    public function setNomLong(string $nom_long): self
    {
        $this->nom_long = $nom_long;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }
}
