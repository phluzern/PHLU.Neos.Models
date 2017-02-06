<?php
namespace PHLU\Neos\Models\Domain\Model\Course;

/*
 * This file is part of the PHLU.Neos.Models package.
 */

use PHLU\Neos\Models\Domain\Model\AbstractModel;
use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * Abstract course
 *
 */
abstract class AbstractCourse extends AbstractModel
{


    /**
     * @var boolean
     */
    protected $deleted;


    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $title;


    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $description;


    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $nr;

    /**
     * @var integer
     * @ORM\Column(nullable=true)
     */
    protected $ects;

    /**
     * @var float
     * @ORM\Column(nullable=true)
     */
    protected $fee;

    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $leaders;

    /**
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $targetgroups;

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }



    /**
     * @var integer
     * @ORM\Column(nullable=false)
     */
    protected $id;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getNr()
    {
        return $this->nr;
    }

    /**
     * @param string $nr
     */
    public function setNr($nr)
    {
        $this->nr = $nr;
    }

    /**
     * @return int
     */
    public function getEcts()
    {
        return $this->ects;
    }

    /**
     * @param int $ects
     */
    public function setEcts($ects)
    {
        $this->ects = $ects;
    }

    /**
     * @return float
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * @param float $fee
     */
    public function setFee($fee)
    {
        $this->fee = $fee;
    }

    /**
     * @return array
     */
    public function getLeaders()
    {
        return $this->leaders;
    }

    /**
     * @param array $leaders
     */
    public function setLeaders($leaders)
    {
        $this->leaders = $leaders;
    }

    /**
     * @return array
     */
    public function getTargetgroups()
    {
        return $this->targetgroups;
    }

    /**
     * @param array $targetgroups
     */
    public function setTargetgroups($targetgroups)
    {
        $this->targetgroups = $targetgroups;
    }


}
