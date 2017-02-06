<?php
namespace PHLU\Neos\Models\Domain\Repository;

/*
 * This file is part of the PHLU.Neos.Models package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\QueryInterface;

/**
 * @Flow\Scope("singleton")
 */
class AssetCollectionRepository extends \TYPO3\Media\Domain\Repository\AssetCollectionRepository
{


    const ENTITY_CLASSNAME = 'TYPO3\Media\Domain\Model\AssetCollection';


    /**
     * Find hidden collections
     *
     * @return \Neos\Flow\Persistence\QueryResultInterface
     */
    public function getHiddenCollections()
    {
        $query = $this->createQuery();
        $query->matching($query->equals('hidden',true));


        return $query->execute();
    }


}
