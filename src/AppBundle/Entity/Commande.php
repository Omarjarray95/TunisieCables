<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commandes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandeRepository")
 */
class Commande
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
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Client", cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="client", referencedColumnName="id")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="Destination", cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="destination", referencedColumnName="id")
     */
    private $destination;

    /**
     * @ORM\ManyToOne(targetEntity="Ouvrier", cascade={"merge"}, fetch="EAGER")
     * @ORM\JoinColumn(name="ouvrier", referencedColumnName="id")
     */
    private $ouvrier;

    /**
     * @ORM\ManyToOne(targetEntity="Transport", cascade={"persist", "merge", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="transport", referencedColumnName="id")
     */
    private $transport;

    /**
     * @ORM\OneToMany(targetEntity="CommandeCable", mappedBy="commande", fetch="EXTRA_LAZY")
     */
    private $commandeCable;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commande
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return Commande
     */
    public function setClient(\AppBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \AppBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set destination
     *
     * @param \AppBundle\Entity\Destination $destination
     *
     * @return Commande
     */
    public function setDestination(\AppBundle\Entity\Destination $destination = null)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return \AppBundle\Entity\Destination
     */
    public function getDestination()
    {
        return $this->destination;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commandeCable = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set transport
     *
     * @param \AppBundle\Entity\Transport $transport
     *
     * @return Commande
     */
    public function setTransport(\AppBundle\Entity\Transport $transport = null)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * Get transport
     *
     * @return \AppBundle\Entity\Transport
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * Add commandeCable
     *
     * @param \AppBundle\Entity\CommandeCable $commandeCable
     *
     * @return Commande
     */
    public function addCommandeCable(\AppBundle\Entity\CommandeCable $commandeCable)
    {
        $this->commandeCable[] = $commandeCable;

        return $this;
    }

    /**
     * Remove commandeCable
     *
     * @param \AppBundle\Entity\CommandeCable $commandeCable
     */
    public function removeCommandeCable(\AppBundle\Entity\CommandeCable $commandeCable)
    {
        $this->commandeCable->removeElement($commandeCable);
    }

    /**
     * Get commandeCable
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandeCable()
    {
        return $this->commandeCable;
    }

    /**
     * Set ouvrier
     *
     * @param \AppBundle\Entity\Ouvrier $ouvrier
     *
     * @return Commande
     */
    public function setOuvrier(\AppBundle\Entity\Ouvrier $ouvrier = null)
    {
        $this->ouvrier = $ouvrier;

        return $this;
    }

    /**
     * Get ouvrier
     *
     * @return \AppBundle\Entity\Ouvrier
     */
    public function getOuvrier()
    {
        return $this->ouvrier;
    }
}
