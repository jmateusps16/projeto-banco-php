<?php

namespace App\Repository;

use App\Entity\Agencia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Agencia>
 *
 * @method Agencia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agencia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agencia[]    findAll()
 * @method Agencia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgenciaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agencia::class);
    }

    public function save(Agencia $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Agencia $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Agencia[] Returns an array of Agencia objects
     */
    public function findById(int $id): array
    {
        $query_builder = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from(Agencia::class, 'p');

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
    * @return Agencia[] Returns an array of Agencia objects
    */
    public function findAll(): array
    {
        $query_builder = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from(Agencia::class, 'p');

        return $query_builder
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Agencia[] Returns an array of Agencia objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Agencia
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
