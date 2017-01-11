<?php

namespace PHLU\Neos\Models\Aspects;


use PHLU\Neos\Models\Domain\Repository\CourseRepository;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Doctrine\PersistenceManager;
use TYPO3\TYPO3CR\Domain\Model\NodeData;
use TYPO3\TYPO3CR\Domain\Repository\NodeDataRepository;
use TYPO3\TYPO3CR\Domain\Service\NodeTypeManager;

/**
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class CourseAspect
{


    /**
     * @Flow\Inject
     * @var \TYPO3\TYPO3CR\Domain\Repository\WorkspaceRepository
     */
    protected $workspaceRepository;


    /**
     * @Flow\Inject
     * @var PersistenceManager
     */
    protected $persistenceManager;


    /**
     * @Flow\Inject
     * @var NodeDataRepository
     */
    protected $nodeDataRepository;


    /**
     * @Flow\Inject
     * @var NodeTypeManager
     */
    protected $nodeTypeManager;



    /**
     * @Flow\After("method(PHLU\Neos\Models\Domain\Repository\ContactRepository->add|update())")
     * @return void
     */
    public function update(JoinPointInterface $joinPoint)
    {



    }



    /**
     * @param mixed $course
     * @throws \TYPO3\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    protected function findCourseNodesAndUpdate($course)
    {



    }


    /**
     * @param NodeData $node
     * @param mixed $course
     * @return NodeData
     */
    public function updateCourseNode(NodeData $node, $course)
    {





    }




}
