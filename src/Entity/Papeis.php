<?php

namespace App\Entity;

use App\Repository\PapeisRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity(repositoryClass: PapeisRepository::class)]
class Papeis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'codigo_credencial', referencedColumnName: 'id')]
    private ?int $codigo_credencial = null;

    #[ORM\Column]
    private ?int $codigo_papel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigoCredencial(): ?int
    {
        return $this->codigo_credencial;
    }

    public function setCodigoCredencial(int $codigo_credencial): self
    {
        $this->codigo_credencial = $codigo_credencial;

        return $this;
    }

    public function getCodigoPapel(): ?int
    {
        return $this->codigo_papel;
    }

    public function setCodigoPapel(int $codigo_papel): self
    {
        $this->codigo_papel = $codigo_papel;

        return $this;
    }
    
    public function toArray(): array {
        return [
            "id" => $this->id,
            "codigo_credencial" => $this->codigo_credencial,
            "codigo_papel" => $this->codigo_papel
        ];
    }
}
