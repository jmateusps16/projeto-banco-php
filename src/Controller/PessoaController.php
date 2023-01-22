<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pessoa;
use App\Repository\PessoaRepository;
use App\Validators\PessoaValidator;

class PessoaController extends BaseController
{
    private PessoaRepository $repository;

    function __construct(PessoaRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/pessoa/{id}', name: 'bind_by_id_Pessoa', methods: "GET")]
    public function buscar(int $id = 0): Response {
        $registers = $this->repository->findById($id);

        return $this->ResponseJson(
            array_map(
                function (Pessoa $value) {
                    return $value->toArray();
                }, 
                $registers
            ), 
            200
        );
    }

    #[Route('/pessoa', name: 'listar_Pessoa', methods: "GET")]
    public function listar(): Response {
        return $this->buscar(0);
    }

    #[Route('/pessoa/criar', name: 'cirar_Pessoa', methods: "POST")]
    public function criar(Request $request): Response {
        $data = $this->GetJsonData($request);
        $validator = PessoaValidator::obter($data, PessoaValidator::class, ["mode" => "create"]);

        if ($validator->falha())
            return $this->ResponseJson($validator->errors, 400);

        $entity = new Pessoa();

        $entity->setDocumento($this->getDataOfJsonUsingKey($data, "documento", null));
        $entity->setEnderecoId($this->getDataOfJsonUsingKey($data, "endereco_id", null));
        $entity->setNome($this->getDataOfJsonUsingKey($data, "nome", null));
        $entity->setTipoPessoa($this->getDataOfJsonUsingKey($data, "tipo_pessoa", null));

        $this->repository->save($entity, true);
        return $this->ResponseJson([ "id" => $entity->getId() ], 200);
    }

    #[Route('/pessoa/mudar', name: 'atualizar_Pessoa', methods: "PUT")]
    public function mudar(Request $request): Response {
        $data = $this->GetJsonData($request);
        $validator = PessoaValidator::obter($data, PessoaValidator::class, ["mode" => "change"]);

        if ($validator->falha())
            return $this->ResponseJson($validator->errors, 400);

        $entity = $this->repository->findById($this->getDataOfJsonUsingKey($data, "id", 0));

        if (count($entity) == 0)
            return $this->ResponseJson([], 404);
        $entity = $entity[0];

        $entity->setDocumento($this->getDataOfJsonUsingKey($data, "documento", null));
        $entity->setEnderecoId($this->getDataOfJsonUsingKey($data, "endereco_id", null));
        $entity->setNome($this->getDataOfJsonUsingKey($data, "nome", null));
        $entity->setTipoPessoa($this->getDataOfJsonUsingKey($data, "tipo_pessoa", null));
        $this->repository->save($entity, true);
        return $this->ResponseJson([], 200);
    }
}
