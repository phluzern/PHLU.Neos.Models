<?php
namespace PHLU\Neos\Models\Controller;

/*
 * This file is part of the PHLU.Neos.Models package.
 */

use Neos\Flow\Annotations as Flow;

class StandardController extends \Neos\Flow\Mvc\Controller\ActionController
{

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('foos', array(
            'bar', 'baz'
        ));
    }

}
