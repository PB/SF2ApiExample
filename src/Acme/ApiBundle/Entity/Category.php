<?php

namespace Acme\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Hardware", mappedBy="category")
     */
    protected $hardwares;

    public function __construct()
    {
        $this->hardwares = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add hardwares
     *
     * @param \Acme\ApiBundle\Entity\Hardware $hardwares
     * @return Category
     */
    public function addHardware(\Acme\ApiBundle\Entity\Hardware $hardwares)
    {
        $this->hardwares[] = $hardwares;

        return $this;
    }

    /**
     * Remove hardwares
     *
     * @param \Acme\ApiBundle\Entity\Hardware $hardwares
     */
    public function removeHardware(\Acme\ApiBundle\Entity\Hardware $hardwares)
    {
        $this->hardwares->removeElement($hardwares);
    }

    /**
     * Get hardwares
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHardwares()
    {
        return $this->hardwares;
    }
}
