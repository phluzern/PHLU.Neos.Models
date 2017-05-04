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
class PublicationRepository extends Repository
{


    /**
     * @param int $ppdbId
     * @return \Neos\Flow\Persistence\QueryInterface
     */
    public function getOneByPpDbId($ppdbId) {


        $query = $this->createQuery();

        return $query->matching($query->equals('id', $ppdbId))->execute()->getFirst();


    }

    /**
     * @param int $ppdbProjectId
     * @return \Neos\Flow\Persistence\QueryInterface
     */
    public function getByPpdbProjectId($ppdbProjectId) {


        $query = $this->createQuery();
        return $query->matching($query->like('projects', '%:'.$ppdbProjectId.';%'))->execute();


    }

    /**
     * @param int $ppdbPersonId
     * @return \Neos\Flow\Persistence\QueryInterface
     */
    public function getByEventoId($ppdbPersonId) {


        $query = $this->createQuery();
        return $query->matching($query->like('persons', '%:'.$ppdbPersonId.';%'))->execute();


    }

}
