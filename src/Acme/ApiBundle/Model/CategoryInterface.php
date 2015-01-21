<?php

namespace Acme\ApiBundle\Model;

Interface CategoryInterface
{
    /**
     * Set name
     *
     * @param string $name
     * @return CategoryInterface
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

}