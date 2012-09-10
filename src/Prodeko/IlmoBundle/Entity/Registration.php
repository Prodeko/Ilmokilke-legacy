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
     * @var string $phone
     */
    private $phone;
    
    /**
     * @var string $token
     */
    private $token;
    
    /**
     * @var Prodeko\IlmoBundle\Entity\Person
     */
    private $person;
    
    /**
     * @var Prodeko\IlmoBundle\Entity\Event
     */
    private $event;
    
    /**
     * @var Prodeko\IlmoBundle\Entity\Quota
     */
    private $quota;

    /**
     * @var Prodeko\IlmoBundle\Entity\FreeTextEntry
     */
    private $freeTextEntries;
    
    /**
     * @var Prodeko\IlmoBundle\Entity\MultipleChoiceEntry
     */
    private $multipleChoiceEntries;


    public function __construct()
    {
        $this->freeTextEntries = new \Doctrine\Common\Collections\ArrayCollection();
        $this->multipleChoiceEntries = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Returns 1, if $registration2 took place earlier than $registration1, 1 if
     * conversely and 0 if they took place at the same time. Used for sorting
     * registration lists.
     * 
     * @param Prodeko\Ilmobundle\Entity\Registration $registration1
     * @param Prodeko\Ilmobundle\Entity\Registration $registration2
     * 
     * @return int
     */
    public static function compareByRegistrationTime($registration1, $registration2)
    {
    	$time1 = $registration1->getRegistrationTime();
    	$time2 = $registration2->getRegistrationTime();
    	if($time1 == $time2) {
    		return 0;
    	}
    	return ($time1 > $time2) ? 1 : -1;
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
     * Set phone
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
    	$this->phone = $phone;
    }
    
    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
    	return $this->phone;
    }
    
    /**
     * Set token
     *
     * @param string $token
     */
    public function setToken($token)
    {
    	$this->token = $token;
    }
    
    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
    	return $this->token;
    }
    
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
     * Add multipleChoiceEntries
     *
     * @param Prodeko\IlmoBundle\Entity\MultipleChoiceEntry $multipleChoiceEntries
     */
    public function addMultipleChoiceEntry(\Prodeko\IlmoBundle\Entity\MultipleChoiceEntry $multipleChoiceEntries)
    {
        $this->multipleChoiceEntries[] = $multipleChoiceEntries;
    }

    /**
     * Get multipleChoiceEntries
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMultipleChoiceEntries()
    {
        return $this->multipleChoiceEntries;
    }
    
    /**
     * Set multipleChoiceEntries
     *
     * @param $multipleChoiceEntries
     */
    public function setMultipleChoiceEntries($multipleChoiceEntries)
    {
    	$this->multipleChoiceEntries = $multipleChoiceEntries;
    }
}