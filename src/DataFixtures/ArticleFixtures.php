<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Symfony\Component\Yaml\Yaml;

class ArticleFixtures extends Fixture
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $path = dirname(__DIR__, 2) . '/data/articles.yaml';
        $articles = Yaml::parseFile($path, Yaml::PARSE_CONSTANT);

        foreach ($articles as $item) {

            $article = new Article();
            $article->setTitle(str_replace('\"', '"', $item['title']));
            $article->setLink($item['link']);
            $article->setSource($item['source']);
            $article->setKeywords($item['keywords']);
            if ($item['creator'] !== '') {
                $article->setCreator($item['creator']);
            }
            $article->setImageUrl($item['imageUrl']);
            if ($item['videoUrl'] !== '') {
                $article->setVideoUrl($item['videoUrl']);
            }
            $article->setDescription(str_replace('\"', '"', $item['description']));
            $article->setPubDate($item['pubDate']);
            $article->setContent(str_replace('\"', '"', $item['content']));
            $article->setCountry(explode(',', $item['country']));
            $article->setCategory(explode(',', $item['category']));
            $article->setLanguage($item['language']);
            $article->setUri($item['uri']);
            $article->setPublished($item['published']);
            $manager->persist($article);
            $manager->flush();
        }
    }
}
