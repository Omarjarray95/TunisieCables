<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cable
 *
 * @ORM\Table(name="cables")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CableRepository")
 */
class Cable
{
    public function __construct()
    {

    }

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
    protected $libelle;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\Column(type="string")
     */
    protected $couleur;

    /**
     * @ORM\Column(type="string")
     */
    protected $typeMetal;

    /**
     * @ORM\Column(type="float")
     */
    protected $poidsKgKm;

    /**
     * @ORM\Column(type="integer")
     */
    protected $quantite;

    /**
     * @ORM\OneToMany(targetEntity="CommandeCable", mappedBy="cable", cascade={"remove"})
     */
    private $cableCommande;


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
     * @return Cable
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
     * @return Cable
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
     * Set couleur
     *
     * @param string $couleur
     *
     * @return Cable
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleur
     *
     * @return string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Set typeMetal
     *
     * @param string $typeMetal
     *
     * @return Cable
     */
    public function setTypeMetal($typeMetal)
    {
        $this->typeMetal = $typeMetal;

        return $this;
    }

    /**
     * Get typeMetal
     *
     * @return string
     */
    public function getTypeMetal()
    {
        return $this->typeMetal;
    }

    /**
     * Set poidsKgKm
     *
     * @param integer $poidsKgKm
     *
     * @return Cable
     */
    public function setPoidsKgKm($poidsKgKm)
    {
        $this->poidsKgKm = $poidsKgKm;

        return $this;
    }

    /**
     * Get poidsKgKm
     *
     * @return integer
     */
    public function getPoidsKgKm()
    {
        return $this->poidsKgKm;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Cable
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Add cableCommande
     *
     * @param \AppBundle\Entity\CommandeCable $cableCommande
     *
     * @return Cable
     */
    public function addCableCommande(\AppBundle\Entity\CommandeCable $cableCommande)
    {
        $this->cableCommande[] = $cableCommande;

        return $this;
    }

    /**
     * Remove cableCommande
     *
     * @param \AppBundle\Entity\CommandeCable $cableCommande
     */
    public function removeCableCommande(\AppBundle\Entity\CommandeCable $cableCommande)
    {
        $this->cableCommande->removeElement($cableCommande);
    }

    /**
     * Get cableCommande
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCableCommande()
    {
        return $this->cableCommande;
    }
}
