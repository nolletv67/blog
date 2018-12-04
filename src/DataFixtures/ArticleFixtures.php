<?php
/**
 * Created by PhpStorm.
 * User: nollet
 * Date: 03/12/18
 * Time: 20:50
 */

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager) {

        for ($i=0; $i <= 50; $i++) {

            $article = new Article();
            $faker = Faker\Factory::create('fr_FR');
            $article->setTitle(mb_strtolower($faker->sentence(4)));
            $article->setContent($faker->text(400));
            $article->setCategory($this->getReference('categorie_' . rand(0, 4)));

            $manager->persist($article);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}