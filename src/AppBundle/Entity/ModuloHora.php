<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuloHora
 *
 * @ORM\Table(name="modulo_hora")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuloHoraRepository")
 */
class ModuloHora
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
     * @ORM\Column(name="Dia", type="string", length=255)
     */
    private $dia;

    /**
     * @var int
     *
     * @ORM\Column(name="ModuloHora", type="integer")
     */
    private $moduloHora;


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
     * Set dia
     *
     * @param string $dia
     *
     * @return ModuloHora
     */
    public function setDia($dia)
    {
        $this->dia = $dia;

        return $this;
    }

    /**
     * Get dia
     *
     * @return string
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Set moduloHora
     *
     * @param integer $moduloHora
     *
     * @return ModuloHora
     */
    public function setModuloHora($moduloHora)
    {
        $this->moduloHora = $moduloHora;

        return $this;
    }

    /**
     * Get moduloHora
     *
     * @return int
     */
    public function getModuloHora()
    {
        return $this->moduloHora;
    }
}

