<?php

namespace Prodeko\IlmoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prodeko\IlmoBundle\Entity\Tapahtuma
 */
class Tapahtuma
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var text $description
     */
    private $description;

    /**
     * @var datetime $takes_place
     */
    private $takes_place;

    /**
     * @var datetime $registration_starts
     */
    private $registration_starts;

    /**
     * @var datetime $registration_ends
     */
    private $registration_ends;


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
}