<?php

namespace Phlu\Neos\Models\Aspects;


use Phlu\Evento\Service\Contact\ImportService;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Aop\JoinPointInterface;

/**
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class AutogeneratedContactsListAspect
{


    /**
     * @Flow\Inject
     * @var ImportService
     */
    protected $importService;

    /**
     * @Flow\Before("within(Neos\ContentRepository\Domain\Repository\NodeDataRepository) && method(public .+->(update|add)(object.nodeType.name == 'Phlu.Corporate:SectionAutoGeneratedContentContactsList'))")
     * @return void
     */
    public function update(JoinPointInterface $joinPoint)
    {


        $object = $joinPoint->getMethodArgument('object');
        /* @var \Neos\ContentRepository\Domain\Model\NodeData $object */
        if ($object->isRemoved() !== true && $object->isHidden() !== true && $object->getWorkspace()->getName() !== 'live') {
            $this->importService->updateAutogeneratedContactsListFromNodeData($object, true);
        }


    }



}
