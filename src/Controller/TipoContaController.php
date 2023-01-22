<?php

namespace App\Controller;

use App\Entity\TipoConta;
use App\Repository\TipoContaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TipoContaController extends BaseController
{
    private TipoContaRepository $repository;
    function __construct(TipoContaRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('tipoconta', name: 'app_tipo_conta', methods: "GET")]
    public function buscar(): Response {
        $registers = $this->repository->findAll();

        return $this->ResponseJson(
            array_map(
                function (TipoConta $value){
                    return $value->toArray();
                },
                $registers
            ),
            200
        );
    }
}
