<?php

namespace Prodeko\IlmoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Prodeko\IlmoBundle\Entity\Event
 */
class Event
{
	public function __construct()
	{
		$this->freeTextFields = new ArrayCollection();
		$this->registrations = new ArrayCollection();
	}
	
	public function isOpen() {
		$now = new \DateTime();
		return ($this->registrationStarts  < $now && $now < $this->registrationEnds) ? true : false; 
	}
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


    /**
     * Set takes_place
     * MUUTTUJIEN MÄÄRITTELY ALAREUNASSA
     * @param datetime $takesPlace
     */
    public function setTakesPlace($takesPlace)
    {
        $this->takesPlace = $takesPlace;
    }

    /**
     * Get takes_place
     *
     * @return datetime 
     */
    public function getTakesPlace()
    {
        return $this->takesPlace;
    }
    /**
     * @var datetime $registration_starts
     */

    /**
     * Set registration_starts
     *
     * @param datetime $registrationStarts
     */
    public function setRegistrationStarts($registrationStarts)
    {
        $this->registrationStarts = $registrationStarts;
    }

    /**
     * Get registration_starts
     *
     * @return datetime 
     */
    public function getRegistrationStarts()
    {
        return $this->registrationStarts;
    }
    /**
     * @var datetime $registration_ends
     */
    private $registrationEnds;

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
        $this->registrationEnds = $registrationEnds;
    }

    /**
     * Get registration_ends
     *
     * @return datetime 
     */
    public function getRegistrationEnds()
    {
        return $this->registrationEnds;
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
    private $freeTextFields;


    /**
     * Add freeTextFields
     *
     * @param Prodeko\IlmoBundle\Entity\FreeTextField $freeTextFields
     */
    public function addFreeTextField(\Prodeko\IlmoBundle\Entity\FreeTextField $freeTextFields)
    {
        $this->freeTextFields[] = $freeTextFields;
    }

    /**
     * Get freeTextFields
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFreeTextFields()
    {
        return $this->freeTextFields;
    }
    /**
     * @var string $name
     */
    private $name;
    
    /**
     * Set freeTextFields
     *
     * @param $freeTextFields
     */
    public function setFreeTextFields( $freeTextFields)
    {
    	$this->freeTextFields = $freeTextFields;
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
     * @var datetime $takesPlace
     */
    private $takesPlace;

    /**
     * @var datetime $registrationStarts
     */
    private $registrationStarts;

    /**
     * @var datetime $registrationEnds
     */
    


}