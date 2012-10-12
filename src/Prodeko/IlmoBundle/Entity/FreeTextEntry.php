<?php

namespace Prodeko\IlmoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prodeko\IlmoBundle\Entity\FreeTextEntry
 */
class FreeTextEntry
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var text $content
     */
    private $content;

    /**
     * @var Prodeko\IlmoBundle\Entity\FreeTextField
     */
    private $field;
	
    /**
     * @var Prodeko\IlmoBundle\Entity\Registration
     */
    private $registration;

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
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent()
    {
        return stripslashes($this->content);
    }

    /**
     * Set field
     *
     * @param Prodeko\IlmoBundle\Entity\FreeTextField $field
     */
    public function setField(\Prodeko\IlmoBundle\Entity\FreeTextField $field)
    {
        $this->field = $field;
    }

    /**
     * Get field
     *
     * @return Prodeko\IlmoBundle\Entity\FreeTextField 
     */
    public function getField()
    {
        return $this->field;
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
}