<?php

namespace PHLU\Neos\Models\Aspects;


use PHLU\Evento\Service\Course\ImportService;
use PHLU\Neos\Models\Domain\Model\Course\Study\FurtherEducation\Course;
use PHLU\Neos\Models\Domain\Repository\CourseRepository;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Doctrine\PersistenceManager;
use TYPO3\TYPO3CR\Domain\Model\NodeData;
use TYPO3\TYPO3CR\Domain\Repository\NodeDataRepository;
use TYPO3\TYPO3CR\Domain\Service\NodeTypeManager;
use TYPO3\Flow\Aop\JoinPointInterface;
use TYPO3\Neos\Domain\Service\SiteService;

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
     * @var \PHLU\Neos\Models\Domain\Repository\Course\Study\FurtherEducation\CourseRepository
     */
    protected $furtherEducationStudyRepository;

    /**
     * @Flow\Inject
     * @var \PHLU\Neos\Models\Domain\Repository\Course\Module\FurtherEducation\CourseRepository
     */
    protected $furtherEducationModuleRepository;

    /**
     * @Flow\Inject
     * @var NodeDataRepository
     */
    protected $nodeDataRepository;

    /**
     * @Flow\Inject
     * @var ImportService
     */
    protected $importService;


    /**
     * @Flow\Inject
     * @var NodeTypeManager
     */
    protected $nodeTypeManager;




    /**
     * @Flow\After("method(PHLU\Neos\Models\Domain\Repository\Course\Study\FurtherEducation\CourseRepository->add|update())")
     * @return void
     */
    public function updateFurtherEducationStudy(JoinPointInterface $joinPoint)
    {
        $this->findCourseNodesAndUpdate($joinPoint->getMethodArgument('object'));
    }

    /**
     * @Flow\After("method(PHLU\Neos\Models\Domain\Repository\Course\Module\FurtherEducation\CourseRepository->add|update())")
     * @return void
     */
    public function updateFurtherEducationModule(JoinPointInterface $joinPoint)
    {
        $this->findCourseNodesAndUpdate($joinPoint->getMethodArgument('object'));
    }



    /**
     * @param mixed $course
     * @throws \TYPO3\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    protected function findCourseNodesAndUpdate($course)
    {

        $settings = $this->importService->getSettingsFromObject($course);


        $courseid = false;
        foreach ($this->workspaceRepository->findAll() as $workspace) {
            foreach ($this->nodeDataRepository->findByParentAndNodeTypeRecursively(SiteService::SITES_ROOT_PATH, $settings['nodeTypeName'], $this->workspaceRepository->findByName($workspace)->getFirst()) as $node) {
                if ($node->getProperty('id') == $course->getId()) {
                    $this->nodeDataRepository->update($this->updateCourseNode($node, $course));
                    $courseid = $course->getId();
                }
            }
        }

        if ($courseid === false && $course->isDeleted() === false ) {

            // create course node
            $baseNode = $this->nodeDataRepository->findOneByIdentifier($settings['containerNodeId'], $this->workspaceRepository->findByIdentifier('live'));
            /* @var $baseNodeDatabase NodeData */
            $baseNodeDatabase = $this->nodeDataRepository->findOneByPath($baseNode->getPath() . "/database", $this->workspaceRepository->findByIdentifier('live'));
            if ($baseNodeDatabase !== null) {
                $nodeType = $this->nodeTypeManager->getNodeType($settings['nodeTypeName']);

                if ($this->nodeDataRepository->findOneByPath($baseNodeDatabase->getPath() . "/" . strtolower($settings['repository']).'-' . $course->getId(), $this->workspaceRepository->findByIdentifier('live')) === null) {
                    $courseNode = $baseNodeDatabase->createNodeData(strtolower($settings['repository']).'-' . $course->getId(), $nodeType);
                    $courseNode->setProperty('id', $course->getId());
                    $this->nodeDataRepository->update($this->updateCourseNode($courseNode, $course));
                }
            }


        }



    }
    


    /**
     * @param NodeData $node
     * @param mixed $course
     * @return NodeData
     */
    public function updateCourseNode(NodeData $node, $course)
    {

        /* @var $course \PHLU\Neos\Models\Domain\Model\Course\AbstractCourse */
        $node->setProperty('title',$course->getTitle());
        $node->setProperty('nr',$course->getNr());
        $node->setProperty('description',$course->getDescription());
        $node->setProperty('ects',$course->getEcts());
        $node->setProperty('fee',$course->getFee());
        $node->setProperty('leaders',$course->getLeaders());
        $node->setProperty('targetgroups',$course->getTargetgroups());

        switch ($node->getNodeType()->getName()) {

            case 'PHLU.Neos.NodeTypes:Course.Study.FurtherEducation':
            /* @var $course \PHLU\Neos\Models\Domain\Model\Course\Study\FurtherEducation\Course */
            $node->setProperty('graduation',$course->getGraduation());
            break;

            case 'PHLU.Neos.NodeTypes:Course.Module.FurtherEducation':
            /* @var $course \PHLU\Neos\Models\Domain\Model\Course\Module\FurtherEducation\Course */

            break;

        }


        return $node;


    }




}
