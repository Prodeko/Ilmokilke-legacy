<?php

namespace Prodeko\IlmoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prodeko\IlmoBundle\Entity\FreeTextField
 */
class FreeTextField
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
     * @var string $name
     */
    private $name;

    /**
     * @var text $description
     */
    private $description;


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
     * @var Prodeko\IlmoBundle\Entity\FreeTextEntry
     */
    private $entries;

    public function __construct()
    {
        $this->entries = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add entries
     *
     * @param Prodeko\IlmoBundle\Entity\FreeTextEntry $entries
     */
    public function addFreeTextEntry(\Prodeko\IlmoBundle\Entity\FreeTextEntry $entries)
    {
        $this->entries[] = $entries;
    }

    /**
     * Get entries
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @var boolean $flagPrivate
     */
    private $flagPrivate = true;


    /**
     * Set flagPrivate
     *
     * @param boolean $flagPrivate
     */
    public function setFlagPrivate($flagPrivate)
    {
        $this->flagPrivate = $flagPrivate;
    }

    /**
     * Get flagPrivate
     *
     * @return boolean 
     */
    public function getFlagPrivate()
    {
        return $this->flagPrivate;
    }
}