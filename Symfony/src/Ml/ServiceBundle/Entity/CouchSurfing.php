<?php

namespace Ml\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CouchSurfing
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ml\ServiceBundle\Entity\CouchSurfingRepository")
 */
class CouchSurfing extends Service
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    protected $location;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    protected $dateReservation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="time")
     */
    protected $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="time")
     */
    protected $end;

    /**
     * @var boolean
     *
     * @ORM\Column(name="limitGuest", type="boolean")
     */
    protected $limitGuest;

    /**
     * @var integer
     *
     * @ORM\Column(name="limitNumberOfGuest", type="integer")
     */
    protected $limitNumberOfGuest;


    public function __construct() {
        parent::__construct();
        $this->type = "CouchSurfing";
        $this->dateReservation = date_create(date('Y-m-d'));
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return CouchSurfing
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return CouchSurfing
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
     * Set start
     *
     * @param \DateTime $start
     * @return CouchSurfing
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return CouchSurfing
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set limitGuest
     *
     * @param boolean $limitGuest
     * @return CouchSurfing
     */
    public function setLimitGuest($limitGuest)
    {
        $this->limitGuest = $limitGuest;

        return $this;
    }

    /**
     * Get limitGuest
     *
     * @return boolean 
     */
    public function getLimitGuest()
    {
        return $this->limitGuest;
    }

    /**
     * Set limitNumberOfGuest
     *
     * @param integer $limitNumberOfGuest
     * @return CouchSurfing
     */
    public function setLimitNumberOfGuest($limitNumberOfGuest)
    {
        $this->limitNumberOfGuest = $limitNumberOfGuest;

        return $this;
    }

    /**
     * Get limitNumberOfGuest
     *
     * @return integer 
     */
    public function getLimitNumberOfGuest()
    {
        return $this->limitNumberOfGuest;
    }
}
