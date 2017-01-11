<?php
namespace PHLU\Neos\Models\Domain\Model\Course\Study;

/*
 * This file is part of the PHLU.Neos.Models package.
 */

use PHLU\Neos\Models\Domain\Model\Course\AbstractCourse;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * Abstract study
 *
 */
abstract class AbstractStudy extends AbstractCourse
{

    /**
     * @var string
     * @ORM\Column(nullable=false)
     */

    protected $graduation;

    /**
     * @return string
     */
    public function getGraduation()
    {
        return $this->graduation;
    }

    /**
     * @param string $graduation
     */
    public function setGraduation($graduation)
    {
        $this->graduation = $graduation;
    }




}
