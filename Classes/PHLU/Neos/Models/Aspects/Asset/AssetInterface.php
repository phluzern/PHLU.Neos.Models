<?php

namespace PHLU\Neos\Models\Aspects\Asset;

/*
 * This file is part of the TYPO3.Flow package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use PHLU\Qmpilot\Domain\Model\Qmpilot;
use TYPO3\Flow\Annotations as Flow;

/**
 * Interface which defines the basic meta data getters and setters for Resource
 * and Storage/Object objects.
 */
interface AssetInterface
{
    

    /**
     * Returns the qmpilot array this storage object
     *
     * @return boolean
     */
    public function getHidden();

    /**
     * Sets the qmpilot array of this storage object
     *
     * @param boolean $hidden
     * @return void
     */
    public function setHidden($hidden);
    
    /**
     * Returns the qmpilot array this storage object
     *
     * @return boolean
     */
    public function getKeywords();

    /**
     * Sets the qmpilot array of this storage object
     *
     * @param boolean $keywords
     * @return void
     */
    public function setKeywords($keywords);


    /**
     * Returns the qmpilot array this storage object
     *
     * @return boolean
     */
    public function getSearchIndex();

    /**
     * Sets the qmpilot array of this storage object
     *
     * @param boolean $searchIndex
     * @return void
     */
    public function setSearchIndex($searchIndex);


    /**
     * Returns the qmpilot filetype shortname
     *
     * @return boolean
     */
    public function getMediaTypeShortname();

    /**
     * Returns the qmpilot file description
     *
     * @return boolean
     */
    public function getFileDescription();


}
