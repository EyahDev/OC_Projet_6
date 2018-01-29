<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ContactType", inversedBy="contacts")
     */
    private $type;
    
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
     * @Assert\Length(min="2", minMessage="'Le nom du contact doit contenir au minimun {{ limit }} caractères.'")
     * @Assert\NotBlank(message="Veuillez saisir un nom de contact valide.")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string")
     * @Assert\Type(type="numeric", message="Le numéro de téléphone ne peut contenir que des chiffres.")
     * @Assert\Length(max="10", maxMessage="Le numéro de téléphone doit contenir au maximun {{ limit }} chiffres.")
     * @Assert\NotBlank(message="Veuillez saisir numéro de téléphone valide")
     */
    private $phone;


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
     * @return Contact
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
     * Set phone
     *
     * @param integer $phone
     *
     * @return Contact
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
     * Set type
     *
     * @param \App\Entity\ContactType $type
     *
     * @return Contact
     */
    public function setType(ContactType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \App\Entity\ContactType
     */
    public function getType()
    {
        return $this->type;
    }
}
