<?php

namespace Prodeko\IlmoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prodeko\IlmoBundle\Entity\Quota
 */
class Quota
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var integer $yearOfStudiesValue
     */
    private $yearOfStudiesValue;


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
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Set yearOfStudiesValue
     *
     * @param integer $yearOfStudiesValue
     */
    public function setYearOfStudiesValue($yearOfStudiesValue)
    {
        $this->yearOfStudiesValue = $yearOfStudiesValue;
    }

    /**
     * Get yearOfStudiesValue
     *
     * @return integer 
     */
    public function getYearOfStudiesValue()
    {
        return $this->yearOfStudiesValue;
    }
}