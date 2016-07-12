<?php
namespace PHLU\Neos\Models\Aspects\AssetCollection;

/*
 * This file is part of the TYPO3.Media package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */


use PHLU\Neos\Models\Domain\Repository\AssetCollectionRepository;
use TYPO3\Flow\Annotations as Flow;

/**
 * An Asset, the base for all more specific assets in this package.
 *
 * It can be used as is to represent any asset for which no better match is available.
 *
 * @Flow\Aspect
 */
class AssetRepositoryAspect
{


    /**
     * @Flow\Inject
     * @var AssetCollectionRepository
     */
    protected $assetCollectionRepository;


    /**
     * Log a message if a post is deleted
     *
     * @param \TYPO3\Flow\AOP\JoinPointInterface $joinPoint
     * @Flow\Before("method(TYPO3\Media\Domain\Repository\AssetRepository->addAssetCollectionToQueryConstraints())")
     * @return void
     */
    public function addAssetCollectionToQueryConstraints(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint)
    {


        $query = $joinPoint->getMethodArgument('query');
        $query->matching(

            $query->logicalOr(array(
                    $query->logicalNot($query->equals("assetCollections.hidden", 1)),
                    $query->logicalAnd($query->equals("assetCollections.hidden", NULL)),
                    )
            ));

    }


    /**
     * Log a message if a post is deleted
     *
     * @param \TYPO3\Flow\AOP\JoinPointInterface $joinPoint
     * @Flow\Around("method(TYPO3\Media\Domain\Repository\AssetCollectionRepository->findAll())")
     * @return void
     */
    public function findAll(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint)
    {

        $self = $joinPoint->getProxy();

        $query = $self->createQuery();
        $query->matching($query->logicalNot($query->equals('hidden', 1)));

        return $query->execute();


    }


}