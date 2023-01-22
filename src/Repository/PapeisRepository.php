<?php

namespace App\Repository;

use App\Entity\Papeis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Papeis>
 *
 * @method Papeis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Papeis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Papeis[]    findAll()
 * @method Papeis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PapeisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Papeis::class);
    }

    public function save(Papeis $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Papeis $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Papeis[] Returns an array of Agencia objects
     */
    public function findById(array $parameters): array
    {
        $query_builder = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from(Papeis::class, 'p');

        if (key_exists('credential_id', $parameters))
            $query_builder = $query_builder
                ->where('p.codigo_credencial = :credential_id')
                ->setParameter('credential_id', $parameters['credential_id']);

        if (key_exists('id', $parameters))
            $query_builder = $query_builder
                ->where('p.id = :id')
                ->setParameter('id', $parameters['id']);

        if (key_exists('ids', $parameters))
            $query_builder = $query_builder
                ->where('p.id in :ids')
                ->setParameter('ids', $parameters['ids']);

        return $query_builder
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Papeis[] Returns an array of Agencia objects
     */
    public function findByCredential(int $credential_id = 0): array
    {
        $query_builder = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from(Papeis::class, 'p');

        $query_builder = $query_builder
            ->where('p.codigo_credencial = :credential_id')
            ->setParameter('credential_id', $$credential_id);

        return $query_builder
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult() ?? [];
    }


    

//    /**
//     * @return Papeis[] Returns an array of Papeis objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Papeis
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
