<?php

namespace App\Entity;

use App\Repository\CafeteriaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CafeteriaRepository::class)]
class Cafeteria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 500)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255)]
    private ?string $direccion = null;

    #[ORM\Column]
    private ?float $precioCafeConLeche = null;

    #[ORM\ManyToOne(inversedBy: 'cafeterias')]
    private ?Parque $parque = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString() {
        return $this->getNombre();
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getPrecioCafeConLeche(): ?float
    {
        return $this->precioCafeConLeche;
    }

    public function setPrecioCafeConLeche(float $precioCafeConLeche): self
    {
        $this->precioCafeConLeche = $precioCafeConLeche;

        return $this;
    }

    public function getParque(): ?Parque
    {
        return $this->parque;
    }

    public function setParque(?Parque $parque): self
    {
        $this->parque = $parque;

        return $this;
    }
}
