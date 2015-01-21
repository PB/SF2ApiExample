<?php

namespace Acme\ApiBundle\Model;

Interface HardwareInterface
{
    /**
     * Set name
     *
     * @param string $name
     * @return HardwareInterface
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();


    /**
     * Set serial
     *
     * @param string $serial
     * @return HardwareInterface
     */
    public function setSerial($serial);

    /**
     * Get serial
     *
     * @return string
     */
    public function getSerial();


    /**
     * Set created
     *
     * @param \DateTime $created
     * @return HardwareInterface
     */
    public function setCreated($created);

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated();

    /**
     * Set available
     *
     * @param boolean $available
     * @return HardwareInterface
     */
    public function setAvailable($available);

    /**
     * Get available
     *
     * @return boolean
     */
    public function getAvailable();

    /**
     * Set category
     *
     * @param \Acme\ApiBundle\Entity\Category $category
     * @return HardwareInterface
     */
    public function setCategory(\Acme\ApiBundle\Entity\Category $category = null);


    /**
     * Get category
     *
     * @return \Acme\ApiBundle\Entity\Category
     */
    public function getCategory();

}