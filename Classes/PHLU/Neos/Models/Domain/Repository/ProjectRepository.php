<?php
namespace PHLU\Neos\Models\Domain\Repository;

/*
 * This file is part of the PHLU.Ppdb package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class ProjectRepository extends Repository
{


    /**
     * @param int $ppdbId
     * @return \Neos\Flow\Persistence\QueryInterface
     */
    public function getOneByPpDbId($ppdbId) {


        $query = $this->createQuery();

        return $query->matching($query->equals('id', $ppdbId))->execute()->getFirst();


    }

}
