<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findById($id){
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $id)
            ->orderBy('a.publishing_date', 'ASC')
            ->getQuery();

        return $qb->getSingleResult();
    }

    public function findPublishedWithOffset($offset, $limit)
    {
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.status = true')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('a.publishing_date', 'DESC')
            ->getQuery();

        return $qb->getResult();
    }

    public function getNbPublishedArticle()
    {
        $qb = $this->createQueryBuilder('a');
            $qb->where('a.status = true');
            $qb->select($qb->expr()->count('a.id'));

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findPublishedById($id)
    {
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->andWhere('a.status = true')
            ->setParameter('id', $id)
            ->getQuery();

        return $qb->getSingleResult();
    }

    public function findWithOffset($offset, $limit){
        $qb = $this->createQueryBuilder('a')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('a.modification_date', 'DESC')
            ->getQuery();

        return $qb->getResult();
    }
}
