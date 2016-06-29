<?php
namespace PHLU\Neos\Models\Domain\Model;

/*
 * This file is part of the PHLU.Neos.Models package.
 */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use PHLU\Neos\Models\Domain\Repository;

/**
 * @Flow\Entity
 */
class Contact extends AbstractModel
{


    /**
     * @var \TYPO3\Party\Domain\Model\PersonName
     * @ORM\OneToOne
     * @Flow\Validate(type="NotEmpty")
     */
    protected $name;   
    

    
    /**
     * @var \TYPO3\Media\Domain\Model\Image
     * @ORM\OneToOne(cascade={"persist"})
     * @ORM\Column(nullable=true)
     */
    protected $image;



    /**
     * @var integer
     * @ORM\Column(nullable=false)
     */
    protected $eventoid;


    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $street;


    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $streetnote;


    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $streetno;


    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $zip;


    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $city;


    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $phone;


    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $email;



    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $function;

    /**
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * @param string $function
     */
    public function setFunction($function)
    {
        $this->function = $function;
    }

    

    /**
     * @return \TYPO3\Media\Domain\Model\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param \TYPO3\Media\Domain\Model\Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }



    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getStreetnote()
    {
        return $this->streetnote;
    }

    /**
     * @param string $streetnote
     */
    public function setStreetnote($streetnote)
    {
        $this->streetnote = $streetnote;
    }

    
    
    /**
     * @return string
     */
    public function getStreetno()
    {
        return $this->streetno;
    }

    /**
     * @param string $streetno
     */
    public function setStreetno($streetno)
    {
        $this->streetno = $streetno;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEventoid()
    {
        return $this->eventoid;
    }

    /**
     * @param string $eventoid
     */
    public function setEventoid($eventoid)
    {
        $this->eventoid = $eventoid;
    }


    /**
     * Sets the current name of this person
     *
     * @param \TYPO3\Party\Domain\Model\PersonName $name Name of this person
     * @return void
     */
    public function setName(\PHLU\Neos\Models\Domain\Model\PersonName $name) {
        $this->name = $name;
    }

    /**
     * Returns the current name of this person
     *
     * @return \TYPO3\Party\Domain\Model\PersonName Name of this person
     */
    public function getName() {
        return $this->name;
    }



}
