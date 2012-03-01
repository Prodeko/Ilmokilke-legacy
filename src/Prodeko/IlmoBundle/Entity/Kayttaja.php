<?php

namespace Prodeko\IlmoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prodeko\IlmoBundle\Entity\Kayttaja
 */
class Kayttaja
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $firstname
     */
    private $firstname;

    /**
     * @var string $lastname
     */
    private $lastname;

    /**
     * @var string $external_id
     */
    private $external_id;

    /**
     * @var smallint $year_of_studies
     */
    private $year_of_studies;

    /**
     * @var string $email
     */
    private $email;


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
     * Set firstname
     *
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }
    
    /**
     * Get full name
     * 
     * @return string $name
     */
    public function getName()
    {
    	return $this->firstname . " " . $this->lastname;
    }

    /**
     * Set external_id
     *
     * @param string $externalId
     */
    public function setExternalId($externalId)
    {
        $this->external_id = $externalId;
    }

    /**
     * Get external_id
     *
     * @return string 
     */
    public function getExternalId()
    {
        return $this->external_id;
    }

    /**
     * Set year_of_studies
     *
     * @param smallint $yearOfStudies
     */
    public function setYearOfStudies($yearOfStudies)
    {
        $this->year_of_studies = $yearOfStudies;
    }

    /**
     * Get year_of_studies
     *
     * @return smallint 
     */
    public function getYearOfStudies()
    {
        return $this->year_of_studies;
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
     * @var Prodeko\IlmoBundle\Entity\Ilmoittautuminen
     */
    private $ilmoittautumiset;

    public function __construct()
    {
        $this->ilmoittautumiset = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add ilmoittautumiset
     *
     * @param Prodeko\IlmoBundle\Entity\Ilmoittautuminen $ilmoittautumiset
     */
    public function addIlmoittautuminen(\Prodeko\IlmoBundle\Entity\Ilmoittautuminen $ilmoittautumiset)
    {
        $this->ilmoittautumiset[] = $ilmoittautumiset;
    }

    /**
     * Get ilmoittautumiset
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getIlmoittautumiset()
    {
        return $this->ilmoittautumiset;
    }
}