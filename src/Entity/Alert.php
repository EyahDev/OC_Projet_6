<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alert
 *
 * @ORM\Table(name="alert")
 * @ORM\Entity(repositoryClass="App\Repository\AlertRepository")
 */
class Alert
{
    /* -------------- Relations -------------- */

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="alerts")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\AlertType")
     */
    private $type;

    /* -------------- Fields -------------- */

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="alert_date", type="date")
     */
    private $alertDate;

    /**
     * @var string
     *
     * @ORM\Column(name="alert_description", type="string", length=255)
     */
    private $alertDescription;

    /* -------------- Setters and Getters -------------- */

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
     * Set alertDate
     *
     * @param \DateTime $alertDate
     *
     * @return Alert
     */
    public function setAlertDate($alertDate)
    {
        $this->alertDate = $alertDate;

        return $this;
    }

    /**
     * Get alertDate
     *
     * @return \DateTime
     */
    public function getAlertDate()
    {
        return $this->alertDate;
    }

    /**
     * Set alertDescription
     *
     * @param string $alertDescription
     *
     * @return Alert
     */
    public function setAlertDescription($alertDescription)
    {
        $this->alertDescription = $alertDescription;

        return $this;
    }

    /**
     * Get alertDescription
     *
     * @return string
     */
    public function getAlertDescription()
    {
        return $this->alertDescription;
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     *
     * @return Alert
     */
    public function setUser(\App\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set type
     *
     * @param \App\Entity\AlertType $type
     *
     * @return Alert
     */
    public function setType(\App\Entity\AlertType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \App\Entity\AlertType
     */
    public function getType()
    {
        return $this->type;
    }
}
