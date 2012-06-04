<?php

namespace Prodeko\IlmoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prodeko\IlmoBundle\Entity\QuotaInEvent
 */
class QuotaInEvent
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $size
     */
    private $size;

    /**
     * @var Prodeko\IlmoBundle\Entity\Event
     */
    private $event;


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
    /**
     * @var Prodeko\IlmoBundle\Entity\Quota
     */
    private $quota;


    /**
     * Set quota
     *
     * @param Prodeko\IlmoBundle\Entity\Quota $quota
     */
    public function setQuota(\Prodeko\IlmoBundle\Entity\Quota $quota)
    {
        $this->quota = $quota;
    }

    /**
     * Get quota
     *
     * @return Prodeko\IlmoBundle\Entity\Quota 
     */
    public function getQuota()
    {
        return $this->quota;
    }
    
    /**
     * Get name of the referenced quota
     */
  	public function getName()
  	{
  		return $this->quota->getName();
  	}
  	
  	/**
  	 * Get the yearOfStudiesValue of the referenced quota
  	 */
  	public function getYearOfStudiesValue()
  	{
  		return $this->quota->getYearOfStudiesValue();
  	}
}