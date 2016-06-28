<?php
namespace PHLU\Neos\Models\Domain\Repository;

/*
 * This file is part of the PHLU.Neos.Models package.
 */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class ContactRepository extends Repository
{


    /**
     * @param $eventoId
     * @return \TYPO3\Flow\Persistence\QueryInterface
     */
    public function getOneByEventoId($eventoId) {


        $query = $this->createQuery();

        return $query->matching($query->equals('eventoid', $eventoId))->execute()->getFirst();


    }

    

}
