<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PapeisRepository;
use App\Controller\BaseController;
use App\Entity\AberturaContaSolicitacao;
use App\Entity\Agencia;
use App\Entity\Papeis;
use App\Entity\Solicitacao;
use App\Repository\AberturaContaSolicitacaoRepository;
use App\Repository\SolicitacaoRepository;
use App\Validators\SolicitacaoValidator;

class SolicitacaoController extends BaseController
{
    private SolicitacaoRepository $repository;
    private AberturaContaSolicitacaoRepository $abRepository;
    private PapeisRepository $papRepository;

    function __construct(SolicitacaoRepository $repository, AberturaContaSolicitacaoRepository $abRepository, PapeisRepository $papRepository)
    {
        $this->repository = $repository;
        $this->abRepository = $abRepository;
        $this->papRepository = $papRepository;
    }

    private function findSoliciation($id) : array {
        $registers = array_map( function (Solicitacao $value) { return $value->toArray(); }, $this->repository->findById($id) );
        foreach ($registers as &$register) {
            switch ($register['tipo']) {
                case 1: // solicitação abertura conta
                    $register['info'] = array_map(function (AberturaContaSolicitacao $value) { return $value->toArray(); }, $this->abRepository->findBySolicitation($register['id']));
                    break;
            }
        }

        return $registers;
    }

    #[Route('/solicitacao/{id}', name: 'find_by_id_solicitacao', methods: "GET")]
    public function buscar(int $id = 0): Response {
        return $this->ResponseJson($this->findSoliciation($id), 200);
    }

    #[Route('/solicitacao', name: 'list_solicitacao', methods: "GET")]
    public function listar(): Response {
        return $this->buscar(0);
    }

    #[Route('/solicitarlogin', name: 'app_solicitar_login')]
    public function index(): Response
    {
        return $this->render('solicitacao/solicitar_login.html.twig', [
            'controller_name' => 'SolicitacaoController',
        ]);
    }

    private function criar_solicitacao_relacao(Solicitacao $solicitation, array $input, int $type) {
        $entity = null;

        switch ($type) {
            case 1:
                $entity = new AberturaContaSolicitacao();

                $entity->setNome($this->getDataOfJsonUsingKey($input, 'nome', null));
                $entity->setTipoPessoa($this->getDataOfJsonUsingKey($input, 'tipo_pessoa', null));
                $entity->setTipoConta($this->getDataOfJsonUsingKey($input, 'tipo_conta', null));
                $entity->setDocumento($this->getDataOfJsonUsingKey($input, 'documento', null));
                $entity->setCodigoEndereco($this->getDataOfJsonUsingKey($input, 'codigo_endereco', null));
                $entity->setStatus(0);
                $entity->setCodigoSolicitacao($solicitation->getId());

                $this->abRepository->save($entity, true);
                break;
        }

        return ($entity != null) ? $entity->toArray()['id']: $entity;
    }

    #[Route('/solicitacao/criar', name: 'criar_solicitacao', methods: "POST")]
    public function criar(Request $request): Response {
        $input = $this->GetJsonData($request);
        $validator = SolicitacaoValidator::obter($input, SolicitacaoValidator::class, ["mode" => "create"]);

        if ($validator->falha())
            return $this->ResponseJson($validator->errors, 400);

        $entity = new Solicitacao();

        $entity->setTipo($this->getDataOfJsonUsingKey($input, 'tipo', 0));
        $entity->setCodigoAgencia($this->getDataOfJsonUsingKey($input, 'codigo_agencia', 0));
        $entity->setDescricao($this->getDataOfJsonUsingKey($input, 'descricao', null));

        $this->repository->save($entity, true);
        $this->criar_solicitacao_relacao($entity, $input, $input['tipo']);

        return $this->ResponseJson([ 'id' => $entity->getId() ], 200);
    }
}
