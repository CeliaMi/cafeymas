<?php

namespace App\Entity;

use App\Repository\ParqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParqueRepository::class)]
class Parque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 500)]
    private ?string $descripcion = null;

    #[ORM\OneToMany(mappedBy: 'parque', targetEntity: Cafeteria::class)]
    private Collection $cafeterias;

    public function __construct()
    {
        $this->cafeterias = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Cafeteria>
     */
    public function getCafeterias(): Collection
    {
        return $this->cafeterias;
    }

    public function addCafeteria(Cafeteria $cafeteria): self
    {
        if (!$this->cafeterias->contains($cafeteria)) {
            $this->cafeterias->add($cafeteria);
            $cafeteria->setParque($this);
        }

        return $this;
    }

    public function removeCafeteria(Cafeteria $cafeteria): self
    {
        if ($this->cafeterias->removeElement($cafeteria)) {
            // set the owning side to null (unless already changed)
            if ($cafeteria->getParque() === $this) {
                $cafeteria->setParque(null);
            }
        }

        return $this;
    }
}
