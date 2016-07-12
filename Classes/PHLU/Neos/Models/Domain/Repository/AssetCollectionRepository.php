<?php
namespace PHLU\Neos\Models\Domain\Repository;

/*
 * This file is part of the PHLU.Neos.Models package.
 */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\QueryInterface;

/**
 * @Flow\Scope("singleton")
 */
class AssetCollectionRepository extends \TYPO3\Media\Domain\Repository\AssetCollectionRepository
{


    const ENTITY_CLASSNAME = 'TYPO3\Media\Domain\Model\AssetCollection';


    /**
     * Find hidden collections
     *
     * @return \TYPO3\Flow\Persistence\QueryResultInterface
     */
    public function getHiddenCollections()
    {
        $query = $this->createQuery();
        $query->matching($query->equals('hidden',true));


        return $query->execute();
    }


}
