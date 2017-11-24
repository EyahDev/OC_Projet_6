<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Horse
 *
 * @ORM\Table(name="horse")
 * @ORM\Entity(repositoryClass="App\Repository\HorseRepository")
 */
class Horse
{
    /* -------------- Relations -------------- */

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="horse")
     */
    private $user;


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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="date")
     */
    private $birthDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="shoeingDate", type="date")
     */
    private $shoeingDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="vaccinationDate", type="date")
     */
    private $vaccinationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dewormingDate", type="date")
     */
    private $dewormingDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="blanketsOption", type="boolean")
     */
    private $blanketsOption;

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
     * Set name
     *
     * @param string $name
     *
     * @return Horse
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Horse
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set shoeingDate
     *
     * @param \DateTime $shoeingDate
     *
     * @return Horse
     */
    public function setShoeingDate($shoeingDate)
    {
        $this->shoeingDate = $shoeingDate;

        return $this;
    }

    /**
     * Get shoeingDate
     *
     * @return \DateTime
     */
    public function getShoeingDate()
    {
        return $this->shoeingDate;
    }

    /**
     * Set vaccinationDate
     *
     * @param \DateTime $vaccinationDate
     *
     * @return Horse
     */
    public function setVaccinationDate($vaccinationDate)
    {
        $this->vaccinationDate = $vaccinationDate;

        return $this;
    }

    /**
     * Get vaccinationDate
     *
     * @return \DateTime
     */
    public function getVaccinationDate()
    {
        return $this->vaccinationDate;
    }

    /**
     * Set dewormingDate
     *
     * @param \DateTime $dewormingDate
     *
     * @return Horse
     */
    public function setDewormingDate($dewormingDate)
    {
        $this->dewormingDate = $dewormingDate;

        return $this;
    }

    /**
     * Get dewormingDate
     *
     * @return \DateTime
     */
    public function getDewormingDate()
    {
        return $this->dewormingDate;
    }

    /**
     * Set blanketsOption
     *
     * @param boolean $blanketsOption
     *
     * @return Horse
     */
    public function setBlanketsOption($blanketsOption)
    {
        $this->blanketsOption = $blanketsOption;

        return $this;
    }

    /**
     * Get blanketsOption
     *
     * @return bool
     */
    public function getBlanketsOption()
    {
        return $this->blanketsOption;
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     *
     * @return Horse
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
}
