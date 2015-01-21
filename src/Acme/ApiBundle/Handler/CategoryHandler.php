<?php

namespace Acme\ApiBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Acme\ApiBundle\Model\CategoryInterface;
use Acme\ApiBundle\Form\CategoryType;
use Acme\ApiBundle\Exception\InvalidFormException;

class CategoryHandler implements CategoryHandlerInterface
{
    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
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

    /**
     * Create a new Category.
     *
     * @param array $parameters
     *
     * @return CategoryInterface
     */
    public function post(array $parameters)
    {
        $category = $this->createCategory();
        return $this->processForm($category, $parameters, 'POST');
    }

    /**
     * Processes the form.
     *
     * @param CategoryInterface $category
     * @param array         $parameters
     * @param String        $method
     *
     * @return CategoryInterface
     *
     * @throws \Acme\ApiBundle\Exception\InvalidFormException
     */
    private function processForm($category, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new CategoryType(), $category, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {
            $category = $form->getData();
            $this->om->persist($category);
            $this->om->flush($category);
            return $category;
        }
        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createCategory()
    {
        return new $this->entityClass();
    }

    /**
     * Edit a Category.
     *
     * @param CategoryInterface $category
     * @param array         $parameters
     *
     * @return CategoryInterface
     */
    public function put( $category, array $parameters)
    {
        return $this->processForm($category, $parameters, 'PUT');
    }

    /**
     * Partially update a Category.
     *
     * @param CategoryInterface $category
     * @param array         $parameters
     *
     * @return CategoryInterface
     */
    public function patch( $category, array $parameters)
    {
        return $this->processForm($category, $parameters, 'PATCH');
    }

    /**
     * Delete a Category.
     *
     * @param mixed $id
     *
     * @return CategoryInterface
     */
    public function delete($id)
    {
        $category = $this->get($id);
        $this->om->remove($category);
        $this->om->flush($category);
        return true;
    }

    /**
     * Get a list of Categories.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0)
    {
        return $this->repository->findBy(array(), null, $limit, $offset);
    }
}