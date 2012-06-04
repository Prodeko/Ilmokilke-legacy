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
     * @var datetime $registrationTime
     */
    private $registrationTime;

    /**
     * @var string $firstName
     */
    private $firstName;

    /**
     * @var string $lastName
     */
    private $lastName;

    /**
     * @var string $email
     */
    private $email;

    /**
     * @var string $allergies
     */
    private $allergies;

    /**
     * @var Prodeko\IlmoBundle\Entity\FreeTextEntry
     */
    private $freeTextEntries;

    /**
     * @var Prodeko\IlmoBundle\Entity\Event
     */
    private $event;

    public function __construct()
    {
        $this->freeTextEntries = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set registrationTime
     *
     * @param datetime $registrationTime
     */
    public function setRegistrationTime($registrationTime)
    {
        $this->registrationTime = $registrationTime;
    }

    /**
     * Get registrationTime
     *
     * @return datetime 
     */
    public function getRegistrationTime()
    {
        return $this->registrationTime;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set allergies
     *
     * @param string $allergies
     */
    public function setAllergies($allergies)
    {
        $this->allergies = $allergies;
    }

    /**
     * Get allergies
     *
     * @return string 
     */
    public function getAllergies()
    {
        return $this->allergies;
    }

    /**
     * Add freeTextEntries
     *
     * @param Prodeko\IlmoBundle\Entity\FreeTextEntry $freeTextEntries
     */
    public function addFreeTextEntry(\Prodeko\IlmoBundle\Entity\FreeTextEntry $freeTextEntries)
    {
        $this->freeTextEntries[] = $freeTextEntries;
    }

    /**
     * Get freeTextEntries
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFreeTextEntries()
    {
        return $this->freeTextEntries;
    }
    
    /**
     * Set freeTextEntries
     *
     * @param $freeTextEntries
     */
    public function setFreeTextEntries( $freeTextEntries)
    {
    	$this->freeTextEntries = $freeTextEntries;
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