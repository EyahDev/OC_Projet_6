<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /* -------------- Relations -------------- */

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Horse", mappedBy="user")
     */
    private $horse;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Alert", mappedBy="user")
     * @ORM\JoinColumn(nullable=true)
     */
    private $alerts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bill", mappedBy="user")
     * @ORM\JoinColumn(nullable=true)
     */
    private $bills;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Course", mappedBy="user")
     * @ORM\JoinColumn(nullable=true)
     */
    private $courses;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CourseCard", mappedBy="user")
     * @ORM\JoinColumn(nullable=true)
     */
    private $courseCard;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CourseCardHistory", mappedBy="user")
     * @ORM\JoinColumn(nullable=true)
     */
    private $courseCardHistory;

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
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=255, nullable=true)
     */
    private $zipCode;

    /**
     * @var int
     *
     * @ORM\Column(name="phone", type="integer", nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="token_reset", type="string", length=255, nullable=true, unique=true)
     */
    private $tokenReset;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="token_expiration_date", type="datetime", nullable=true)
     */
    private $tokenExpirationDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="first_connexion", type="boolean")
     */
    private $firstConnexion;

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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
     */
    public function setcountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getcountry()
    {
        return $this->country;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return User
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }



    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set tokenReset
     *
     * @param string $tokenReset
     *
     * @return User
     */
    public function setTokenReset($tokenReset)
    {
        $this->tokenReset = $tokenReset;

        return $this;
    }

    /**
     * Get tokenReset
     *
     * @return string
     */
    public function getTokenReset()
    {
        return $this->tokenReset;
    }

    /**
     * Set tokenExpirationDate
     *
     * @param \DateTime $tokenExpirationDate
     *
     * @return User
     */
    public function setTokenExpirationDate($tokenExpirationDate)
    {
        $this->tokenExpirationDate = $tokenExpirationDate;

        return $this;
    }

    /**
     * Get tokenExpirationDate
     *
     * @return \DateTime
     */
    public function getTokenExpirationDate()
    {
        return $this->tokenExpirationDate;
    }

    /**
     * Set firstConnexion
     *
     * @param boolean $firstConnexion
     *
     * @return User
     */
    public function setFirstConnexion($firstConnexion)
    {
        $this->firstConnexion = $firstConnexion;

        return $this;
    }

    /**
     * Get firstConnexion
     *
     * @return bool
     */
    public function getFirstConnexion()
    {
        return $this->firstConnexion;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->alerts = new ArrayCollection();
        $this->bills = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->courseCardHistory = new ArrayCollection();
    }

    /**
     * Set horse
     *
     * @param \App\Entity\Horse $horse
     *
     * @return User
     */
    public function setHorse(\App\Entity\Horse $horse = null)
    {
        $this->horse = $horse;

        return $this;
    }

    /**
     * Get horse
     *
     * @return \App\Entity\Horse
     */
    public function getHorse()
    {
        return $this->horse;
    }

    /**
     * Add alert
     *
     * @param \App\Entity\Alert $alert
     *
     * @return User
     */
    public function addAlert(\App\Entity\Alert $alert)
    {
        $this->alerts[] = $alert;

        return $this;
    }

    /**
     * Remove alert
     *
     * @param \App\Entity\Alert $alert
     */
    public function removeAlert(\App\Entity\Alert $alert)
    {
        $this->alerts->removeElement($alert);
    }

    /**
     * Get alerts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlerts()
    {
        return $this->alerts;
    }

    /**
     * Add bill
     *
     * @param \App\Entity\Bill $bill
     *
     * @return User
     */
    public function addBill(\App\Entity\Bill $bill)
    {
        $this->bills[] = $bill;

        return $this;
    }

    /**
     * Remove bill
     *
     * @param \App\Entity\Bill $bill
     */
    public function removeBill(\App\Entity\Bill $bill)
    {
        $this->bills->removeElement($bill);
    }

    /**
     * Get bills
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBills()
    {
        return $this->bills;
    }

    /**
     * Add course
     *
     * @param Course $course
     *
     * @return User
     */
    public function addCourse(Course $course)
    {
        $this->courses[] = $course;

        return $this;
    }

    /**
     * Remove course
     *
     * @param Course $course
     */
    public function removeCourse(Course $course)
    {
        $this->courses->removeElement($course);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Set courseCard
     *
     * @param CourseCard $courseCard
     *
     * @return User
     */
    public function setCourseCard(CourseCard $courseCard = null)
    {
        $this->courseCard = $courseCard;

        return $this;
    }

    /**
     * Get courseCard
     *
     * @return CourseCard
     */
    public function getCourseCard()
    {
        return $this->courseCard;
    }

    /**
     * Add courseCardHistory
     *
     * @param \App\Entity\CourseCardHistory $courseCardHistory
     *
     * @return User
     */
    public function addCourseCardHistory(\App\Entity\CourseCardHistory $courseCardHistory)
    {
        $this->courseCardHistory[] = $courseCardHistory;

        return $this;
    }

    /**
     * Remove courseCardHistory
     *
     * @param \App\Entity\CourseCardHistory $courseCardHistory
     */
    public function removeCourseCardHistory(\App\Entity\CourseCardHistory $courseCardHistory)
    {
        $this->courseCardHistory->removeElement($courseCardHistory);
    }

    /**
     * Get courseCardHistory
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourseCardHistory()
    {
        return $this->courseCardHistory;
    }

    /* -------------- Implements declarations -------------- */

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
        ) = unserialize($serialized);
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        return null;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
}
