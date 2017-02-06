<?php
namespace PHLU\Neos\Models\Domain\Repository\Course;

/*
 * This file is part of the PHLU.Neos.Models package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;
use Neos\Flow\Persistence\QueryInterface;

/**
 * @Flow\Scope("singleton")
 */
abstract class AbstractCourseRepository extends Repository
{


    /**
     * @param integer $id
     * @return \Neos\Flow\Persistence\QueryInterface
     */
    public function getOneById($id) {


        $query = $this->createQuery();

        return $query->matching($query->equals('id', $id))->execute()->getFirst();


    }



}
