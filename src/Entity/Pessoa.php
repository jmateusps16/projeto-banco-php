<?php

namespace App\Entity;

use App\Repository\PessoaRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity(repositoryClass: PessoaRepository::class)]
class Pessoa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[ManyToOne(targetEntity: Endereco::class)]
    #[JoinColumn(name: 'endereco_id', referencedColumnName: 'id')]
    private ?int $endereco_id = null;

    #[ORM\Column]
    private ?int $tipo_pessoa = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $documento = null;

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

    public function getTipoPessoa(): ?int
    {
        return $this->tipo_pessoa;
    }

    public function setTipoPessoa(int $tipo_pessoa): self
    {
        $this->tipo_pessoa = $tipo_pessoa;

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

    public function getDocumento(): ?string
    {
        return $this->documento;
    }

    public function setDocumento(string $documento): self
    {
        $this->documento = $documento;

        return $this;
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "endereco_id" => $this->endereco_id,
            "tipo_pessoa" => $this->tipo_pessoa,
            "nome" => $this->nome,
            "documento" => $this->documento
        ];
    }
}
