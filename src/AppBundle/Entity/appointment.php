<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * appointment
 *
 * @ORM\Table(name="appointment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\appointmentRepository")
 */
class appointment
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
     * @var int
     *
     * @ORM\Column(name="id_citoyen", type="integer")
     * @ORM\ManyToOne(targetEntity="User/UserBundle/Entity/User", inversedBy="id")
     * @ORM\JoinColumn(name="citoyen_id", referencedColumnName="id")
     */
    private $idCitoyen;

    /**
     * @var int
     *
     * @ORM\Column(name="id_resp", type="integer")
     * @ORM\ManyToOne(targetEntity="User/UserBundle/Entity/User", inversedBy="id")
     * @ORM\JoinColumn(name="resp_id", referencedColumnName="id")
     */
    private $idResp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hour", type="time")
     */
    private $hour;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    private $RespUsername;


    public function getRespUsername(){

        return $this->RespUsername;
    }

    public function setRespUsername($RespUsername){
        $this->RespUsername = $RespUsername;

        return $this;
    }


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
     * Set idCitoyen
     *
     * @param integer $idCitoyen
     *
     * @return appointment
     */
    public function setIdCitoyen($idCitoyen)
    {
        $this->idCitoyen = $idCitoyen;

        return $this;
    }

    /**
     * Get idCitoyen
     *
     * @return int
     */
    public function getIdCitoyen()
    {
        return $this->idCitoyen;
    }

    /**
     * Set idResp
     *
     * @param integer $idResp
     *
     * @return appointment
     */
    public function setIdResp($idResp)
    {
        $this->idResp = $idResp;

        return $this;
    }

    /**
     * Get idResp
     *
     * @return int
     */
    public function getIdResp()
    {
        return $this->idResp;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return appointment
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
     * Set hour
     *
     * @param \DateTime $hour
     *
     * @return appointment
     */
    public function setHour($hour)
    {
        $this->hour = $hour;

        return $this;
    }

    /**
     * Get hour
     *
     * @return \DateTime
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return appointment
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

}

