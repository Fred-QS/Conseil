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

    public function findAllByOrderDesc(string $lang, int $page, ?string $category, ?string $orderBy, ?string $query): Paginator
    {
        $pageSize = 10;
        $firstResult = ($page - 1) * $pageSize;
        $language = ($lang === 'fr') ? 'french' : 'english';

        $qry = $this->createQueryBuilder('a');

        if ($query !== null) {
            $qry->andWhere('a.content LIKE :query')
                ->orWhere('a.title LIKE :query')
                ->orWhere('a.description LIKE :query')
                ->setParameter('query', '%' . $query . '%');
        }

        if ($category !== null) {
            $qry->andWhere('a.category LIKE :category')
                ->setParameter('category', '%' . $category . '%');
        }

        if ($orderBy !== null) {
            $qry->orderBy('a.id', $orderBy);
        } else {
            $qry->orderBy('a.id', 'desc');
        }

        $qry->andWhere('a.published = 1')
            ->andWhere('a.language = :language')
            ->setParameter('language', $language)
            ->setFirstResult($firstResult)
            ->setMaxResults($pageSize)
            ->getQuery();

        return new Paginator($qry, true);
    }

    public function getLatestArticles(string $lang): array
    {
        $language = ($lang === 'fr') ? 'french' : 'english';
        $start = date("Y-m-") . '01';
        $end = date("Y-m-") . '28';
        return $this->createQueryBuilder('a')
            ->andWhere('a.pubDate BETWEEN :start AND :end')
            ->setParameter(':start', $start)
            ->setParameter(':end', $end)
            ->andWhere('a.language = :lang')
            ->setParameter('lang', $language)
            ->andWhere('a.published = 1')
            ->orderBy('a.pubDate', 'desc')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function getUnverifiedArticles(string $lang): array
    {
        $language = ($lang === 'fr') ? 'french' : 'english';
        return $this->createQueryBuilder('a')
            ->andWhere('a.language = :lang')
            ->setParameter('lang', $language)
            ->andWhere('a.published = 0')
            ->orderBy('a.pubDate', 'desc')
            ->getQuery()
            ->getResult();
    }

    public function getCategories(string $lang): array
    {
        $language = ($lang === 'fr') ? 'french' : 'english';
        $categories = $this->createQueryBuilder('a')
            ->select("a.category")
            ->andWhere('a.published = 1')
            ->andWhere('a.language = :language')
            ->setParameter('language', $language)
            ->groupBy("a.category")
            ->getQuery()
            ->getResult();
        $final = [];
        foreach ($categories as $category) {
            $split = explode(',', $category['category']);
            foreach ($split as $item) {
                $cat = trim($item);
                if (!in_array($cat, $final, true)) {
                    $final[] = $cat;
                }
            }
        }
        return $final;
    }
}
