<?php

namespace Prodeko\IlmoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Prodeko\IlmoBundle\Entity\Event
 */
class Event
{
	/**
	 * @var integer $sizeOfOpenQuota
	 */
	private $sizeOfOpenQuota;
	
	/**
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @var string $name
	 */
	private $name;
	
	/**
	 * @var datetime $takesPlace
	 */
	private $takesPlace;
	
	/**
	 * @var datetime $registrationStarts
	 */
	private $registrationStarts;
	
	/**
	 * @var datetime $registration_ends
	 */
	private $registrationEnds;
	
	/**
	 * @var boolean $kiltisilmo
	 */
	private $kiltisilmo;

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
	 * @var Prodeko\IlmoBundle\Entity\Quota
	 */
	private $quotas;
	
	/**
	 * @var Prodeko\IlmoBundle\Entity\FreeTextField
	 */
	private $freeTextFields;
	
	/**
	 * @var Prodeko\IlmoBundle\Entity\MultipleChoiceField
	 */
	private $multipleChoiceFields;
	
	/**
	 * @var Prodeko\IlmoBundle\Entity\Registration
	 */
	private $registrations;
	

	
	public function __construct()
	{
		$this->freeTextFields = new ArrayCollection();
		$this->multipleChoiceFields = new ArrayCollection();
		$this->registrations = new ArrayCollection();
		$this->quotas = new ArrayCollection();
		$this->kiltisilmo = true; //Poista tämä, jos sallitaan kiltisilmottomat
								  //tapahtumat
	}
	
	/**
	 * Returns true if the registration for the event is currently open.
	 * 
	 * @return boolean
	 */
	public function registrationOpen() {
		$now = new \DateTime();
		return($this->registrationStarts  < $now && $now < $this->registrationEnds); 
	}
	
	/**
	 * Returns true if the registration for the event has already ended
	 *
	 * @return boolean
	 */
	public function registrationEnded()
	{
		$time = new \DateTime();
		return $time > $this->registrationEnds;
	}
	
	/**
	 * Returns true if the guild room registration (3h earlier) for the event
	 * is currently open
	 * 
	 * @return boolean
	 */
	public function kiltisRegistrationOpen() {
		$now = new \DateTime();
		$now = $now->add(new \DateInterval('PT3H'));
		return($this->registrationStarts  < $now && $now < $this->registrationEnds);
	}
	
	/**
	 * Returns the time when the registration at the guild room starts
	 * 
	 * @return \DateTime
	 */
	public function kiltisRegistrationStarts() {
		return $this->registrationStarts->sub(new \DateInterval('PT3H'));
	}
	
	/**
	 * Returns true if Event has any defined Quotas
	 * 
	 * @return boolean
	 */
	public function hasQuotas()
	{
		return count($this->quotas) > 0;
	}
	
	/**
	 * Returns true if Event has any FreeTextFields to fill out
	 * 
	 * @return boolean
	 */
	public function hasFreeTextFields()
	{
		return count($this->freeTextFields) > 0;
	}
	
	/**
	 * Returns true if Event has any MultipleChoiceFields to fill out
	 * 
	 * @return boolean
	 */
	public function hasMultipleChoiceFields()
	{
		return count($this->multipleChoiceFields) > 0;
	}
	


	/**
	 * Get registrations that fit in quotas or open quota
	 *
	 * @return array
	 */
	public function getRegistrations()
	{
		$registrations = array();
		foreach($this->quotas as $quota) {
			$registrations = array_merge($registrations, $quota->getRegistrations());
		}
		$registrations = array_merge($registrations, $this->getOpenQuotaRegistrations());
		return $registrations;
	}
	/**
	 * Get all registrations whether they fit in quotas or not.
	 * 
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function getAllRegistrations()
	{
		return $this->registrations;
	}
	
	/**
	 * A helper method that returns the composite of queue and registrations in
	 * open quota to be further divided
	 * 
	 * @return array
	 */
	public function getNonQuotaRegistrations(){
		if (!$this->hasQuotas()) 
		{
			return $this->registrations->toArray();
		}
		$queue = array();
		foreach($this->quotas as $quota) {
			$queue = array_merge($queue,$quota->getQueue());
		}
		usort($queue, array('\Prodeko\IlmoBundle\Entity\Registration', 'compareByRegistrationTime'));
		return $queue;
	}
	
	/**
	 * Returns all registrations in the open quota.
	 * 
	 * @return array
	 */
	public function getOpenQuotaRegistrations()
	{
		return array_slice($this->getNonQuotaRegistrations(), 0, $this->sizeOfOpenQuota);
	}
	
	/**
	 * Returns those registrations that don't fit in their specified quota
	 * or the open quota
	 * 
	 * @return array
	 */
	public function getQueue()
	{
		return array_slice($this->getNonQuotaRegistrations(), $this->sizeOfOpenQuota);
	}
	
	/**
	 * Returns the number of free seats in the open quota, that is, how many 
	 * registrations still fit in the open quota.
	 * 
	 * @return int:
	 */
	public function getFreeSeatsInOpenQuota()
	{
		return $this->getSizeOfOpenQuota() - count($this->getOpenQuotaRegistrations());
	}
	
	/**
	 * Returns the fill rate of the open (the ratio of registrations in open
	 * quota to size of the open quota) quota as a percentage in range [0,100]
	 * 
	 * @return number
	 */
	public function getOpenQuotaFill()
	{
		if($this->sizeOfOpenQuota > 0)
		{
			return ($this->getSizeOfOpenQuota()-$this->getFreeSeatsInOpenQuota())/$this->getSizeOfOpenQuota()*100;
		}
		else return 0;
	}

	
	/*****************DEFAULT GETTERS AND SETTERS BELOW***********************/
	
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
     * Set takes_place
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
     * Add registrations
     *
     * @param Prodeko\IlmoBundle\Entity\Registration $registrations
     */
    public function addRegistration(\Prodeko\IlmoBundle\Entity\Registration $registrations)
    {
        $this->registrations[] = $registrations;
    }

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
     * Set freeTextFields
     *
     * @param $freeTextFields
     */
    public function setFreeTextFields( $freeTextFields)
    {
    	$this->freeTextFields = $freeTextFields;
    }

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