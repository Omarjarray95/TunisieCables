<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommandeCable
 *
 * @ORM\Table(name="commandes_cables")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandeCableRepository")
 */
class CommandeCable
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
     * @ORM\ManyToOne(targetEntity="Commande", inversedBy="commandeCable")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity="Cable", inversedBy="cableCommande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cable;

    /**
     * @ORM\Column(type="float")
     */
    private $longueurCable;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cableDecoupe;

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
     * Set longueurCable
     *
     * @param float $longueurCable
     *
     * @return CommandeCable
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
     * Set cableDecoupe
     *
     * @param boolean $cableDecoupe
     *
     * @return CommandeCable
     */
    public function setCableDecoupe($cableDecoupe)
    {
        $this->cableDecoupe = $cableDecoupe;

        return $this;
    }

    /**
     * Get cableDecoupe
     *
     * @return boolean
     */
    public function getCableDecoupe()
    {
        return $this->cableDecoupe;
    }

    /**
     * Set commande
     *
     * @param \AppBundle\Entity\Commande $commande
     *
     * @return CommandeCable
     */
    public function setCommande(\AppBundle\Entity\Commande $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \AppBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * Set cable
     *
     * @param \AppBundle\Entity\Cable $cable
     *
     * @return CommandeCable
     */
    public function setCable(\AppBundle\Entity\Cable $cable)
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
