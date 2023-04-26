<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 *
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(News $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    
    public function previous($id)
{
    $qb = $this->createQueryBuilder('u')
        ->select('u')

        // Filter users.
        ->where('u.id < :id')
        ->setParameter(':id', $id)

        // Order by id.
        ->orderBy('u.id', 'DESC')

        // Get the first record.
        ->setFirstResult(0)
        ->setMaxResults(1)
    ;

    $result = $qb->getQuery()->getOneOrNullResult();
}

public function next($id)
{
    $qb = $this->createQueryBuilder('u')
        ->select('u')

        ->where('u.id > :id')
        ->setParameter(':id', $id)

        ->orderBy('u.id', 'ASC')

        ->setFirstResult(0)
        ->setMaxResults(1)
    ;

    $qb->getQuery()->getOneOrNullResult();
    return($id);
}
    
    public function getPrevious($id)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')

            // Filter users.
            ->where('u.id < :id')
            ->setParameter(':id', $id)

            // Order by id.
            ->orderBy('u.id', 'DESC')

            // Get the first record.
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        $qb->getQuery()->getOneOrNullResult();
    }

    public function getNext($id)
    {
        $qb = $this->createQuery('u')
            ->select('u')

            ->where('u.id > :id')
            ->setParameter(':id', $id)

            ->orderBy('u.id', 'ASC')

            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(News $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

//    /**
//     * @return News[] Returns an array of News objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?News
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
