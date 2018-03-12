<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table(name="course")
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 */
class Course
{
    /* -------------- Relations -------------- */

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="courses")
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CourseStatus")
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CourseType")
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
     * @ORM\Column(name="course_date", type="datetime")
     */
    private $courseDate;

    /* -------------- Setters and Getters -------------- */

    /**
     * Course constructor.
     */
    public function __construct() {
        $this->users = new ArrayCollection();
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
     * Set courseDate
     *
     * @param \DateTime $courseDate
     *
     * @return Course
     */
    public function setCourseDate($courseDate)
    {
        $this->courseDate = $courseDate;

        return $this;
    }

    /**
     * Get courseDate
     *
     * @return \DateTime
     */
    public function getCourseDate()
    {
        return $this->courseDate;
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     *
     * @return Course
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
     * Set status
     *
     * @param \App\Entity\CourseStatus $status
     *
     * @return Course
     */
    public function setStatus(\App\Entity\CourseStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \App\Entity\CourseStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set type
     *
     * @param \App\Entity\CourseType $type
     *
     * @return Course
     */
    public function setType(\App\Entity\CourseType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \App\Entity\CourseType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }
}
