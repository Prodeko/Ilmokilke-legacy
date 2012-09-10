<?php

namespace Prodeko\IlmoBundle\Entity;

use Doctrine\ORM\EntityRepository;

use Doctrine\ORM\EntityManager;

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
     * Get registrations that fit in the quota
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRegistrations()
    {
    	//palauttaa vain tapahtumaan mahtuneet
        return $this->registrations->slice(0,$this->getSize());
    }
    
    /**
     * Get registrations in queue, i.e. the complement of
     * $this->getRegistrations()
     */
    public function getQueue()
    {
    	$queue = $this->registrations->slice($this->getSize());
    	return $queue;
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
    
    public function getFreeSeats()
    {
    	$registrants = count($this->registrations);
    	if($registrants < $this->size) {
    		return $this->size - $registrants;
    	}
    	else {
    		return 0;
    	}
    }
    
    public function hasFreeSeats()
    {
    	return $this->getFreeSeats() > 0;
    }
    
    public function getQueueLength()
    {
    	return $this->registrations->count() - $this->getSize();
    }
    
    public function getFill()
    {
    	if($this->size > 0) {
    		return 100 - 100*$this->getFreeSeats() / $this->size;
    	}
    	return 0;
    }
}