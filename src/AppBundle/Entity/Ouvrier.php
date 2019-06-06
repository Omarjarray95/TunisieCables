<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ouvrier
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OuvrierRepository")
 */
class Ouvrier extends Utilisateur
{
    public function __construct()
    {
        parent::__construct();
        $this->addRole("ROLE_USER");
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $age;

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Ouvrier
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     *
     * @return Ouvrier
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }
}
