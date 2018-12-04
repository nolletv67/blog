<?php
/**
 * Created by PhpStorm.
 * User: nollet
 * Date: 03/12/18
 * Time: 20:24
 */

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private $categories = ['Années1950', 'Années1960', 'Années1970', 'Années1980', 'Années1990'];

    public function load(ObjectManager $manager)
    {
        foreach ($this->categories as $key => $categoryName) {
            $category = new Category();
            $category->setName('$categoryName');
            $manager->persist($category);
            $this->addReference('categorie_' . $key, $category);
        }
        $manager->flush();
    }
}