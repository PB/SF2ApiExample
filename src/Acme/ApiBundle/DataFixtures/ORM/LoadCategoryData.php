<?php

namespace Acme\ApiBundle\DataFixtures\ORM;

use Acme\ApiBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
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

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 1;
    }
}