<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Touret
 *
 * @ORM\Table(name="tourets")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TouretRepository")
 */
class Touret
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $libelle;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @ORM\Column(type="float")
     */
    private $diametre;

    /**
     * @ORM\Column(type="float")
     */
    private $largeur;

    /**
     * @ORM\Column(type="float")
     */
    private $longueurCable;

    /**
     * @ORM\Column(type="float")
     */
    private $longueurCableMin;

    /**
     * @ORM\Column(type="float")
     */
    private $longueurCableMax;

    /**
     * @ORM\Column(type="float")
     */
    private $poidsVide;

    /**
     * @ORM\ManyToOne(targetEntity="Cable", cascade={"merge"}, fetch="EAGER")
     * @ORM\JoinColumn(name="cable", referencedColumnName="id")
     */
    private $cable;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Touret
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Touret
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set diametre
     *
     * @param float $diametre
     *
     * @return Touret
     */
    public function setDiametre($diametre)
    {
        $this->diametre = $diametre;

        return $this;
    }

    /**
     * Get diametre
     *
     * @return float
     */
    public function getDiametre()
    {
        return $this->diametre;
    }

    /**
     * Set largeur
     *
     * @param float $largeur
     *
     * @return Touret
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;

        return $this;
    }

    /**
     * Get largeur
     *
     * @return float
     */
    public function getLargeur()
    {
        return $this->largeur;
    }

    /**
     * Set longueurCable
     *
     * @param float $longueurCable
     *
     * @return Touret
     */
    public function setLongueurCable($longueurCable)
    {
        $this->longueurCable = $longueurCable;

        return $this;
    }

    /**
     * Get longueurCable
     *
     * @return float
     */
    public function getLongueurCable()
    {
        return $this->longueurCable;
    }

    /**
     * Set longueurCableMin
     *
     * @param float $longueurCableMin
     *
     * @return Touret
     */
    public function setLongueurCableMin($longueurCableMin)
    {
        $this->longueurCableMin = $longueurCableMin;

        return $this;
    }

    /**
     * Get longueurCableMin
     *
     * @return float
     */
    public function getLongueurCableMin()
    {
        return $this->longueurCableMin;
    }

    /**
     * Set longueurCableMax
     *
     * @param float $longueurCableMax
     *
     * @return Touret
     */
    public function setLongueurCableMax($longueurCableMax)
    {
        $this->longueurCableMax = $longueurCableMax;

        return $this;
    }

    /**
     * Get longueurCableMax
     *
     * @return float
     */
    public function getLongueurCableMax()
    {
        return $this->longueurCableMax;
    }

    /**
     * Set poidsVide
     *
     * @param float $poidsVide
     *
     * @return Touret
     */
    public function setPoidsVide($poidsVide)
    {
        $this->poidsVide = $poidsVide;

        return $this;
    }

    /**
     * Get poidsVide
     *
     * @return float
     */
    public function getPoidsVide()
    {
        return $this->poidsVide;
    }

    /**
     * Set cable
     *
     * @param \AppBundle\Entity\Cable $cable
     *
     * @return Touret
     */
    public function setCable(\AppBundle\Entity\Cable $cable = null)
    {
        $this->cable = $cable;

        return $this;
    }

    /**
     * Get cable
     *
     * @return \AppBundle\Entity\Cable
     */
    public function getCable()
    {
        return $this->cable;
    }
}
