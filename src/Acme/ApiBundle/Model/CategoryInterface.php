<?php

namespace Acme\ApiBundle\Model;

Interface CategoryInterface
{
    /**
     * Set name
     *
     * @param string $name
     * @return PageInterface
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

}