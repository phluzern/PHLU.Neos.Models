<?php
namespace PHLU\Neos\Models\Domain\Model;

/*
 * This file is part of the PHLU.Neos.Models package.
 */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;


class AbstractModel
{


    /**
     * @var boolean
     */
    protected $hasChanges;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }


    /**
     * @return boolean
     */
    public function isHasChanges()
    {
        return $this->hasChanges;
    }

    /**
     * @param boolean $hasChanges
     */
    public function setHasChanges($hasChanges)
    {
        $this->hasChanges = $hasChanges;
    }


    /**
     * @return mixed
     */
    public function isPersisted() {
        return isset($this->Flow_Persistence_clone) ? true : false;
    }

    /**
     * @return mixed
     */
    public function getIdentifier() {
        return $this->Persistence_Object_Identifier;
    }

    /**
     * @return mixed
     */
    public function setIdentifier($identifier) {
        $this->Persistence_Object_Identifier = $identifier;
    }



}
