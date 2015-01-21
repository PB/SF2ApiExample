<?php

namespace Acme\ApiBundle\DataFixtures\ORM;

use Acme\ApiBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\ApiBundle\Entity\Hardware;

class LoadHardwareData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     */
    function load(ObjectManager $manager)
    {
        $laptopCategory = $manager->getRepository('Acme\ApiBundle\Entity\Category')->findOneBy(array('name' => 'Laptopy'));

        $laptop = new Hardware();
        $laptop->setName('Acer');
        $laptop->setSerial('ACERX23');
        $laptop->setAvailable(true);
        $laptop->setCategory($laptopCategory);

        $laptop1 = new Hardware();
        $laptop1->setName('Lenovo');
        $laptop1->setSerial('LENOVOXC23');
        $laptop1->setAvailable(true);
        $laptop1->setCategory($laptopCategory);

        $laptop2 = new Hardware();
        $laptop2->setName('Asus');
        $laptop2->setSerial('AUSUXCD12');
        $laptop2->setAvailable(true);
        $laptop2->setCategory($laptopCategory);

        $printerCategory = $manager->getRepository('Acme\ApiBundle\Entity\Category')->findOneBy(array('name' => 'Drukarki'));

        $printer = new Hardware();
        $printer->setName('HP');
        $printer->setSerial('HP-123');
        $printer->setAvailable(true);
        $printer->setCategory($printerCategory);

        $manager->persist($laptop);
        $manager->persist($laptop1);
        $manager->persist($laptop2);
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
       return 2;
    }
}