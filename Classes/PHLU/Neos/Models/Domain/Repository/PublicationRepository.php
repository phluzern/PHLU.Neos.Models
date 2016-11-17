<?php
namespace PHLU\Neos\Models\Domain\Repository;

/*
 * This file is part of the PHLU.Ppdb package.
 */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class PublicationRepository extends Repository
{


    /**
     * @param int $ppdbId
     * @return \TYPO3\Flow\Persistence\QueryInterface
     */
    public function getOneByPpDbId($ppdbId) {


        $query = $this->createQuery();

        return $query->matching($query->equals('id', $ppdbId))->execute()->getFirst();


    }

}
