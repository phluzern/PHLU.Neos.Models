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
class Project extends AbstractModel
{




    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $projectType;


    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $pPDBStatus;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $pPDBStatusLifetime;


    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $titleGerman;


    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $titleEnglish;


    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $teaserTextGerman;


    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $teaserTextEnglish;


    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $abstractTextGerman;


    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $abstractTextEnglish;


    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $researchMainFocus;

    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $researchUnit;


    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $organisationUnits;

    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $publications;


    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $financingTypes;


    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $photos;


    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $documents;

    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $links;


    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $participants;


    /**
     * @var \DateTime
     * @ORM\Column(nullable=true)
     */
    protected $startDate;

    /**
     * @var \DateTime
     * @ORM\Column(nullable=true)
     */
    protected $endDate;

    /**
     * @var \DateTime
     * @ORM\Column(nullable=true)
     */
    protected $lastModify;

    /**
     * @return array
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param array $participants
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;
    }



    /**
     * @return string
     */
    public function getPPDBStatusLifetime()
    {
        return $this->pPDBStatusLifetime;
    }

    /**
     * @param string $pPDBStatusLifetime
     */
    public function setPPDBStatusLifetime($pPDBStatusLifetime)
    {
        $this->pPDBStatusLifetime = $pPDBStatusLifetime;
    }



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
    public function getProjectType()
    {
        return $this->projectType;
    }

    /**
     * @param string $projectType
     */
    public function setProjectType($projectType)
    {
        $this->projectType = $projectType;
    }

    /**
     * @return string
     */
    public function getPPDBStatus()
    {
        return $this->pPDBStatus;
    }

    /**
     * @param string $pPDBStatus
     */
    public function setPPDBStatus($pPDBStatus)
    {
        $this->pPDBStatus = $pPDBStatus;
    }

    /**
     * @return string
     */
    public function getTitleGerman()
    {
        return $this->titleGerman;
    }

    /**
     * @param string $titleGerman
     */
    public function setTitleGerman($titleGerman)
    {
        $this->titleGerman = $titleGerman;
    }

    /**
     * @return string
     */
    public function getTitleEnglish()
    {
        return $this->titleEnglish;
    }

    /**
     * @param string $titleEnglish
     */
    public function setTitleEnglish($titleEnglish)
    {
        $this->titleEnglish = $titleEnglish;
    }

    /**
     * @return string
     */
    public function getTeaserTextGerman()
    {
        return $this->teaserTextGerman;
    }

    /**
     * @param string $teaserTextGerman
     */
    public function setTeaserTextGerman($teaserTextGerman)
    {
        $this->teaserTextGerman = $teaserTextGerman;
    }

    /**
     * @return string
     */
    public function getTeaserTextEnglish()
    {
        return $this->teaserTextEnglish;
    }

    /**
     * @param string $teaserTextEnglish
     */
    public function setTeaserTextEnglish($teaserTextEnglish)
    {
        $this->teaserTextEnglish = $teaserTextEnglish;
    }

    /**
     * @return string
     */
    public function getAbstractTextGerman()
    {
        return $this->abstractTextGerman;
    }

    /**
     * @param string $abstractTextGerman
     */
    public function setAbstractTextGerman($abstractTextGerman)
    {
        $this->abstractTextGerman = $abstractTextGerman;
    }

    /**
     * @return string
     */
    public function getAbstractTextEnglish()
    {
        return $this->abstractTextEnglish;
    }

    /**
     * @param string $abstractTextEnglish
     */
    public function setAbstractTextEnglish($abstractTextEnglish)
    {
        $this->abstractTextEnglish = $abstractTextEnglish;
    }

    /**
     * @return array
     */
    public function getResearchMainFocus()
    {
        return $this->researchMainFocus;
    }

    /**
     * @param array $researchMainFocus
     */
    public function setResearchMainFocus($researchMainFocus)
    {
        $this->researchMainFocus = $researchMainFocus;
    }

    /**
     * @return array
     */
    public function getOrganisationUnits()
    {
        return $this->organisationUnits;
    }

    /**
     * @param array $organisationUnits
     */
    public function setOrganisationUnits($organisationUnits)
    {
        $this->organisationUnits = $organisationUnits;
    }

    /**
     * @return array
     */
    public function getFinancingTypes()
    {
        return $this->financingTypes;
    }

    /**
     * @param array $financingTypes
     */
    public function setFinancingTypes($financingTypes)
    {
        $this->financingTypes = $financingTypes;
    }

    /**
     * @return array
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param array $photos
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }

    /**
     * @return array
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param array $documents
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param array $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return \DateTime
     */
    public function getLastModify()
    {
        return $this->lastModify;
    }

    /**
     * @param \DateTime $lastModify
     */
    public function setLastModify($lastModify)
    {
        $this->lastModify = $lastModify;
    }

    /**
     * @return array
     */
    public function getResearchUnit()
    {
        return $this->researchUnit;
    }

    /**
     * @param array $researchUnit
     */
    public function setResearchUnit($researchUnit)
    {
        $this->researchUnit = $researchUnit;
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




}
