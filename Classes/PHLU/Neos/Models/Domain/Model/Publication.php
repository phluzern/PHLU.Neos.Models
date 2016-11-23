<?php
namespace PHLU\Neos\Models\Domain\Model;

/*
 * This file is part of the PHLU.Ppdb package.
 */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Publication extends AbstractModel
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $citationstyle;


    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $language;


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
     * @var \DateTime
     * @ORM\Column(nullable=true)
     */
    protected $date;

    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $publicationType;


    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $persons;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCitationstyle()
    {
        return $this->citationstyle;
    }

    /**
     * @param string $citationstyle
     */
    public function setCitationstyle($citationstyle)
    {
        $this->citationstyle = $citationstyle;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
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
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return array
     */
    public function getPublicationType()
    {
        return $this->publicationType;
    }

    /**
     * @param array $publicationType
     */
    public function setPublicationType($publicationType)
    {
        $this->publicationType = $publicationType;
    }


    /**
     * @return array
     */
    public function getPersons()
    {
        return $this->persons;
    }

    /**
     * @param array $persons
     */
    public function setPersons($persons)
    {
        $this->persons = $persons;
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




}
