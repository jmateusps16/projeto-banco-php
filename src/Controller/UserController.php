<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use App\Validators\UserValidator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends BaseController
{
    private UserRepository $repository;
    private UserPasswordHasherInterface $hasher;
    function __construct(UserRepository $repository, UserPasswordHasherInterface $hasher)
    {
        $this->repository = $repository;
        $this->hasher = $hasher;
    }

    #[Route('user/{id}', name: 'bind_by_id_User', methods: "GET")]
    public function buscar(string $id): Response {
        $registers = $this->repository->findById((int) $id);

        return $this->ResponseJson( ($registers != null ) ? $registers->toArray(): [], 200 );
    }

    #[Route('user/criar', name: 'criar_User', methods: "POST")]
    public function criar (Request $request): Response {
        $data = $this->GetJsonData($request);
        $validator = UserValidator::obter($data, UserValidator::class, ["mode" => "create"]);
    
        if ($validator->falha())
            return $this->ResponseJson($validator->errors, 400);
        $entity = new User();

        $pass = $this->getDataOfJsonUsingKey($data, "password", null)?? '';
        $entity->setEmail($this->getDataOfJsonUsingKey($data, "email", null));
        $entity->setPassword($this->hasher->hashPassword($entity, $pass));
        $entity->setPessoaId($this->getDataOfJsonUsingKey($data, "pessoa", null));

        $this->repository->save($entity, true);
        return $this->ResponseJson([ "id" => $entity->getId() ], 200);
    }
}
