<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bill
 *
 * @ORM\Table(name="bill")
 * @ORM\Entity(repositoryClass="App\Repository\BillRepository")
 */
class Bill
{
    /* -------------- Relations -------------- */

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bills")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\BillType")
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\BillStatus")
     */
    private $status;

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
     * @ORM\Column(name="bill_date", type="date")
     */
    private $billDate;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="pdf_path", type="string", length=255, nullable=true)
     */
    private $pdfPath;

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
     * Set billDate
     *
     * @param \DateTime $billDate
     *
     * @return Bill
     */
    public function setBillDate($billDate)
    {
        $this->billDate = $billDate;

        return $this;
    }

    /**
     * Get billDate
     *
     * @return \DateTime
     */
    public function getBillDate()
    {
        return $this->billDate;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Bill
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set pdfPath
     *
     * @param string $pdfPath
     *
     * @return Bill
     */
    public function setPdfPath($pdfPath)
    {
        $this->pdfPath = $pdfPath;

        return $this;
    }

    /**
     * Get pdfPath
     *
     * @return string
     */
    public function getPdfPath()
    {
        return $this->pdfPath;
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     *
     * @return Bill
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
     * @param \App\Entity\BillType $type
     *
     * @return Bill
     */
    public function setType(\App\Entity\BillType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \App\Entity\BillType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status
     *
     * @param \App\Entity\BillStatus $status
     *
     * @return Bill
     */
    public function setStatus(\App\Entity\BillStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \App\Entity\BillStatus
     */
    public function getStatus()
    {
        return $this->status;
    }
}
