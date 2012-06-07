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
    /**
     * @var integer $size
     */
    private $size;

    /**
     * @var Prodeko\IlmoBundle\Entity\Registration
     */
    private $registrations;

    /**
     * @var Prodeko\IlmoBundle\Entity\Event
     */
    private $event;

    public function __construct()
    {
        $this->registrations = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set size
     *
     * @param integer $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Add registrations
     *
     * @param Prodeko\IlmoBundle\Entity\Registration $registrations
     */
    public function addRegistration(\Prodeko\IlmoBundle\Entity\Registration $registrations)
    {
        $this->registrations[] = $registrations;
    }

    /**
     * Get registrations
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRegistrations()
    {
        return $this->registrations;
    }

    /**
     * Set event
     *
     * @param Prodeko\IlmoBundle\Entity\Event $event
     */
    public function setEvent(\Prodeko\IlmoBundle\Entity\Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get event
     *
     * @return Prodeko\IlmoBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }
}