<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Administrateur
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdministrateurRepository")
 */
class Administrateur extends Utilisateur
{
    public function __construct()
    {
        parent::__construct();
        $this->addRole("ROLE_ADMIN");
    }
}
