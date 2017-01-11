<?php
namespace PHLU\Neos\Models\Domain\Repository;

/*
 * This file is part of the PHLU.Neos.Models package.
 */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;
use TYPO3\Flow\Persistence\QueryInterface;

/**
 * @Flow\Scope("singleton")
 */
abstract class AbstractCourseRepository extends Repository
{


    /**
     * @param integer $id
     * @return \TYPO3\Flow\Persistence\QueryInterface
     */
    public function getOneById($id) {


        $query = $this->createQuery();

        return $query->matching($query->equals('id', $id))->execute()->getFirst();


    }



}
