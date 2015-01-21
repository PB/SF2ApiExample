<?php

namespace Acme\ApiBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Acme\ApiBundle\Model\HardwareInterface;
use Acme\ApiBundle\Form\HardwareType;
use Acme\ApiBundle\Exception\InvalidFormException;

class HardwareHandler implements HardwareHandlerInterface
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
     * Get a Hardware.
     *
     * @param mixed $id
     *
     * @return HardwareInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Create a new Hardware.
     *
     * @param array $parameters
     *
     * @return HardwareInterface
     */
    public function post(array $parameters)
    {
        $hardware = $this->createHardware();
        return $this->processForm($hardware, $parameters, 'POST');
    }

    /**
     * Processes the form.
     *
     * @param HardwareInterface $category
     * @param array         $parameters
     * @param String        $method
     *
     * @return HardwareInterface
     *
     * @throws \Acme\ApiBundle\Exception\InvalidFormException
     */
    private function processForm($hardware, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new HardwareType(), $hardware, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {
            $hardware = $form->getData();
            $this->om->persist($hardware);
            $this->om->flush($hardware);
            return $hardware;
        }
        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createHardware()
    {
        return new $this->entityClass();
    }

    /**
     * Edit a Hardware.
     *
     * @param HardwareInterface $category
     * @param array         $parameters
     *
     * @return HardwareInterface
     */
    public function put( $hardware, array $parameters)
    {
        return $this->processForm($hardware, $parameters, 'PUT');
    }

    /**
     * Partially update a Hardware.
     *
     * @param HardwareInterface $hardware
     * @param array         $parameters
     *
     * @return HardwareInterface
     */
    public function patch( $hardware, array $parameters)
    {
        return $this->processForm($hardware, $parameters, 'PATCH');
    }

    /**
     * Delete a Hardware.
     *
     * @param mixed $id
     *
     * @return HardwareInterface
     */
    public function delete($id)
    {
        $hardware = $this->get($id);
        $this->om->remove($hardware);
        $this->om->flush($hardware);
        return true;
    }

    /**
     * Get a list of Hardware.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     * @param boolean $available available or not
     * @param int $category category id
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0, $available = null, $category = null)
    {

        if(0 == $limit){ //list all, so offset set to 0
            $limit = null;
            $offset = 0;
        }
        $query = array();
        if($available !== null){
            $query['available'] = $available;
        }
        if($category !== null){
            $query['category'] = $category;
        }
        return $this->repository->findBy($query, null, $limit, $offset);
    }
}