<?php

namespace App\Repository;

use App\Entity\AberturaContaSolicitacao;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AberturaContaSolicitacao>
 *
 * @method AberturaContaSolicitacao|null find($id, $lockMode = null, $lockVersion = null)
 * @method AberturaContaSolicitacao|null findOneBy(array $criteria, array $orderBy = null)
 * @method AberturaContaSolicitacao[]    findAll()
 * @method AberturaContaSolicitacao[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AberturaContaSolicitacaoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AberturaContaSolicitacao::class);
    }

    public function save(AberturaContaSolicitacao $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AberturaContaSolicitacao $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Login[] Returns an array of Agencia objects
     */
    // public function findByConta(int $conta): array
    // {
    //     $query_builder = $this
    //         ->getEntityManager()
    //         ->createQueryBuilder()
    //         ->select('p')
    //         ->from(Login::class, 'p')
    //         ->where('p.codigo_conta = :codigo_conta')
    //         ->setParameter('codigo_conta', $conta);

    //     return $query_builder
    //         ->orderBy('p.id', 'DESC')
    //         ->getQuery()
    //         ->getResult();
    // }

    /**
     * @return AberturaContaSolicitacao[] Returns an array of Agencia objects
     */
    public function findBySolicitation(int $id) : array {
        $query_builder = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from(AberturaContaSolicitacao::class, 'p')
            ->where('p.codigo_solicitacao = :id')
            ->setParameter('id', $id);

        return $query_builder
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();

    }

//    /**
//     * @return AberturaContaSolicitacao[] Returns an array of AberturaContaSolicitacao objects
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

//    public function findOneBySomeField($value): ?AberturaContaSolicitacao
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
