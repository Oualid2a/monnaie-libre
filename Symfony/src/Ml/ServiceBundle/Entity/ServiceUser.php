<?php

namespace Ml\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceUser
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ml\ServiceBundle\Entity\ServiceUserRepository")
 */
class ServiceUser
{
    /**
	  * @ORM\Id
	  * @ORM\ManyToOne(targetEntity="Ml\ServiceBundle\Entity\Service")
	  */
	private $service;

	/**
	  * @ORM\Id
	  * @ORM\ManyToOne(targetEntity="Ml\UserBundle\Entity\User")
	  */
	private $applicant;
	
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="dateReservation", type="datetime")
     */
    private $dateReservation;
	
	public function __construct() {
		$this->dateReservation = date_create(date('Y-m-d'));
	}
	
	// Getter et setter pour l'entité Service
	  public function setService(\Ml\ServiceBundle\Entity\Service $service) {
		$this->service = $service;
	  }
	  public function getService() {
		return $this->service;
	  }

    // Getter et setter pour l'entité User
	  public function setApplicant(\Ml\UserBundle\Entity\User $applicant) {
		$this->applicant = $applicant;
	  }
	  public function getApplicant() {
		return $this->applicant;
	  }

    /**
     * Set dateReservation
     *
     * @param \DateTime $dateReservation
     * @return DonnerAvis
     */
    public function setDateReservation($dateReservation)
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    /**
     * Get dateReservation
     *
     * @return \DateTime 
     */
    public function getDateReservation()
    {
        return $this->dateReservation;
    }
}
