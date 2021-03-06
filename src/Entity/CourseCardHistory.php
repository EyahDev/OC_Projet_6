<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CourseCardHistory
 *
 * @ORM\Table(name="course_card_history")
 * @ORM\Entity(repositoryClass="App\Repository\CourseCardHistoryRepository")
 */
class CourseCardHistory
{
    /* -------------- Relations -------------- */

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="courseCardHistory")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CountType")
     */
    private $countType;

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
     * @ORM\Column(name="count_date", type="datetime")
     */
    private $countDate;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="remaining_course", type="string", length=255)
     */
    private $remainingCourse;

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
     * Set countDate
     *
     * @param \DateTime $countDate
     *
     * @return CourseCardHistory
     */
    public function setCountDate($countDate)
    {
        $this->countDate = $countDate;

        return $this;
    }

    /**
     * Get countDate
     *
     * @return \DateTime
     */
    public function getCountDate()
    {
        return $this->countDate;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return CourseCardHistory
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     *
     * @return CourseCardHistory
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
     * Set countType
     *
     * @param \App\Entity\CountType $countType
     *
     * @return CourseCardHistory
     */
    public function setCountType(\App\Entity\CountType $countType = null)
    {
        $this->countType = $countType;

        return $this;
    }

    /**
     * Get countType
     *
     * @return \App\Entity\CountType
     */
    public function getCountType()
    {
        return $this->countType;
    }

    /**
     * @return string
     */
    public function getRemainingCourse(): string
    {
        return $this->remainingCourse;
    }

    /**
     * @param string $remainingCourse
     */
    public function setRemainingCourse(string $remainingCourse): void
    {
        $this->remainingCourse = $remainingCourse;
    }
}
