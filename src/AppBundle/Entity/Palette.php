<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Palette
 *
 * @ORM\Table(name="palettes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaletteRepository")
 */
class Palette
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
     * @ORM\Column(type="float")
     */
    private $largeur;

    /**
     * @ORM\Column(type="float")
     */
    private $longueur;

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
    private $longueurCableCouronnes;

    /**
     * @ORM\Column(type="float")
     */
    private $poidsMax;

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
     * @return Palette
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
     * Set largeur
     *
     * @param float $largeur
     *
     * @return Palette
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
     * Set longueur
     *
     * @param float $longueur
     *
     * @return Palette
     */
    public function setLongueur($longueur)
    {
        $this->longueur = $longueur;

        return $this;
    }

    /**
     * Get longueur
     *
     * @return float
     */
    public function getLongueur()
    {
        return $this->longueur;
    }

    /**
     * Set longueurCableMin
     *
     * @param float $longueurCableMin
     *
     * @return Palette
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
     * @return Palette
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
     * Set longueurCableCouronnes
     *
     * @param float $longueurCableCouronnes
     *
     * @return Palette
     */
    public function setLongueurCableCouronnes($longueurCableCouronnes)
    {
        $this->longueurCableCouronnes = $longueurCableCouronnes;

        return $this;
    }

    /**
     * Get longueurCableCouronnes
     *
     * @return float
     */
    public function getLongueurCableCouronnes()
    {
        return $this->longueurCableCouronnes;
    }

    /**
     * Set poidsMax
     *
     * @param float $poidsMax
     *
     * @return Palette
     */
    public function setPoidsMax($poidsMax)
    {
        $this->poidsMax = $poidsMax;

        return $this;
    }

    /**
     * Get poidsMax
     *
     * @return float
     */
    public function getPoidsMax()
    {
        return $this->poidsMax;
    }

    /**
     * Set poidsVide
     *
     * @param float $poidsVide
     *
     * @return Palette
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
     * @return Palette
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
