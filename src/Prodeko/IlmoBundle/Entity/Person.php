<?php

namespace Prodeko\IlmoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prodeko\IlmoBundle\Entity\Person
 */
class Person
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
}