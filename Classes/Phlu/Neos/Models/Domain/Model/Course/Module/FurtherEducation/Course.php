<?php
namespace Phlu\Neos\Models\Domain\Model\Course\Module\FurtherEducation;

/*
 * This file is part of the Phlu.Neos.Models package.
 */

use Phlu\Neos\Models\Domain\Model\Course\Module\AbstractModule;
use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Course extends AbstractModule
{


    /**
     * @var string
     * @ORM\Column(nullable=true,type="text")
     */
    protected $region;

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }




}
