<?php

namespace Prodeko\IlmoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prodeko\IlmoBundle\Entity\Registration
 */
class Registration
{
    /**
     * @var integer $id
     */
    private $id;


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
     * @var datetime $registration_time
     */
    private $registration_time;


    /**
     * Set registration_time
     *
     * @param datetime $registrationTime
     */
    public function setRegistrationTime($registrationTime)
    {
        $this->registration_time = $registrationTime;
    }

    /**
     * Get registration_time
     *
     * @return datetime 
     */
    public function getRegistrationTime()
    {
        return $this->registration_time;
    }
    /**
     * @var Prodeko\IlmoBundle\Entity\Person
     */
    private $person;


    /**
     * Set person
     *
     * @param Prodeko\IlmoBundle\Entity\Person $person
     */
    public function setPerson(\Prodeko\IlmoBundle\Entity\Person $person)
    {
        $this->person = $person;
    }

    /**
     * Get person
     *
     * @return Prodeko\IlmoBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }
    /**
     * @var Prodeko\IlmoBundle\Entity\Event
     */
    private $forEvent;


    /**
     * Set forEvent
     *
     * @param Prodeko\IlmoBundle\Entity\Event $forEvent
     */
    public function setForEvent(\Prodeko\IlmoBundle\Entity\Event $forEvent)
    {
        $this->forEvent = $forEvent;
    }

    /**
     * Get forEvent
     *
     * @return Prodeko\IlmoBundle\Entity\Event 
     */
    public function getForEvent()
    {
        return $this->forEvent;
    }
    /**
     * @var Prodeko\IlmoBundle\Entity\Event
     */
    private $event;


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