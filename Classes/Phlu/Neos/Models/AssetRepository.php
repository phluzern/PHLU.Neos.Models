<?php
namespace Phlu\Neos\Models;

/*
 * This file is part of the Neos.Flow package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */



use Neos\Flow\Annotations as Flow;

/**
 * Resource Repository
 *
 * Note that this repository is not part of the public API and must not be used in client code. Please use the API
 * provided by Resource Manager instead.
 *
 * @Flow\Scope("singleton")
 * @see \Neos\Flow\ResourceManagement\ResourceManager
 */
class AssetRepository extends \Neos\Media\Domain\Repository\AssetRepository
{


    /**
     * Initializes a new Repository.
     */
    public function __construct()
    {
        $this->entityClassName = 'Neos\Media\Domain\Model\Asset';
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


    /**
     * Find assets by search index
     * @Flow\Around("method(Neos\Media\Domain\Repository\AssetRepository->findBySearchIndex())")
     * @param string $searchTerm
     * @return \Neos\Flow\Persistence\QueryResultInterface
     */
    public function findBySearchIndex($searchTerm)
    {
        $query = $this->createQuery();

        $constraints = array(
            $query->like('searchIndex', '%' . $searchTerm . '%')
        );


        $query->matching($query->logicalOr($constraints));

        return $query->execute();
    }



}
