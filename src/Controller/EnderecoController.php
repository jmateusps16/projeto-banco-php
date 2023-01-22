<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Endereco;
use App\Repository\EnderecoRepository;
use App\Validators\EnderecoValidator;

class EnderecoController extends BaseController
{
    private EnderecoRepository $repository;

    function __construct(EnderecoRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/endereco/{id}', name: 'bind_by_id_endereco', methods: "GET")]
    public function buscar(int $id = 0): Response {
        $registers = $this->repository->findById($id);
        return $this->ResponseJson(array_map(function (Endereco $value) { return $value->toArray(); }, $registers), 200);
    }

    #[Route('/endereco', name: 'listar_endereco', methods: "GET")]
    public function listar(): Response {
        return $this->buscar(0);
    }

    #[Route('/endereco/criar', name: 'cirar_endereco', methods: "POST")]
    public function criar(Request $request): Response {
        $data = $this->GetJsonData($request);
        $validator = EnderecoValidator::obter($data, EnderecoValidator::class, ["mode" => "create"]);

        if ($validator->falha())
            return $this->ResponseJson($validator->errors, 400);

        $entity = new Endereco();

        $entity->setLogradouro($this->getDataOfJsonUsingKey($data, "logradouro", null));
        $entity->setNumero($this->getDataOfJsonUsingKey($data, "numero", null));
        $entity->setCep($this->getDataOfJsonUsingKey($data, "cep", null));
        $entity->setBairro($this->getDataOfJsonUsingKey($data, "bairro", null));
        $entity->setEstado($this->getDataOfJsonUsingKey($data, "estado", null));

        $this->repository->save($entity, true);
        return $this->ResponseJson([ "id" => $entity->getId() ], 200);
    }

    #[Route('/endereco/mudar', name: 'atualizar_endereco', methods: "PUT")]
    public function mudar(Request $request): Response {
        $data = $this->GetJsonData($request);
        $validator = EnderecoValidator::obter($data, EnderecoValidator::class, ["mode" => "change"]);

        if ($validator->falha())
            return $this->ResponseJson($validator->errors, 400);

        $entity = $this->repository->findById($this->getDataOfJsonUsingKey($data, "id", 0));

        if (count($entity) == 0)
            return $this->ResponseJson([], 404);
        $entity = $entity[0];

        $entity->setLogradouro($this->getDataOfJsonUsingKey($data, "logradouro", null));
        $entity->setNumero($this->getDataOfJsonUsingKey($data, "numero", null));
        $entity->setCep($this->getDataOfJsonUsingKey($data, "cep", null));
        $entity->setBairro($this->getDataOfJsonUsingKey($data, "bairro", null));
        $entity->setEstado($this->getDataOfJsonUsingKey($data, "estado", null));

        $this->repository->save($entity, true);
        return $this->ResponseJson([], 200);
    }
}
