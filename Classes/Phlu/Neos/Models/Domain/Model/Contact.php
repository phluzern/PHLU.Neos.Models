<?php
namespace Phlu\Neos\Models\Domain\Model;

/*
 * This file is part of the Phlu.Neos.Models package.
 */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;


/**
 * @Flow\Entity
 */
class Contact extends AbstractModel
{


    /**
     * @var \Neos\Party\Domain\Model\PersonName
     * @ORM\OneToOne
     * @Flow\Validate(type="NotEmpty")
     */
    protected $name;   
    

    
    /**
     * @var \Neos\Media\Domain\Model\Image
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
    protected $linkssocial;


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
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $organisations;

    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $achievements;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $cv;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $shorthandSymbol;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $officeid;


    /**
     * @var boolean
     */
    protected $showPortrait;

    /**
     * @return string
     */
    public function getOfficeid()
    {
        return $this->officeid;
    }

    /**
     * @param string $officeid
     */
    public function setOfficeid($officeid)
    {
        $this->officeid = $officeid;
    }



    /**
     * @return string
     */
    public function getShorthandSymbol()
    {
        return $this->shorthandSymbol;
    }

    /**
     * @param string $shorthandSymbol
     */
    public function setShorthandSymbol($shorthandSymbol)
    {
        $this->shorthandSymbol = $shorthandSymbol;
    }



    /**
     * @return String
     */
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * @param String $cv
     */
    public function setCv($cv)
    {
        $this->cv = $cv;
    }


    /**
     * @var boolean
     */
    protected $showPortraitImage;

    /**
     * @return boolean
     */
    public function isShowPortrait()
    {
        return $this->showPortrait;
    }

    /**
     * @param boolean $showPortrait
     */
    public function setShowPortrait($showPortrait)
    {
        $this->showPortrait = $showPortrait;
    }

    /**
     * @return boolean
     */
    public function isShowPortraitImage()
    {
        return $this->showPortraitImage;
    }

    /**
     * @param boolean $showPortraitImage
     */
    public function setShowPortraitImage($showPortraitImage)
    {
        $this->showPortraitImage = $showPortraitImage;
    }



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
     * @return \Neos\Media\Domain\Model\Image
     */
    public function getImage()
    {
        return $this->isShowPortraitImage() ? $this->image : null;
    }



    /**
     * @param \Neos\Media\Domain\Model\Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Clear image
     */
    public function clearImage()
    {
        $this->image = null;
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
     * @param \Neos\Party\Domain\Model\PersonName $name Name of this person
     * @return void
     */
    public function setName(\Phlu\Neos\Models\Domain\Model\PersonName $name) {
        $this->name = $name;
    }

    /**
     * Returns the current name of this person
     *
     * @return \Neos\Party\Domain\Model\PersonName Name of this person
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getOrganisations()
    {
        return $this->organisations;
    }

    /**
     * @param array $organisations
     */
    public function setOrganisations($organisations)
    {
        $this->organisations = $organisations;
    }

    /**
     * @return array
     */
    public function getAchievements()
    {
        return $this->achievements;
    }

    /**
     * @param array $achievements
     */
    public function setAchievements($achievements)
    {
        $this->achievements = $achievements;
    }

    /**
     * @return string
     */
    public function getLinkssocial()
    {
        return $this->linkssocial;
    }

    /**
     * @param string $linkssocial
     */
    public function setLinkssocial($linkssocial)
    {
        $this->linkssocial = $linkssocial;
    }




}
