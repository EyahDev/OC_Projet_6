<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="horse")
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
     * @Assert\Length(min="2", minMessage="Le nom doit contenir au moins {{limit}} caractères.")
     * @Assert\NotBlank(message="Veuillez saisir un nom valide.")
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="date", nullable=true)
     * @Assert\Date(message="Veuillez saisir une date de naissance valide.")
     */
    private $birthDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="vaccinationDate", type="date", nullable=true)
     * @Assert\Date(message="Veuillez saisir une date de naissance valide.")
     */
    private $vaccinationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dewormingDate", type="date", nullable=true)
     * @Assert\Date(message="Veuillez saisir une date de naissance valide.")
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
    public function setUser(User $user = null)
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
