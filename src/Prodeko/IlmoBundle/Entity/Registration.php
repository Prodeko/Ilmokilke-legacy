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
}