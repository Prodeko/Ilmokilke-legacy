<?php

namespace Prodeko\IlmoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prodeko\IlmoBundle\Entity\Ilmoittautuminen
 */
class Ilmoittautuminen
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var datetime $timestamp
     */
    private $timestamp;


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
     * Set timestamp
     *
     * @param datetime $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * Get timestamp
     *
     * @return datetime 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
    /**
     * @var Prodeko\IlmoBundle\Entity\Tapahtuma
     */
    private $tapahtuma;


    /**
     * Set tapahtuma
     *
     * @param Prodeko\IlmoBundle\Entity\Tapahtuma $tapahtuma
     */
    public function setTapahtuma(\Prodeko\IlmoBundle\Entity\Tapahtuma $tapahtuma)
    {
        $this->tapahtuma = $tapahtuma;
    }

    /**
     * Get tapahtuma
     *
     * @return Prodeko\IlmoBundle\Entity\Tapahtuma 
     */
    public function getTapahtuma()
    {
        return $this->tapahtuma;
    }
    /**
     * @var Prodeko\IlmoBundle\Entity\Kayttaja
     */
    private $kayttaja;


    /**
     * Set kayttaja
     *
     * @param Prodeko\IlmoBundle\Entity\Kayttaja $kayttaja
     */
    public function setKayttaja(\Prodeko\IlmoBundle\Entity\Kayttaja $kayttaja)
    {
        $this->kayttaja = $kayttaja;
    }

    /**
     * Get kayttaja
     *
     * @return Prodeko\IlmoBundle\Entity\Kayttaja 
     */
    public function getKayttaja()
    {
        return $this->kayttaja;
    }
}