<?php
namespace Phlu\Neos\Models\Domain\Model\Course\Study;

/*
 * This file is part of the Phlu.Neos.Models package.
 */

use Phlu\Neos\Models\Domain\Model\Course\AbstractCourse;
use Neos\Flow\Annotations as Flow;
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
     * @var array
     * @ORM\Column(nullable=true)
     */
    protected $targetgroupsModules;

    /**
     * @return array
     */
    public function getTargetgroupsModules()
    {
        return $this->targetgroupsModules;
    }

    /**
     * @param array $targetgroupsModules
     */
    public function setTargetgroupsModules($targetgroupsModules)
    {
        $this->targetgroupsModules = $targetgroupsModules;
    }



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
