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

use Doctrine\ORM\Mapping as ORM;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Aop\JoinPointInterface;

/**
 * @Flow\Aspect
 */
class AssetRepositoryAspect
{


    /**
     * @Flow\Around("method(Neos\Media\Domain\Repository\AssetRepository->addImageVariantFilterClause())")
     * @return void
     */
    public function addImageVariantFilterClause(JoinPointInterface $joinPoint)
    {


        $query = $joinPoint->getAdviceChain()->proceed($joinPoint);


        $constraints = $query->getConstraint();

        $query->matching(
            $query->logicalAnd(
                $query->logicalOr($query->equals('hidden',NULL),$query->equals('hidden',0)),
                $query->logicalOr($constraints)
            )
        );


        return $query;


    }


}
