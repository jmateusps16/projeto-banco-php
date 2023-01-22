<?php

namespace App\DataFixtures;

use App\Entity\Agencia;
use App\Entity\Endereco;
use App\Entity\Papeis;
use App\Entity\Pessoa;
use App\Entity\TipoConta;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct (
        private UserPasswordHasherInterface $hasher
    )
    {}

    public function load(ObjectManager $manager): void

    {
        //Primeira carga com Endereco
        $endereco1 = new Endereco;
        $endereco1->setLogradouro('Rua de teste');
        $endereco1->setNumero('102');
        $endereco1->setBairro('vila torres');
        $endereco1->setEstado('pernambuco');
        $endereco1->setCep('50100231');
        $manager->persist($endereco1);
        $manager->flush();

        //Primeira carga com Pessoa
        $pessoa1 = new Pessoa;
        $pessoa1->setDocumento('32115914785');
        $pessoa1->setNome('Pessoa Teste');
        $pessoa1->setTipoPessoa('1');
        $pessoa1->setEnderecoId('1');
        $manager->persist($pessoa1);
        $manager->flush();

        //Primeira carga com User
        $user1 = new User();
        $user1->setEmail('user@teste.com.br');
        $user1->setPassword($this->hasher->hashPassword($user1, '12345678'));
        $user1->setPessoaId('1');
        $manager->persist($user1);
        $manager->flush();

        //cria os tipos de conta
        $tipoconta1 = new TipoConta;
        $tipoconta1->setDescricao('CORRENTE');
        $manager->persist($tipoconta1);
        $manager->flush();
        $tipoconta2 = new TipoConta;
        $tipoconta2->setDescricao('POUPANCA');
        $manager->persist($tipoconta2);
        $manager->flush();
        $tipoconta3 = new TipoConta;
        $tipoconta3->setDescricao('ESTUDANTE');
        $manager->persist($tipoconta3);
        $manager->flush();

        //AGENCIA
        //Endereco agencia
        $endereco2 = new Endereco;
        $endereco2->setLogradouro('Av. perto da praia');
        $endereco2->setNumero('1320');
        $endereco2->setBairro('Boa Viagem');
        $endereco2->setEstado('pernambuco');
        $endereco2->setCep('50100654');
        $manager->persist($endereco2);
        $manager->flush();

        //Pessoa Gerente
        $pessoa2 = new Pessoa;
        $pessoa2->setDocumento('96587412355');
        $pessoa2->setNome('Gerente Teste');
        $pessoa2->setTipoPessoa('2');
        $pessoa2->setEnderecoId('2');
        $manager->persist($pessoa2);
        $manager->flush();

        //Primeira carga com User
        $user2 = new User();
        $user2->setEmail('gerente@teste.com.br');
        $user2->setPassword($this->hasher->hashPassword($user2, '12345678'));
        $user2->setPessoaId('2');
        $manager->persist($user2);
        $manager->flush();

        //cria agencia pai
        $agencia1 = new Agencia;
        $agencia1->setEnderecoId('2');
        $agencia1->setGerenteId('2');
        $manager->persist($agencia1);
        $manager->flush();

        $papel1 = new Papeis();
        $papel1->setCodigoPapel(1);
        $papel1->setCodigoCredencial($user1->getId());
        $manager->persist($papel1);
        $manager->flush();

        $papel1 = new Papeis();
        $papel1->setCodigoPapel(2);
        $papel1->setCodigoCredencial($user2->getId());
        $manager->persist($papel1);
        $manager->flush();
    }
}
