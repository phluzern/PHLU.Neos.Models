<?php

namespace Phlu\Neos\Models\Domain\Repository;

/*
 * This file is part of the Phlu.Ppdb package.
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
    public function getOneByPpDbId($ppdbId)
    {

        $query = $this->createQuery();
        return $query->matching($query->equals('id', $ppdbId))->execute()->getFirst();

    }

    /**
     * @param int $ppdbPersonId
     * @return \Neos\Flow\Persistence\QueryInterface
     */
    public function getByEventoId($ppdbPersonId)
    {



        $query = $this->createQuery();

        return $query->matching(
            $query->logicalAnd(
                $query->like('participants', '%:' . $ppdbPersonId . ';%'),
                $query->like('participantsintern', '%:' . $ppdbPersonId . ';%')
            )
        )->execute();


    }

}
