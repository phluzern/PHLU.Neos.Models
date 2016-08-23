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
     * @ORM\Column(nullable=true,type="text")
     */
    protected $function;


    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $links;


    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $education;



    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $honorific;



    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $activities;


    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $expertise;

    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $functions;

    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $consulting;

    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $publications;

    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $projects;

    /**
     * @return array
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @param array $projects
     */
    public function setProjects($projects)
    {
        $this->projects = $projects;
    }




    /**
     * @return array
     */
    public function getPublications()
    {
        return $this->publications;
    }

    /**
     * @param array $publications
     */
    public function setPublications($publications)
    {
        $this->publications = $publications;
    }




    /**
     * @return string
     */
    public function getConsulting()
    {
        return $this->consulting;
    }

    /**
     * @param string $consulting
     */
    public function setConsulting($consulting)
    {
        $this->consulting = $consulting;
    }



    /**
     * @return string
     */
    public function getFunctions()
    {
        return $this->functions;
    }

    /**
     * @param string $functions
     */
    public function setFunctions($functions)
    {
        $this->functions = $functions;
    }



    /**
     * @return string
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param string $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    /**
     * @return string
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * @param string $education
     */
    public function setEducation($education)
    {
        $this->education = $education;
    }

    /**
     * @return string
     */
    public function getHonorific()
    {
        return $this->honorific;
    }

    /**
     * @param string $honorific
     */
    public function setHonorific($honorific)
    {
        $this->honorific = $honorific;
    }

    /**
     * @return string
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * @param string $activities
     */
    public function setActivities($activities)
    {
        $this->activities = $activities;
    }

    /**
     * @return string
     */
    public function getExpertise()
    {
        return $this->expertise;
    }

    /**
     * @param string $expertise
     */
    public function setExpertise($expertise)
    {
        $this->expertise = $expertise;
    }




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
     * @return string
     */
    public function getEmailPart()
    {

        return substr($this->email,0,strpos($this->email,"@"));
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
