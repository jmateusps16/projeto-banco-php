<?php

namespace App\Entity;

use App\Repository\AberturaContaSolicitacaoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity(repositoryClass: AberturaContaSolicitacaoRepository::class)]
class AberturaContaSolicitacao
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[ManyToOne(targetEntity: Solicitacao::class)]
    #[JoinColumn(name: 'codigo_solicitacao', referencedColumnName: 'id')]
    private ?int $codigo_solicitacao = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column]
    private ?int $tipo_pessoa = null;

    #[ORM\Column]
    private ?int $tipo_conta = null;

    #[ORM\Column(length: 255)]
    private ?string $documento = null;

    #[ORM\Column]
    #[ManyToOne(targetEntity: Endereco::class)]
    #[JoinColumn(name: 'codigo_endereco', referencedColumnName: 'id')]
    private ?int $codigo_endereco = null;
    
    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletado_em = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigoSolicitacao(): ?int
    {
        return $this->codigo_solicitacao;
    }

    public function setCodigoSolicitacao(int $codigo_solicitacao): self
    {
        $this->codigo_solicitacao = $codigo_solicitacao;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getTipoPessoa(): ?int
    {
        return $this->tipo_pessoa;
    }

    public function setTipoPessoa(int $tipo_pessoa): self
    {
        $this->tipo_pessoa = $tipo_pessoa;

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

    public function getDocumento(): ?string
    {
        return $this->documento;
    }

    public function setDocumento(string $documento): self
    {
        $this->documento = $documento;

        return $this;
    }

    public function getCodigoEndereco(): ?int
    {
        return $this->codigo_endereco;
    }

    public function setCodigoEndereco(int $codigo_endereco): self
    {
        $this->codigo_endereco = $codigo_endereco;

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
            "codigo_solicitacao" => $this->codigo_solicitacao,
            "nome" => $this->nome,
            "tipo_pessoa" => $this->tipo_pessoa,
            "tipo_conta" => $this->tipo_conta,
            "documento" => $this->documento,
            "codigo_endereco" => $this->codigo_endereco,
            "status" => $this->status,
            "deletado_em" => $this->deletado_em
        ];
    }
}
