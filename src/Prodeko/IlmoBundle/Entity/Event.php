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
		$this->multipleChoiceFields = new ArrayCollection();
		$this->registrations = new ArrayCollection();
		$this->quotas = new ArrayCollection();
		$this->kiltisilmo = true; //Poista tämä, jos sallitaan kiltisilmottomat
								  //tapahtumat
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
     * @var Prodeko\IlmoBundle\Entity\MultipleChoiceField
     */
    private $multipleChoiceFields;
    
    
    /**
     * Add multipleChoiceFields
     *
     * @param Prodeko\IlmoBundle\Entity\MultipleChoiceField $multipleChoiceFields
     */
    public function addMultipleChoiceField(\Prodeko\IlmoBundle\Entity\MultipleChoiceField $multipleChoiceFields)
    {
    	$this->multipleChoiceFields[] = $multipleChoiceFields;
    }
    
    /**
     * Get multipleChoiceFields
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getMultipleChoiceFields()
    {
    	return $this->multipleChoiceFields;
    }
    
    /**
     * Set multipleChoiceFields
     *
     * @param $multipleChoiceFields
     */
    public function setMultipleChoiceFields( $multipleChoiceFields)
    {
    	$this->multipleChoiceFields = $multipleChoiceFields;
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
    


    /**
     * @var boolean $kiltisilmo
     */
    private $kiltisilmo;


    /**
     * Set kiltisilmo
     *
     * @param boolean $kiltisilmo
     */
    public function setKiltisilmo($kiltisilmo)
    {
        $this->kiltisilmo = $kiltisilmo;
    }

    /**
     * Get kiltisilmo
     *
     * @return boolean 
     */
    public function getKiltisilmo()
    {
        return $this->kiltisilmo;
    }
    /**
     * @var Prodeko\IlmoBundle\Entity\Quota
     */
    private $quotas;


    /**
     * Add quotas
     *
     * @param Prodeko\IlmoBundle\Entity\Quota $quotas
     */
    public function addQuota(\Prodeko\IlmoBundle\Entity\Quota $quota)
    {
        $this->quotas[] = $quota;
    }

    /**
     * Get quotas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQuotas()
    {
        return $this->quotas;
    }
    
    /**
     * Set quotas
     * @param unknown_type $quotas
     */
    public function setQuotas($quotas)
    {
    	$this->quotas = $quotas;
    }
    
    /**
     * Returns true if Event has any FreeTextFields
     * to fill out
     * @return boolean
     */
    public function hasFreeTextFields()
    {
    	return count($this->freeTextFields) > 0;
    }
    
    /**
     * Returns true if Event has any MultipleChoiceFields
     * to fill out
     * @return boolean
     */
    public function hasMultipleChoiceFields()
    {
    	return count($this->multipleChoiceFields) > 0;
    }

    
    public function registrationEnded()
    {
    	$time = new \DateTime();
    	return $time > $this->registrationEnds;
    }
    /**
     * @var integer $sizeOfOpenQuota
     */
    private $sizeOfOpenQuota;


    /**
     * Set sizeOfOpenQuota
     *
     * @param integer $sizeOfOpenQuota
     */
    public function setSizeOfOpenQuota($sizeOfOpenQuota)
    {
        $this->sizeOfOpenQuota = $sizeOfOpenQuota;
    }

    /**
     * Get sizeOfOpenQuota
     *
     * @return integer 
     */
    public function getSizeOfOpenQuota()
    {
        return $this->sizeOfOpenQuota;
    }
}