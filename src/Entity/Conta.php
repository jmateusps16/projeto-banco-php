<?php

namespace App\Entity;

use App\Repository\ContaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity(repositoryClass: ContaRepository::class)]
class Conta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[ManyToOne(targetEntity: Agencia::class)]
    #[JoinColumn(name: 'agencia_id', referencedColumnName: 'id')]
    private ?int $agencia_id = null;

    #[ORM\Column]
    private ?int $tipo_conta = null;

    #[ORM\Column]
    #[OneToMany(targetEntity: Pessoa::class)]
    #[JoinColumn(name: 'cliente_id', referencedColumnName: 'id')]
    private ?int $cliente_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletado_em = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $saldoAtual = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgenciaId(): ?int
    {
        return $this->agencia_id;
    }

    public function setAgenciaId(int $agencia_id): self
    {
        $this->agencia_id = $agencia_id;

        return $this;
    }

    public function getTipoConta(): ?int
    {
        return $this->tipo_conta;
    }

    public function setTipoConta(int $tipo_conta): self
    {
        $this->tipo_conta = $tipo_conta;

        return $this;
    }

    public function getClienteId(): ?int
    {
        return $this->cliente_id;
    }

    public function setClienteId(int $cliente_id): self
    {
        $this->cliente_id = $cliente_id;

        return $this;
    }

    public function getDeletadoEm(): ?\DateTimeInterface
    {
        return $this->deletado_em;
    }

    public function setDeletadoEm(?\DateTimeInterface $deletado_em): self
    {
        $this->deletado_em = $deletado_em;

        return $this;
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "agencia_id" => $this->agencia_id,
            "tipo_conta" => $this->tipo_conta,
            "cliente_id" => $this->cliente_id
        ];
    }

    public function getSaldoAtual(): ?string
    {
        return $this->saldoAtual;
    }

    public function setSaldoAtual(string $saldoAtual): self
    {
        $this->saldoAtual = $saldoAtual;

        return $this;
    }
}
