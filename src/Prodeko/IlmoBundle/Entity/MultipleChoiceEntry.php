<?php

namespace Prodeko\IlmoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prodeko\IlmoBundle\Entity\MultipleChoiceEntry
 */
class MultipleChoiceEntry
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
     * @var integer $selection
     */
    private $selection;

    /**
     * @var Prodeko\IlmoBundle\Entity\Registration
     */
    private $registration;

    /**
     * @var Prodeko\IlmoBundle\Entity\MultipleChoiceField
     */
    private $field;


    /**
     * Set selection
     *
     * @param integer $selection
     */
    public function setSelection($selection)
    {
        $this->selection = $selection;
    }

    /**
     * Get selection
     *
     * @return integer 
     */
    public function getSelection()
    {
        return $this->selection;
    }

    /**
     * Set registration
     *
     * @param Prodeko\IlmoBundle\Entity\Registration $registration
     */
    public function setRegistration(\Prodeko\IlmoBundle\Entity\Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Get registration
     *
     * @return Prodeko\IlmoBundle\Entity\Registration 
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * Set field
     *
     * @param Prodeko\IlmoBundle\Entity\MultipleChoiceField $field
     */
    public function setField(\Prodeko\IlmoBundle\Entity\MultipleChoiceField $field)
    {
        $this->field = $field;
    }

    /**
     * Get field
     *
     * @return Prodeko\IlmoBundle\Entity\MultipleChoiceField 
     */
    public function getField()
    {
        return $this->field;
    }
}