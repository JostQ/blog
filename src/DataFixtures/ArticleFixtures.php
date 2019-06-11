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
    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i = 0; $i < 50; $i++) {
            $article = new Article();
            $slugify = new Slugify();
            $article->setTitle(mb_strtolower($faker->sentence()));
            $article->setContent($faker->text(200));
            $article->setSlug($slugify->generate($article->getTitle()));
            $manager->persist($article);
            $article->setCategory($this->getReference('categorie_' . rand(0, 7)));
        }
        $manager->flush();
    }
}
