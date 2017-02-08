<?php
namespace Phlu\Neos\Models\Aspects\AssetCollection;

/*
 * This file is part of the Neos.Neos package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Phlu\Qmpilot\Domain\Model\Qmpilot;

/**
 * @Flow\Introduce("class(Neos\Media\Domain\Model\AssetCollection)", interfaceName="Phlu\Neos\Models\Aspects\AssetCollection\AssetCollectionInterface")
 * @Flow\Aspect
 */
class IntroductionInterfaceAspect
{


    /**
     * Around advice, implements the new method "getQmpilot" of the AssetCollectionInterface     *
     * @param  \Neos\Flow\Aop\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(Neos\Media\Domain\Model\AssetCollection->getHidden())")
     */
    public function getHidden(\Neos\Flow\Aop\JoinPointInterface $joinPoint) {

        return $joinPoint->getProxy()->hidden;
    }


    /**
     * Around advice, implements the new method "setHidden" of the
     * "AssetCollectionInterface" interface
     *
     * @param  \Neos\Flow\Aop\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(Neos\Media\Domain\Model\AssetCollection->setHidden())")
     */
    public function setHidden(\Neos\Flow\Aop\JoinPointInterface $joinPoint) {

        $joinPoint->getProxy()->hidden = $joinPoint->getMethodArgument('hidden') ? 1 : 0;

    }









}
