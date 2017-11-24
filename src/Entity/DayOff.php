<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DayOff
 *
 * @ORM\Table(name="day_off")
 * @ORM\Entity(repositoryClass="App\Repository\DayOffRepository")
 */
class DayOff
{
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
     * @ORM\Column(name="date_off_begin", type="datetime")
     */
    private $dateOffBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_off_end", type="datetime")
     */
    private $dateOffEnd;

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
     * Set dateOffBegin
     *
     * @param \DateTime $dateOffBegin
     *
     * @return DayOff
     */
    public function setDateOffBegin($dateOffBegin)
    {
        $this->dateOffBegin = $dateOffBegin;

        return $this;
    }

    /**
     * Get dateOffBegin
     *
     * @return \DateTime
     */
    public function getDateOffBegin()
    {
        return $this->dateOffBegin;
    }

    /**
     * Set dateOffEnd
     *
     * @param \DateTime $dateOffEnd
     *
     * @return DayOff
     */
    public function setDateOffEnd($dateOffEnd)
    {
        $this->dateOffEnd = $dateOffEnd;

        return $this;
    }

    /**
     * Get dateOffEnd
     *
     * @return \DateTime
     */
    public function getDateOffEnd()
    {
        return $this->dateOffEnd;
    }
}
