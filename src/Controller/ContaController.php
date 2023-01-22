<?php

namespace App\Controller;

use App\Entity\Conta;
use App\Controller\BaseController;
use App\Entity\Movimentacao;
use App\Validators\ContaValidator;
use App\Repository\ContaRepository;
use App\Repository\MovimentacaoRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ContaController extends BaseController
{
    private ContaRepository $repository;
    private MovimentacaoRepository $movRepository;

    function __construct(ContaRepository $repository, MovimentacaoRepository $movRepository)
    {
        $this->repository = $repository;
        $this->movRepository = $movRepository;
    }
    

    #[Route('/criarconta', name: 'app_criar_conta')]
    public function index(): Response
    {
        return $this->render('criarconta/index.html.twig', [
            'controller_name' => 'ContaController',
        ]);
    }

    #[Route('/extrato', name: 'app_extrato_conta')]
    public function extratoPage(): Response
    {
        return $this->render('extrato/index.html.twig', [
            'controller_name' => 'ContaController',
        ]);
    }

    #[Route('/conta/extrato/{id}', name: 'bind_by_id_Conta', methods: "GET")]
    public function extrato(int $id): Response {
        $userId = 0;
        $result = ['entrada' => 0, 'saida' => 0, 'saldo' => 0];
        try {
            try {
                $userId = (int) $this->getUser()->getPessoaId();
            }
            
            catch (\Throwable $error) {
                return $this->ResponseJson([], 503);
            }
    
            if (($id > 0) == false) return $this->ResponseJson($result, 200);
            $contas = $this->repository->findByPessoaId($userId);
            $contas = array_filter($contas, function (Conta $conta) use ($id) {
                return $conta->getId() == $id;
            });
    
            if (sizeof($contas) <= 0) return $this->ResponseJson($result, 200);
            $conta = array_values($contas)[0];
            $movimentacoes = $this->movRepository->findByMovimentacaoConta($conta->getId());
            $entradas = $this->movRepository->findByMovimentacaoTransferConta($conta->getId());

            $result['entrada'] = array_sum(
                array_map(function (Movimentacao $movimentacao) {
                    return $movimentacao->getValor();
                }, 
                array_filter(
                    $movimentacoes, 
                    function (Movimentacao $movimentacao) {
                        return $movimentacao->getStatus() == 1;
                    })
                )
            );
    
            $result['entrada'] += array_sum(
                array_map(function (Movimentacao $movimentacao) {
                    return $movimentacao->getValor();
                }, 
                array_filter(
                    $entradas, 
                    function (Movimentacao $movimentacao) {
                        return $movimentacao->getStatus() == 2;
                    })
                )
            );
    
            $result['saida'] = array_sum(
                array_map(function (Movimentacao $movimentacao) {
                    return $movimentacao->getValor();
                }, 
                array_filter(
                    $movimentacoes, 
                    function (Movimentacao $movimentacao) {
                        return $movimentacao->getStatus() == 2;
                    })
                )
            );
    
            $result['saldo'] = $result['entrada'] - $result['saida'];
            return $this->ResponseJson($result, 200);
        }

        catch (\Throwable $error) {
            dump($error->getMessage());
            return $this->ResponseJson($result, 200);
        }
    }

    #[Route('/conta', name: 'listar_Conta', methods: "GET")]
    public function listar(): Response {
        try {
            return $this->ResponseJson(array_map(function (Conta $value) { return $value->toArray();}, $this->repository->findByPessoaId((int) $this->getUser()->getPessoaId())), 200);
        }

        catch (\Throwable $error) {
            return $this->ResponseJson([], 503);
        }
    }
    
    #[Route('/conta/criar', name: 'cirar_Conta', methods: "POST")]
    public function criar(Request $request): Response {
        $userAutenticado = $this->getUser();
        if ($userAutenticado == null) {
            $this->addFlash('error', 'Usuário não logado.');
            dump('Usuário não logado.');
        } else {
            //mostra como erro no getPessoaId mas funciona, o symfony resolve
            $pessoaLogadaId = $userAutenticado->getPessoaId();
            $data = $this->GetJsonData($request);
            $validator = ContaValidator::obter($data, ContaValidator::class, ["mode" => "create"]);

            if ($validator->falha())
                return $this->ResponseJson($validator->errors, 400);

            $entity = new Conta();

            $entity->setTipoConta($this->getDataOfJsonUsingKey($data, "tipo_conta", null));
            dump($pessoaLogadaId);
            $entity->setClienteId($pessoaLogadaId);
            $entity->setSaldoAtual(0,0);
            $entity->setAgenciaId($this->getDataOfJsonUsingKey($data, "agencia_id", null));

            $this->repository->save($entity, true);
            return $this->ResponseJson([ "id" => $entity->getId() ], 200);
        }
        
    }

    #[Route('/conta/mudar', name: 'atualizar_Conta', methods: "PUT")]
    public function mudar(Request $request): Response {
        $data = $this->GetJsonData($request);
        $validator = ContaValidator::obter($data, ContaValidator::class, ["mode" => "change"]);

        if ($validator->falha())
            return $this->ResponseJson($validator->errors, 400);

        $entity = $this->repository->findById($this->getDataOfJsonUsingKey($data, "id", 0));

        if (count($entity) == 0)
            return $this->ResponseJson([], 404);
        $entity = $entity[0];

        $entity->setTipoConta($this->getDataOfJsonUsingKey($data, "tipo_conta", null));
        $entity->setClienteId($this->getDataOfJsonUsingKey($data, "cliente_id", null));
        $entity->setAgenciaId($this->getDataOfJsonUsingKey($data, "agencia_id", null));
        // $entity->setDeletadoEm($this->getDataOfJsonUsingKey($data, "deleta", null));

        $this->repository->save($entity, true);
        return $this->ResponseJson([], 200);
    }
}