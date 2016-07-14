<?php
namespace PHLU\Neos\Models\Aspects\Asset;

/*
 * This file is part of the TYPO3.Neos package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Aspect
 */
class IntroductionPropertyAspect
{

    /**
     * @var boolean
     * @Flow\Introduce("class(TYPO3\Media\Domain\Model\Asset)")
     */
    public $hidden;


}
