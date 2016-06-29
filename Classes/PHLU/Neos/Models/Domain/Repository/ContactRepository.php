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

    /**
     * @return \TYPO3\Flow\Persistence\QueryInterface
     */
    public function findAllOrderedByName() {


        $query = $this->createQuery();

        return $query->matching($query->greaterThan('eventoid',0))->setOrderings(array('name.lastName' => QueryInterface::ORDER_DESCENDING))->execute();


    }

    

}
