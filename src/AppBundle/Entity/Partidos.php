<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partidos
 *
 * @ORM\Table(name="partidos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartidosRepository")
 */
class Partidos
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
     * @var string
     *
     * @ORM\Column(name="Equipo1", type="string", length=100)
     */
    private $equipo1;

    /**
     * @var string
     *
     * @ORM\Column(name="Equipo2", type="string", length=100)
     */
    private $equipo2;

    /**
     * @var string
     *
     * @ORM\Column(name="Cancha", type="string", length=50)
     */
    private $cancha;
    /*
    * @var int
    *
    * @ORM\Column(name="ModuloHora", type="integer")
     */
    private $mh;

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
     * Set equipo1
     *
     * @param string $equipo1
     *
     * @return Partidos
     */
    public function setEquipo1($equipo1)
    {
        $this->equipo1 = $equipo1;

        return $this;
    }

    /**
     * Get equipo1
     *
     * @return string
     */
    public function getEquipo1()
    {
        return $this->equipo1;
    }

    /**
     * Set equipo2
     *
     * @param string $equipo2
     *
     * @return Partidos
     */
    public function setEquipo2($equipo2)
    {
        $this->equipo2 = $equipo2;

        return $this;
    }

    /**
     * Get equipo2
     *
     * @return string
     */
    public function getEquipo2()
    {
        return $this->equipo2;
    }

    /**
     * Set cancha
     *
     * @param string $cancha
     *
     * @return Partidos
     */
    public function setCancha($cancha)
    {
        $this->cancha = $cancha;

        return $this;
    }

    /**
     * Get cancha
     *
     * @return string
     */
    public function getCancha()
    {
        return $this->cancha;
    }

    /**
     * Get modulohora
     *
     * @return int
     */
    public function getModuloHora()
    {
        return $this->moduloHora;
    }

    public function toString()
    {
        return $this->cancha;
    }
}
