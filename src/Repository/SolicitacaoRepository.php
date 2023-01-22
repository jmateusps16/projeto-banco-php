<?php

namespace App\Repository;

use App\Entity\Solicitacao;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Solicitacao>
 *
 * @method Solicitacao|null find($id, $lockMode = null, $lockVersion = null)
 * @method Solicitacao|null findOneBy(array $criteria, array $orderBy = null)
 * @method Solicitacao[]    findAll()
 * @method Solicitacao[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolicitacaoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Solicitacao::class);
    }

    public function save(Solicitacao $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Solicitacao $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return Solicitacao[] Returns an array of Agencia objects
    */
    public function findById(int $id): array
    {
        $query_builder = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from(Solicitacao::class, 'p');

        if ($id > 0)
            $query_builder = $query_builder
                ->where('p.id = :id')
                ->setParameter('id', $id);

        return $query_builder
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
