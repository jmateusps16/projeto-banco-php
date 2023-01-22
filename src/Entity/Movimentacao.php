<?php

namespace App\Entity;

use App\Repository\MovimentacaoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;

#[ORM\Entity(repositoryClass: MovimentacaoRepository::class)]
class Movimentacao
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[OneToOne(targetEntity: Conta::class)]
    #[JoinColumn(name: 'conta_remetente_id', referencedColumnName: 'id')]
    private ?int $conta_remetente_id = null;

    #[ORM\Column(nullable: true)]
    #[OneToOne(targetEntity: Conta::class)]
    #[JoinColumn(name: 'conta_destino_id', referencedColumnName: 'id')]
    private ?int $conta_destino_id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4)]
    private ?string $valor = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $data = null;

    #[ORM\Column]
    private ?int $tipo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContaRemetenteId(): ?string
    {
        return $this->conta_remetente_id;
    }

    public function setContaRemetenteId(int $valor): self
    {
        $this->conta_remetente_id = $valor;

        return $this;
    }

    public function getContaDestinoId(): ?string
    {
        return $this->conta_destino_id;
    }

    public function setContaDestinoId(int $valor): self
    {
        $this->conta_destino_id = $valor;

        return $this;
    }

    public function getValor(): ?string
    {
        return $this->valor;
    }

    public function setValor(string $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

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

    public function toArray(): array {
        return [
            "id" => $this->id,
            "conta_id" => $this->conta_remetente_id,
            "conta_destino_id" => $this->conta_destino_id,
            "valor" => $this->valor,
            "status" => $this->status,
            "data" => $this->data,
            "tipo" => $this->tipo,
        ];
    }
}
