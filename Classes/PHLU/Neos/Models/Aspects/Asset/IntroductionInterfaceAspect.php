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
use PHLU\Qmpilot\Domain\Model\Qmpilot;

/**
 * @Flow\Introduce("class(TYPO3\Media\Domain\Model\Asset)", interfaceName="PHLU\Neos\Models\Aspects\Asset\AssetInterface")
 * @Flow\Aspect
 */
class IntroductionInterfaceAspect
{


    /**
     * Around advice, implements the new method "getQmpilot" of the AssetInterface     *
     * @param  \TYPO3\Flow\AOP\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(TYPO3\Media\Domain\Model\Asset->getHidden())")
     */
    public function getHidden(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint) {

        return $joinPoint->getProxy()->hidden;
    }


    /**
     * Around advice, implements the new method "setHidden" of the
     * "AssetInterface" interface
     *
     * @param  \TYPO3\Flow\AOP\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(TYPO3\Media\Domain\Model\Asset->setHidden())")
     */
    public function setHidden(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint) {

        $joinPoint->getProxy()->hidden = $joinPoint->getMethodArgument('hidden') ? 1 : 0;

    }
    
    /**
     * Around advice, implements the new method "getQmpilot" of the AssetInterface     *
     * @param  \TYPO3\Flow\AOP\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(TYPO3\Media\Domain\Model\Asset->getKeywords())")
     */
    public function getKeywords(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint) {

        return $joinPoint->getProxy()->keywords;
    }


    /**
     * Around advice, implements the new method "setKeywords" of the
     * "AssetInterface" interface
     *
     * @param  \TYPO3\Flow\AOP\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(TYPO3\Media\Domain\Model\Asset->setKeywords())")
     */
    public function setKeywords(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint) {

        $joinPoint->getProxy()->keywords = $joinPoint->getMethodArgument('keywords') ? 1 : 0;

    }









}
