<?php
namespace PHLU\Neos\Models\Aspects\AssetCollection;

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
use PHLU\Qmpilot\Domain\Model\Qmpilot;

/**
 * @Flow\Introduce("class(TYPO3\Media\Domain\Model\AssetCollection)", interfaceName="PHLU\Neos\Models\Aspects\AssetCollection\AssetCollectionInterface")
 * @Flow\Aspect
 */
class IntroductionInterfaceAspect
{


    /**
     * Around advice, implements the new method "getQmpilot" of the AssetCollectionInterface     *
     * @param  \TYPO3\Flow\Aop\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(TYPO3\Media\Domain\Model\AssetCollection->getHidden())")
     */
    public function getHidden(\TYPO3\Flow\Aop\JoinPointInterface $joinPoint) {

        return $joinPoint->getProxy()->hidden;
    }


    /**
     * Around advice, implements the new method "setHidden" of the
     * "AssetCollectionInterface" interface
     *
     * @param  \TYPO3\Flow\Aop\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(TYPO3\Media\Domain\Model\AssetCollection->setHidden())")
     */
    public function setHidden(\TYPO3\Flow\Aop\JoinPointInterface $joinPoint) {

        $joinPoint->getProxy()->hidden = $joinPoint->getMethodArgument('hidden') ? 1 : 0;

    }









}
