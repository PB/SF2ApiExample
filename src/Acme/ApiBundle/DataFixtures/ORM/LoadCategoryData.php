<?php

namespace Acme\ApiBundle\DataFixtures\ORM;

use Acme\ApiBundle\Entity\Category;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategoryData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     */
    function load(ObjectManager $manager)
    {
        $laptop = new Category();
        $laptop->setName('Laptopy');

        $monitor = new Category();
        $monitor->setName('Monitory');

        $printer = new Category();
        $printer->setName('Drukarki');

        $manager->persist($laptop);
        $manager->persist($monitor);
        $manager->persist($printer);

        $manager->flush();
    }
}