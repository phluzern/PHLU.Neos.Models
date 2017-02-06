<?php
namespace PHLU\Neos\Models;

/*
 * This file is part of the TYPO3.Flow package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */



use TYPO3\Flow\Annotations as Flow;

/**
 * Resource Repository
 *
 * Note that this repository is not part of the public API and must not be used in client code. Please use the API
 * provided by Resource Manager instead.
 *
 * @Flow\Scope("singleton")
 * @see \TYPO3\Flow\ResourceManagement\ResourceManager
 */
class AssetRepository extends \TYPO3\Media\Domain\Repository\AssetRepository
{


    /**
     * Initializes a new Repository.
     */
    public function __construct()
    {
        $this->entityClassName = 'TYPO3\Media\Domain\Model\Asset';
    }


    /**
     * @param string $sha1
     * @return AssetInterface|NULL
     */
    public function findAllByResourceSha1($sha1)
    {
        $query = $this->createQuery();
        $query->matching($query->equals('resource.sha1', $sha1, false));
        return $query->execute();
    }


}
