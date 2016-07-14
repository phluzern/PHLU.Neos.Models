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
use TYPO3\Flow\Aop\JoinPointInterface;

/**
 * @Flow\Aspect
 */
class AssetRepositoryAspect
{


    /**
     * @Flow\Before("method(TYPO3\Media\Domain\Repository\AssetRepository->addImageVariantFilterClause())")
     * @return void
     */
    public function findBySearchTermOrTags(JoinPointInterface $joinPoint)
    {

        $query = $joinPoint->getMethodArgument('query');
        $queryBuilder = $query->getQueryBuilder();
        $queryBuilder->andWhere('e.hidden IS NULL OR e.hidden = 0');

        $joinPoint->setMethodArgument('query',$query);



    }


}
