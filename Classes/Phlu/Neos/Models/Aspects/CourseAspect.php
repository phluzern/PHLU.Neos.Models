<?php

namespace Phlu\Neos\Models\Aspects;


use Neos\Eel\FlowQuery\FlowQuery;
use Neos\Utility\ObjectAccess;
use org\bovigo\vfs\vfsStreamWrapperAlreadyRegisteredTestCase;
use Phlu\Evento\Service\Course\ImportService;
use Phlu\Neos\Models\Domain\Model\Course\Study\AbstractStudy;
use Phlu\Neos\Models\Domain\Model\Course\Study\FurtherEducation\Course;
use Phlu\Neos\Models\Domain\Repository\CourseRepository;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Doctrine\PersistenceManager;
use Neos\Neos\Domain\Repository\SiteRepository;
use Neos\Neos\Domain\Service\ContentContextFactory;
use Neos\Neos\Utility\NodeUriPathSegmentGenerator;
use Neos\ContentRepository\Domain\Model\NodeData;
use Neos\ContentRepository\Domain\Repository\NodeDataRepository;
use Neos\ContentRepository\Domain\Service\NodeTypeManager;
use Neos\Flow\Aop\JoinPointInterface;
use Neos\Neos\Domain\Service\SiteService;
use Neos\Neos\Domain\Model\Site;
use Neos\ContentRepository\Domain\Model\Node;

/**
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class CourseAspect
{


    /**
     * @Flow\Inject
     * @var SiteRepository
     */
    protected $siteRepository;


    /**
     * @Flow\Inject
     * @var NodeUriPathSegmentGenerator
     */
    protected $nodeUriPathSegmentGenerator;


    /**
     * @Flow\Inject
     * @var \Neos\ContentRepository\Domain\Repository\WorkspaceRepository
     */
    protected $workspaceRepository;


    /**
     * @Flow\Inject
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * @Flow\Inject
     * @var \Phlu\Neos\Models\Domain\Repository\Course\Study\FurtherEducation\CourseRepository
     */
    protected $furtherEducationStudyRepository;

    /**
     * @Flow\Inject
     * @var \Phlu\Neos\Models\Domain\Repository\Course\Module\FurtherEducation\CourseRepository
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
     * @Flow\Inject
     * @var ContentContextFactory
     */
    protected $contentContextFactory;





    /**
     * @Flow\After("method(Phlu\Neos\Models\Domain\Repository\Course\Study\FurtherEducation\CourseRepository->add|update())")
     * @return void
     */
    public function updateFurtherEducationStudy(JoinPointInterface $joinPoint)
    {
        $this->findCourseNodesAndUpdate($joinPoint->getMethodArgument('object'));
    }

    /**
     * @Flow\After("method(Phlu\Neos\Models\Domain\Repository\Course\Module\FurtherEducation\CourseRepository->add|update())")
     * @return void
     */
    public function updateFurtherEducationModule(JoinPointInterface $joinPoint)
    {
        $this->findCourseNodesAndUpdate($joinPoint->getMethodArgument('object'));
    }

    /**
     * @Flow\After("method(Phlu\Neos\Models\Domain\Repository\Course\Event\FurtherEducation\CourseRepository->add|update())")
     * @return void
     */
    public function updateFurtherEducationEvent(JoinPointInterface $joinPoint)
    {
        $this->findCourseNodesAndUpdate($joinPoint->getMethodArgument('object'));
    }


    /**
     * @param mixed $course
     * @param NodeData $node
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     * @return NodeData
     */
    protected function updateProperties($course, $node)
    {




        $node->setProperty('uriPathSegment', $this->nodeUriPathSegmentGenerator->generateUriPathSegment(null, $course->getTitle()));
        $node->setProperty('title', $course->getTitle());
        $node->setProperty('nr', $course->getNr());
        $node->setProperty('description', $course->getDescription());
        $node->setProperty('ects', $course->getEcts());
        $node->setProperty('fee', $course->getFee());
        $node->setProperty('subsidizedFee', $course->getSubsidizedFee());
        $node->setProperty('materialCosts', $course->getMaterialCosts());
        $node->setProperty('leaders', $course->getLeaders());
        $node->setProperty('contacts', $course->getContacts());
        $node->setProperty('targetgroups', $course->getTargetgroups());
        $node->setProperty('deleted', $course->isDeleted());
        $node->setProperty('sections', $course->getSections());
        $node->setProperty('lessons', $course->getLessons());
        $node->setProperty('id',$course->getId());
        $node->setProperty('isEmpfohlen',$course->isisEmpfohlen());
        $node->setProperty('isLastMinute',$course->isisLastMinute());
        $node->setProperty('isNeuste',$course->isisNeuste());
        $node->setProperty('isRequestable',$course->isRequestable());
        $node->setProperty('holKursComment',$course->getHolKursComment());
        $node->setProperty('holKursAnmeldeLink',$course->getHolKursAnmeldeLink());
        $node->setProperty('duration',$course->getDuration());


        switch ($node->getNodeType()->getName()) {

            case 'Phlu.Neos.NodeTypes:Course.Study.FurtherEducation':
            case 'Phlu.Corporate:Page.FurtherEducation.Detail.Study':
                /* @var $course \Phlu\Neos\Models\Domain\Model\Course\Study\FurtherEducation\Course */
                $node->setProperty('graduation', $course->getGraduation());
                break;

            case 'Phlu.Neos.NodeTypes:Course.Module.FurtherEducation':
            case 'Phlu.Corporate:Page.FurtherEducation.Detail.Module':
                /* @var $course \Phlu\Neos\Models\Domain\Model\Course\Module\FurtherEducation\Course */
                $node->setProperty('region', $course->getRegion());
                break;

        }




        $node->setProperty('years', $course->getYears());
        $node->setProperty('genre', $course->getGenre());
        $node->setProperty('start', $course->getStart());
        $node->setProperty('isinstock', $course->isIsinstock());
        $node->setProperty('isEmpfohlen',$course->isisEmpfohlen());
        $node->setProperty('isLastMinute',$course->isisLastMinute());
        $node->setProperty('isNeuste',$course->isisNeuste());


        return $node;

    }


    /**
     * @param mixed $course
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    protected function findCourseNodesAndUpdate($course)
    {


        $settings = $this->importService->getSettingsFromObject($course);



        $courseid = false;
        $id = [];

        foreach ($this->workspaceRepository->findAll() as $workspace) {

            foreach ($this->nodeDataRepository->findByParentAndNodeTypeRecursively(SiteService::SITES_ROOT_PATH, $settings['nodeTypeName'], $this->workspaceRepository->findByName($workspace)->getFirst()) as $node) {

                if (isset($id[$this->persistenceManager->getIdentifierByObject($node)]) == false && $node->getProperty('id') == $course->getId()) {
                    $id[$this->persistenceManager->getIdentifierByObject($node)] = true;
                    $this->nodeDataRepository->update($this->updateCourseNode($node, $course));
                    $courseid = $course->getId();
                }

            }
        }

        $courseDetailId = false;
        /* @var $baseNode NodeData */
        $baseNode = $this->nodeDataRepository->findOneByIdentifier($settings['detailContainerNodeId'], $this->workspaceRepository->findByIdentifier('live'));



        if ($baseNode) {



            // create course detail page node
            /* @var $baseNode NodeData */
            $baseNodeData = $this->nodeDataRepository->findOneByIdentifier($settings['detailContainerNodeId'], $this->workspaceRepository->findByIdentifier('live'));
            $workspace = $this->workspaceRepository->findByIdentifier('live');

            if ($baseNodeData) {
                $p = explode("/", $baseNodeData->getContextPath());

                $context = $this->createContext($baseNodeData->getWorkspace()->getName(), $baseNodeData->getDimensions(), array(), $this->siteRepository->findByIdentifier($p[2]));


                $lastworkspace = null;


                $node = $this->nodeDataRepository->findOneByPath($baseNode->getPath() . "/" . strtolower($settings['repository']) . '-' . $course->getId(), $this->workspaceRepository->findByName($workspace)->getFirst());


                if ($node) {


                    $courseDetailId = $course->getId();
                    $node = $this->updateProperties($course, $node);

                    $node->setHidden(false);
                    $this->nodeDataRepository->update($node);
                    $baseNodeHeader = $this->nodeDataRepository->findOneByPath($node->getPath() . "/header", $this->workspaceRepository->findByIdentifier('live'));

                    $baseNodeHeaderHeadlines = $this->nodeDataRepository->findByParentAndNodeType($baseNodeHeader->getPath(), 'Phlu.Corporate:Headline', $this->workspaceRepository->findByIdentifier('live'));
                    foreach ($baseNodeHeaderHeadlines as $headline) {
                        $headline->setProperty('text', $course->getTitle());
                        $this->nodeDataRepository->update($headline);
                    }

                    $baseNodeHeaderTextes = $this->nodeDataRepository->findByParentAndNodeType($baseNodeHeader->getPath(), 'Phlu.Corporate:TextPlain', $this->workspaceRepository->findByIdentifier('live'));
                    foreach ($baseNodeHeaderTextes as $text) {
                        if ($node->getNodeType()->getName() == 'Phlu.Corporate:Page.FurtherEducation.Detail.Module') {
                            $text->setProperty('text', '');
                        } else {
                            if ($text->getProperty('text') == '') {
                                $text->setProperty('text', $course->getDescription());
                            }
                        }
                        $this->nodeDataRepository->update($text);
                    }


                    $baseNodeMain = $this->nodeDataRepository->findOneByPath($node->getPath() . "/main", $this->workspaceRepository->findByIdentifier('live'));


                    if (!$baseNodeMain) {
                        return $course;
                    }


                    $baseNodeMainSections = $this->nodeDataRepository->findByParentAndNodeType($baseNodeMain->getPath(), $settings['sectionNodeType'], $this->workspaceRepository->findByIdentifier('live'));


                    /* @var Course $course */
                    $courseSections = array();
                    if ($course->getSections()) {
                        foreach ($course->getSections() as $courseSection) {
                            if ($courseSection->Text !== $course->getDescription()) {
                                $courseSections[$courseSection->Nr] = $courseSection;
                            }
                        }
                    }


                    if (count($courseSections) == 0 && $node->getNodeType()->getName() == 'Phlu.Corporate:Page.FurtherEducation.Detail.Module') {
                        $courseSection = new \stdClass();
                        $courseSection->Text = nl2br($course->getDescription());
                        if ($course->getShortdescription() && strlen($course->getShortdescription())) {
                            $courseSection->Text = $courseSection->Text . "<h3>Bemerkungen</h3><p>".nl2br($course->getShortdescription())."</p>";
                        }
                        $courseSection->Nr = 900000;
                        $courseSection->Label = 'Beschreibung';
                        $courseSections[$courseSection->Nr] = $courseSection;
                    }


                    $nodeSections = array();
                    $nodeSectionsUpdated = array();

                    foreach ($baseNodeMainSections as $section) {
                        if ($section->getProperty('internalid') > 0) {
                            $nodeSections[$section->getProperty('internalid')] = $section;
                        }
                    }




                    foreach ($courseSections as $nr => $courseSection) {


                        if (isset($nodeSections[$nr]) == false) {

                            // create node section
                            if ($nr == 900000 || $nr == 3 || $nr == 5) {
                                $nodeSections[$nr] = $baseNodeMain->createNodeData('section-' . $course->getId() . "-" . $nr, $this->nodeTypeManager->getNodeType($settings['sectionNodeType']), null, $workspace, $baseNode->getDimensions());
                                $nodeSections[$nr]->setProperty('internalid', $nr);
                                $nodeSections[$nr]->setIndex($nr);

                            }
                        }




                        if (isset($nodeSections[$nr]) == true) {

                            /** @var Node $node */
                            $baseNodeSection = new Node(
                                $nodeSections[$nr],
                                $context
                            );

                            $sectionTextNode = null;


                            foreach ($this->nodeDataRepository->findByParentWithoutReduce($baseNodeSection->getPath() . "/main", $this->workspaceRepository->findByIdentifier('live'), true) as $sectionText) {

                                if ($sectionText->getProperty('internalid') == $nr || $sectionText->getName() == 'text-' . $course->getId() . "-" . $nr) {
                                    $sectionTextNode = $sectionText;
                                }
                            }


                            if ($sectionTextNode === null) {
                                $sectionTextNode = $baseNodeSection->getPrimaryChildNode()->createNode('text-' . $course->getId() . "-" . $nr, $this->nodeTypeManager->getNodeType($settings['sectionTextNodeType']))->getNodeData();
                            }

                            $courseSection->Text = trim($courseSection->Text);
                            $htmlText = substr($courseSection->Text, 0, 2) == "<p" ? $courseSection->Text : "<p>" . $courseSection->Text . "</p>";


                            /** @var Node $sectionTextNode */
                            $sectionTextNode->setProperty('text', $htmlText);
                            $sectionTextNode->setProperty('internalid', $nr);
                            $nodeSections[$nr]->setProperty('title', strip_tags($courseSection->Label));
                            $nodeSections[$nr]->setIndex($nr);
                            $this->nodeDataRepository->update($sectionTextNode);
                            $this->nodeDataRepository->update($nodeSections[$nr]);
                            $nodeSectionsUpdated[$nr] = $nr;

                            if ($courseSection->Nr != 900000 && $courseSection->Nr != 3 && $courseSection->Nr != 5) {
                                $sectionTextNode->remove();
                                $nodeSections[$nr]->remove();
                            }

                        }

                    }


                    $this->nodeDataRepository->update($baseNodeMain);

                }


                if (isset($nodeSections)) {
                    foreach ($nodeSections as $nodeSection) {
                        if (isset($nodeSectionsUpdated[$nodeSection->getProperty('internalid')]) === false) {
                            // remove node section
                            $this->nodeDataRepository->remove($nodeSection);
                        }
                    }
                }



                if ($courseid === false && $course->isDeleted() === false) {

                    // create course node
                    $baseNode = $this->nodeDataRepository->findOneByIdentifier($settings['containerNodeId'], $this->workspaceRepository->findByIdentifier('live'));



                    if ($baseNode) {
                        /* @var $baseNodeDatabase NodeData */
                        $baseNodeDatabase = $this->nodeDataRepository->findOneByPath($baseNode->getPath() . "/database", $this->workspaceRepository->findByIdentifier('live'));



                        if ($baseNodeDatabase !== null) {
                            $nodeType = $this->nodeTypeManager->getNodeType($settings['nodeTypeName']);


                            $b = $this->nodeDataRepository->findOneByPath($baseNodeDatabase->getPath() . "/" . strtolower($settings['repository']) . '-' . $course->getId(), $this->workspaceRepository->findByIdentifier('live'));

                            if (is_null($b)) {

                                $courseNode = $baseNodeDatabase->createNodeData(strtolower($settings['repository']) . '-' . $course->getId(), $nodeType, null,$workspace, $baseNode->getDimensions());
                                $courseNode->setProperty('id', $course->getId());

                                $this->nodeDataRepository->update($this->updateCourseNode($courseNode, $course));

                            }
                        }
                    }

                }



                if ($courseDetailId === false && $course->isDeleted() === false) {
                    // create course detail page node
                    /* @var $baseNode NodeData */
                    $baseNodeData = $this->nodeDataRepository->findOneByIdentifier($settings['detailContainerNodeId'], $this->workspaceRepository->findByIdentifier('live'));

                    if ($baseNodeData) {
                        $p = explode("/", $baseNodeData->getContextPath());

                        $context = $this->createContext($baseNodeData->getWorkspace()->getName(), $baseNodeData->getDimensions(), array(), $this->siteRepository->findByIdentifier($p[2]));

                        /** @var Node $node */
                        $baseNode = new Node(
                            $baseNodeData,
                            $context
                        );


                        if ($baseNode !== null) {

                            /* @var Course $course */

                            $nodeType = $this->nodeTypeManager->getNodeType($settings['detailNodeType']);
                            $courseDetailNode = $baseNode->createNode(strtolower($settings['repository']) . '-' . $course->getId(), $nodeType);





                            $courseDetailNode = $this->updateProperties($course, $courseDetailNode);
                            $courseDetailNode->setProperty('title', $course->getTitle());
                            $courseDetailNode->setProperty('internalid', $course->getId());
                            $courseDetailNode->setHidden(false);
                            $courseDetailNode->setProperty('uriPathSegment', $this->nodeUriPathSegmentGenerator->generateUriPathSegment(null, $course->getTitle()));
                            $this->nodeDataRepository->update($courseDetailNode->getNodeData());


                            $baseNodeHeader = $this->nodeDataRepository->findOneByPath($courseDetailNode->getPath() . "/header", $this->workspaceRepository->findByIdentifier('live'));

                            $baseNodeHeaderHeadlines = $this->nodeDataRepository->findByParentAndNodeType($baseNodeHeader->getPath(), 'Phlu.Corporate:Headline', $this->workspaceRepository->findByIdentifier('live'));
                            foreach ($baseNodeHeaderHeadlines as $headline) {
                                $headline->setProperty('text', $course->getTitle());
                                $this->nodeDataRepository->update($headline);
                            }

                            $baseNodeHeaderTextes = $this->nodeDataRepository->findByParentAndNodeType($baseNodeHeader->getPath(), 'Phlu.Corporate:TextPlain', $this->workspaceRepository->findByIdentifier('live'));
                            foreach ($baseNodeHeaderTextes as $text) {
                                $text->setProperty('text', $course->getDescription());
                                $this->nodeDataRepository->update($text);
                            }


                        }
                    }

                }
            }
        }

         $this->persistenceManager->persistAll();


    }


    /**
     * @param NodeData $node
     * @param mixed $course
     * @return NodeData
     */
    public function updateCourseNode(NodeData $node, $course)
    {



        /* @var $course \Phlu\Neos\Models\Domain\Model\Course\AbstractCourse */
        $node->setProperty('title', $course->getTitle());
        $node->setProperty('nr', $course->getNr());
        $node->setProperty('description', $course->getDescription());
        $node->setProperty('ects', $course->getEcts());
        $node->setProperty('fee', $course->getFee());
        $node->setProperty('subsidizedFee', $course->getSubsidizedFee());
        $node->setProperty('materialCosts', $course->getMaterialCosts());
        $node->setProperty('leaders', $course->getLeaders());
        $node->setProperty('targetgroups', $course->getTargetgroups());
        $node->setProperty('deleted', $course->isDeleted());


        $node->setProperty('years', $course->getYears());
        $node->setProperty('genre', $course->getGenre());
        $node->setProperty('start', $course->getStart());
        $node->setProperty('isinstock', $course->isIsinstock());
        $node->setProperty('isEmpfohlen',$course->isisEmpfohlen());
        $node->setProperty('isLastMinute',$course->isisLastMinute());
        $node->setProperty('isNeuste',$course->isisNeuste());
        $node->setProperty('isRequestable',$course->isRequestable());
        $node->setProperty('holKursComment',$course->getHolKursComment());
        $node->setProperty('holKursAnmeldeLink',$course->getHolKursAnmeldeLink());
        $node->setProperty('statusDescription',$course->getStatusDescription());
        $node->setProperty('duration',$course->getDuration());


        switch ($node->getNodeType()->getName()) {

            case 'Phlu.Neos.NodeTypes:Course.Study.FurtherEducation':
                /* @var $course \Phlu\Neos\Models\Domain\Model\Course\Study\FurtherEducation\Course */
                $node->setProperty('graduation', $course->getGraduation());
                break;

            case 'Phlu.Corporate:Page.FurtherEducation.Detail.Study':
                /* @var $course \Phlu\Neos\Models\Domain\Model\Course\Study\FurtherEducation\Course */
                $node->setProperty('graduation', $course->getGraduation());
                break;

            case 'Phlu.Neos.NodeTypes:Course.Module.FurtherEducation':
                /* @var $course \Phlu\Neos\Models\Domain\Model\Course\Module\FurtherEducation\Course */

                break;

        }


        return $node;


    }

    /**
     * Creates a content context for given workspace
     *
     * @param string $workspaceName
     * @param array $dimensions
     * @param array $targetDimensions
     * @param Site $currentSite
     * @return \Neos\ContentRepository\Domain\Service\Context
     */
    protected
    function createContext($workspaceName, $dimensions, $targetDimensions, $currentSite)
    {


        return $this->contentContextFactory->create(array(
            'workspaceName' => $workspaceName,
            'currentSite' => $currentSite,
            'currentSiteNode' => $currentSite,
            'dimensions' => $dimensions,
            'targetDimensions' => $targetDimensions,
            'invisibleContentShown' => false,
            'inaccessibleContentShown' => false,
            'removedContentShown' => false
        ));
    }


}
