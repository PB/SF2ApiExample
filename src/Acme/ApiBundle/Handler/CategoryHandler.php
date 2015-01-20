<?php

namespace Acme\ApiBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
//use Symfony\Component\Form\FormFactoryInterface;
use Acme\ApiBundle\Model\CategoryInterface;
//use Acme\ApiBundle\Form\PageType;
//use Acme\ApiBundle\Exception\InvalidFormException;

class CategoryHandler implements CategoryHandlerInterface
{
    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
    }

    /**
     * Get a Category.
     *
     * @param mixed $id
     *
     * @return CategoryInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }


}