<?php

namespace Acme\ApiBundle\Handler;

use Acme\ApiBundle\Model\HardwareInterface;

interface HardwareHandlerInterface
{
    /**
     * Get a Category given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return CategoryInterface
     */
    public function get($id);

    /**
     * Get a list of Categories.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Post Category, creates a new Category.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return CategoryInterface
     */
    public function post(array $parameters);

    /**
     * Edit a Category.
     *
     * @api
     *
     * @param CategoryInterface   $category
     * @param array           $parameters
     *
     * @return CategoryInterface
     */
    public function put( $category, array $parameters);

    /**
     * Partially update a Category.
     *
     * @api
     *
     * @param CategoryInterface   $category
     * @param array           $parameters
     *
     * @return CategoryInterface
     */
    public function patch( $category, array $parameters);

    /**
     * Delete a Category given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return CategoryInterface
     */
    public function delete($id);
}