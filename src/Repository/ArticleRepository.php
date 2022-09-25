<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function add(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllByOrderDesc(string $lang, int $page = 1, ?string $category, ?string $orderBy): Paginator
    {
        $pageSize = 10;
        $firstResult = ($page - 1) * $pageSize;
        $language = ($lang === 'fr') ? 'french' : 'english';

        $qry = $this->createQueryBuilder('a')
            ->andWhere('a.language = :language')
            ->setParameter('language', $language);

        if ($category !== null) {
            $qry->andWhere('a.category LIKE :category')
                ->setParameter('category', '%' . $category . '%');
        }

        if ($orderBy !== null) {
            $qry->orderBy('a.id', $orderBy);
        } else {
            $qry->orderBy('a.id', 'desc');
        }

        $qry->setFirstResult($firstResult)
            ->setMaxResults($pageSize)
            ->getQuery();

        return new Paginator($qry, true);
    }

//    /**
//     * @return Article[] Returns an array of Article objects
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

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
