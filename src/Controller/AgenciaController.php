<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AgenciaRepository;
use App\Repository\PapeisRepository;
use App\Controller\BaseController;
use App\Entity\Agencia;
use App\Validators\AgenciaValidator;

class AgenciaController extends BaseController
{
    private AgenciaRepository $repository;
    private PapeisRepository $papRepository;

    function __construct(AgenciaRepository $repository, PapeisRepository $papRepository)
    {
        $this->repository = $repository;
        $this->papRepository = $papRepository;
    }

    #[Route('/agencia/{id}', name: 'find_by_id_agencia', methods: "GET")]
    public function buscar(int $id = 0): Response {
        
        $registers = $this->repository->findById($id);

        return $this->ResponseJson(
            array_map(
                function (Agencia $value) {
                    return $value->toArray();
                },
                $registers
            ), 
            200
        );
    }

    #[Route('/agencia', name: 'list_agencia', methods: "GET")]
    public function listar(): Response {
        return $this->buscar(0);
    }

    #[Route('/agencia/criar', name: 'criar_agencia', methods: "POST")]
    public function criar(Request $request): Response {
        $input = $this->GetJsonData($request);
        $validator = AgenciaValidator::obter($input, AgenciaValidator::class, ["mode" => "create"]);

        if ($validator->falha())
            return $this->ResponseJson($validator->errors, 400);

        if (!$this->IsAdmin($this->papRepository))
            return $this->ResponseJson($validator->errors, 403);

        $entity = new Agencia();
        $entity->setGerenteId($this->getDataOfJsonUsingKey($input, "gerente_id", 0));
        $entity->setEnderecoId($this->getDataOfJsonUsingKey($input, "endereco_id", 0));

        $this->repository->save($entity, true);
        return $this->ResponseJson([ "id" => $entity->getId()], 200);
    }

    #[Route('/agencia/mudar', name: 'atualizar_agencia', methods: "PUT")]
    public function mudar(Request $request): Response {
        // $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $input = $this->GetJsonData($request);
        $validator = AgenciaValidator::obter($input, AgenciaValidator::class, ["mode" => "change"]);

        if ($validator->falha())
            return $this->ResponseJson($validator->errors, 400);

        if (!$this->IsAdmin($input['credential_id'], $this->papRepository))
            return $this->ResponseJson($validator->errors, 403);
        $entity = $this->repository->findById($this->getDataOfJsonUsingKey($input, "agencia_id", 0));

        if (count($entity) == 0)
            return $this->ResponseJson([], 404);

        $entity = $entity[0];
        $entity->setGerenteId($this->getDataOfJsonUsingKey($input, "gerente_id", 0));
        $entity->setEnderecoId($this->getDataOfJsonUsingKey($input, "endereco_id", 0));

        $this->repository->save($entity, true);
        return $this->ResponseJson([], 200);
    }
}
