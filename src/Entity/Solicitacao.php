<?php

namespace App\Entity;

use App\Repository\SolicitacaoRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity(repositoryClass: SolicitacaoRepository::class)]
class Solicitacao
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[ManyToOne(targetEntity: Agencia::class)]
    #[JoinColumn(name: 'codigo_agencia', referencedColumnName: 'id')]
    private ?int $codigo_agencia = null;

    #[ORM\Column]
    private ?int $tipo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descricao = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigoAgencia(): ?int
    {
        return $this->codigo_agencia;
    }

    public function setCodigoAgencia(int $codigo_agencia): self
    {
        $this->codigo_agencia = $codigo_agencia;

        return $this;
    }

    public function getTipo(): ?int
    {
        return $this->tipo;
    }

    public function setTipo(int $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "codigo_agencia" => $this->codigo_agencia,
            "tipo" => $this->tipo,
            "descricao" => $this->descricao
        ];
    }
}
