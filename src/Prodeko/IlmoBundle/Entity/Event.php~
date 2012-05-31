<?php

namespace Prodeko\IlmoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prodeko\IlmoBundle\Entity\Event
 */
class Event
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
     * @var datetime $takes_place
     */
    private $takes_place;


    /**
     * Set takes_place
     *
     * @param datetime $takesPlace
     */
    public function setTakesPlace($takesPlace)
    {
        $this->takes_place = $takesPlace;
    }

    /**
     * Get takes_place
     *
     * @return datetime 
     */
    public function getTakesPlace()
    {
        return $this->takes_place;
    }
    /**
     * @var datetime $registration_starts
     */
    private $registration_starts;


    /**
     * Set registration_starts
     *
     * @param datetime $registrationStarts
     */
    public function setRegistrationStarts($registrationStarts)
    {
        $this->registration_starts = $registrationStarts;
    }

    /**
     * Get registration_starts
     *
     * @return datetime 
     */
    public function getRegistrationStarts()
    {
        return $this->registration_starts;
    }
    /**
     * @var datetime $registration_ends
     */
    private $registration_ends;

    /**
     * @var string $location
     */
    private $location;

    /**
     * @var string $summary
     */
    private $summary;

    /**
     * @var text $description
     */
    private $description;


    /**
     * Set registration_ends
     *
     * @param datetime $registrationEnds
     */
    public function setRegistrationEnds($registrationEnds)
    {
        $this->registration_ends = $registrationEnds;
    }

    /**
     * Get registration_ends
     *
     * @return datetime 
     */
    public function getRegistrationEnds()
    {
        return $this->registration_ends;
    }

    /**
     * Set location
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set summary
     *
     * @param string $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @var Prodeko\IlmoBundle\Entity\Registration
     */
    private $registrations;

    public function __construct()
    {
        $this->registrations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @var Prodeko\IlmoBundle\Entity\FreeTextField
     */
    private $free_text_fields;


    /**
     * Add free_text_fields
     *
     * @param Prodeko\IlmoBundle\Entity\FreeTextField $freeTextFields
     */
    public function addFreeTextField(\Prodeko\IlmoBundle\Entity\FreeTextField $freeTextFields)
    {
        $this->free_text_fields[] = $freeTextFields;
    }

    /**
     * Get free_text_fields
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFreeTextFields()
    {
        return $this->free_text_fields;
    }
}