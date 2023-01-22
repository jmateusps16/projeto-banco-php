<?php

namespace App\Repository;

use App\Entity\Movimentacao;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movimentacao>
 *
 * @method Movimentacao|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movimentacao|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movimentacao[]    findAll()
 * @method Movimentacao[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovimentacaoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movimentacao::class);
    }

    public function save(Movimentacao $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Movimentacao $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Movimentacao[] Returns an array of Agencia objects
     */
    public function findById(int $id): array
    {
        $query_builder = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from(Movimentacao::class, 'p');

        if ($id > 0)
            $query_builder = $query_builder
                ->where('p.id = :id')
                ->setParameter('id', $id);

        return $query_builder
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Movimentacao[] Returns an array of Agencia objects
     */
    public function findByMovimentacaoConta(int $conta_id): array
    {
        $query_builder = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from(Movimentacao::class, 'p');

        $query_builder = $query_builder
            ->where('p.conta_remetente_id = :conta_id')
            ->setParameter('conta_id', $conta_id);

        return $query_builder
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Movimentacao[] Returns an array of Agencia objects
     */
    public function findByMovimentacaoTransferConta(int $conta_id): array
    {
        $query_builder = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from(Movimentacao::class, 'p');

        $query_builder = $query_builder
            ->where('p.conta_destino_id = :conta_id')
            ->setParameter('conta_id', $conta_id);

        return $query_builder
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }



    //    /**
    //     * @return Movimentacao[] Returns an array of Movimentacao objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Movimentacao
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
