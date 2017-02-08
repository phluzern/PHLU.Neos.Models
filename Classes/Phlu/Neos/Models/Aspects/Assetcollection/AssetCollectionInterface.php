<?php

namespace Phlu\Neos\Models\Aspects\Assetcollection;

/*
 * This file is part of the Neos.Flow package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Phlu\Qmpilot\Domain\Model\Qmpilot;
use Neos\Flow\Annotations as Flow;

/**
 * Interface which defines the basic meta data getters and setters for Resource
 * and Storage/Object objects.
 */
interface AssetCollectionInterface
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


}
