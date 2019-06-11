<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TagsFixtures extends Fixture
{
    const TAGS = [ 'production', 'development', 'devOPS', 'SEO'];

    public function load(ObjectManager $manager)
    {
        foreach (self::TAGS as $tagName){
            $tag = new Tag();
            $tag->setName($tagName);
            $manager->persist($tag);
        }
        $manager->flush();
    }
}
