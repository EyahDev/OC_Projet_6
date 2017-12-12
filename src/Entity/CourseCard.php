<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseCard
 *
 * @ORM\Table(name="course_card")
 * @ORM\Entity(repositoryClass="App\Repository\CourseCardRepository")
 */
class CourseCard
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
     * @ORM\Column(name="validity_date", type="date")
     */
    private $validityDate;

    /**
     * @var int
     *
     * @ORM\Column(name="remaining_course", type="integer")
     */
    private $remainingCourse;

    /**
     * @var int
     *
     * @ORM\Column(name="balance", type="integer")
     */
    private $balance;

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
     * Set validityDate
     *
     * @param \DateTime $validityDate
     *
     * @return CourseCard
     */
    public function setValidityDate($validityDate)
    {
        $this->validityDate = $validityDate;

        return $this;
    }

    /**
     * Get validityDate
     *
     * @return \DateTime
     */
    public function getValidityDate()
    {
        return $this->validityDate;
    }

    /**
     * Set remainingCourse
     *
     * @param integer $remainingCourse
     *
     * @return CourseCard
     */
    public function setRemainingCourse($remainingCourse)
    {
        $this->remainingCourse = $remainingCourse;

        return $this;
    }

    /**
     * Get remainingCourse
     *
     * @return int
     */
    public function getRemainingCourse()
    {
        return $this->remainingCourse;
    }

    /**
     * Set balance
     *
     * @param integer $balance
     *
     * @return CourseCard
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return int
     */
    public function getBalance()
    {
        return $this->balance;
    }
}
