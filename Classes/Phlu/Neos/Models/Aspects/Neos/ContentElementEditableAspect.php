<?php

namespace Phlu\Neos\Models\Aspects\Neos;


use Neos\Flow\Annotations as Flow;
use Neos\Flow\Aop\JoinPointInterface;
use Neos\Neos\Service\HtmlAugmenter;

/**
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class ContentElementEditableAspect
{

    /**
     * @Flow\Inject
     * @var HtmlAugmenter
     */
    protected $htmlAugmenter;

    /**
     * @Flow\Around("method(Neos\Neos\Service\ContentElementEditableService->wrapContentProperty())")
     * @return void
     */
    public function wrapContentProperty(JoinPointInterface $joinPoint)
    {


        if ($joinPoint->getMethodArgument('node')->getProperty('internalid') > 0) {

            $attributes = array();
            $attributes['class'] = 'disabled-for-editing';

            return $this->htmlAugmenter->addAttributes($joinPoint->getMethodArgument('content'), $attributes, 'span');

        } else {
            return $joinPoint->getAdviceChain()->proceed($joinPoint);
        }



    }



}
