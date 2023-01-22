<?php

namespace App\Repository;

use App\Entity\Conta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Conta>
 *
 * @method Conta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conta[]    findAll()
 * @method Conta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conta::class);
    }

    public function save(Conta $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Conta $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Conta[] Returns an array of Agencia objects
     */
    public function findById(int $id): array
    {
        $query_builder = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from(Conta::class, 'p');

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
     * @return Conta[] Returns an array of Agencia objects
     */
    public function findByPessoaId(int $id): array
    {
        $query_builder = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from(Conta::class, 'p');

        $query_builder = $query_builder
            ->where('p.cliente_id = :id')
            ->setParameter('id', $id);

        return $query_builder
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Conta[] Returns an array of Conta objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Conta
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
