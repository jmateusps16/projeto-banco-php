<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MovimentacaoRepository;
use App\Controller\BaseController;
use App\Entity\Movimentacao;
use App\Validators\MovimentacaoValidator;
use DateTime;

class MovimentacaoController extends BaseController
{
    private MovimentacaoRepository $repository;

    function __construct(MovimentacaoRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/criarmovimentacao', name: 'app_criar_movimentacao')]
    public function index(): Response
    {
        return $this->render('movimentacao/index.html.twig', [
            'controller_name' => 'MovimentacaoController',
        ]);
    }

    #[Route('/movimentacao/{id}', name: 'bind_by_id_Movimentacao', methods: "GET")]
    public function buscar(int $id = 0): Response {
        $registers = $this->repository->findById($id);

        return $this->ResponseJson(
            array_map(
                function (Movimentacao $value) {
                    return $value->toArray();
                }, 
                $registers
            ), 
            200
        );
    }

    #[Route('/movimentacao/saida/criar', name: 'cirar_movimentacao_saida', methods: "POST")]
    public function criarSaida(Request $request): Response {
        $data = $this->GetJsonData($request);
        $validator = MovimentacaoValidator::obter($data, MovimentacaoValidator::class, ["mode" => "create"]);

        if ($validator->falha())
            return $this->ResponseJson($validator->errors, 400);

        $entity = new Movimentacao();

        $entity->setContaRemetenteId($this->getDataOfJsonUsingKey($data, "conta_id", null));
        $entity->setContaDestinoId($this->getDataOfJsonUsingKey($data, "conta_destino_id", null));
        $entity->setValor($this->getDataOfJsonUsingKey($data, "valor", null));
        $entity->setStatus(2);
        $entity->setTipo($this->getDataOfJsonUsingKey($data, "tipo", null));
        $entity->setData(new DateTime());

        $this->repository->save($entity, true);
        return $this->ResponseJson([ "id" => $entity->getId() ], 200);
    }

    #[Route('/movimentacao/entrada/criar', name: 'cirar_movimentacao_entrada', methods: "POST")]
    public function criarEntrada(Request $request): Response {
        $data = $this->GetJsonData($request);
        $validator = MovimentacaoValidator::obter($data, MovimentacaoValidator::class, ["mode" => "create1"]);

        if ($validator->falha())
            return $this->ResponseJson($validator->errors, 400);

        $entity = new Movimentacao();

        $entity->setContaRemetenteId($this->getDataOfJsonUsingKey($data, "conta_id", null));
        $entity->setValor($this->getDataOfJsonUsingKey($data, "valor", null));
        $entity->setStatus(1);
        $entity->setTipo($this->getDataOfJsonUsingKey($data, "tipo", null));
        $entity->setData(new DateTime());

        $this->repository->save($entity, true);
        return $this->ResponseJson([ "id" => $entity->getId() ], 200);
    }
}