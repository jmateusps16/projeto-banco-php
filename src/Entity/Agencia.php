<?php

namespace App\Entity;

use App\Repository\AgenciaRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;

#[ORM\Entity(repositoryClass: AgenciaRepository::class)]
class Agencia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[OneToOne(targetEntity: Endereco::class)]
    #[JoinColumn(name: 'endereco_id', referencedColumnName: 'id')]
    private ?int $endereco_id = null;

    #[ORM\Column]
    private ?int $gerente_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnderecoId(): ?int
    {
        return $this->endereco_id;
    }

    public function setEnderecoId(int $endereco_id): self
    {
        $this->endereco_id = $endereco_id;

        return $this;
    }

    public function getGerenteId(): ?int
    {
        return $this->gerente_id;
    }

    public function setGerenteId(int $gerente_id): self
    {
        $this->gerente_id = $gerente_id;

        return $this;
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "endereco_id" => $this->endereco_id,
            "gerente_id" => $this->gerente_id
        ];
    }
}
