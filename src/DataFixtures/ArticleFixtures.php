<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Service\Slugify;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i = 0; $i < 50; $i++) {
            $article = new Article();
            $article->setTitle(mb_strtolower($faker->sentence()));
            $article->setContent($faker->text(200));
            $article->setSlug($this->slugify->generate($article->getTitle()));
            if ($i % 2 === 0) {
                $article->setAuthor($this->getReference('author'));
            } else {
                $article->setAuthor($this->getReference('admin'));
            }
            $manager->persist($article);
            $article->setCategory($this->getReference('categorie_' . rand(0, 7)));
        }
        $manager->flush();
    }
}
