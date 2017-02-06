<?php

namespace PHLU\Neos\Models\Aspects;


use PHLU\Neos\Models\Domain\Model\Project;
use PHLU\Neos\Models\Domain\Repository\ProjectRepository;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Aop\JoinPointInterface;
use Neos\Flow\Error\Exception;
use Neos\Flow\Persistence\Doctrine\PersistenceManager;
use TYPO3\Neos\Domain\Service\SiteService;
use TYPO3\TYPO3CR\Domain\Model\NodeData;
use TYPO3\TYPO3CR\Domain\Repository\NodeDataRepository;
use TYPO3\TYPO3CR\Domain\Service\NodeTypeManager;
use TYPO3\TYPO3CR\Domain\Service\ContentContextFactory;
use Neoslive\Hybridsearch\Factory\SearchIndexFactory;

/**
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class ProjectAspect
{


    /**
     * @Flow\Inject
     * @var \TYPO3\TYPO3CR\Domain\Repository\WorkspaceRepository
     */
    protected $workspaceRepository;


    /**
     * @Flow\Inject
     * @var SearchIndexFactory
     */
    protected $searchIndexFactory;


    /**
     * @Flow\Inject
     * @var NodeTypeManager
     */
    protected $nodeTypeManager;


    /**
     * @Flow\Inject
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * @Flow\Inject
     * @var ProjectRepository
     */
    protected $projectRepository;

    /**
     * @Flow\Inject
     * @var ProjectRepository
     */
    protected $siteService;


    /**
     * @Flow\Inject
     * @var NodeDataRepository
     */
    protected $nodeDataRepository;


    /**
     * @param Project $project
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    protected function findProjectNodesAndUpdate(Project $project)
    {


        $projectId = false;
        foreach ($this->workspaceRepository->findAll() as $workspace) {
            foreach ($this->nodeDataRepository->findByParentAndNodeTypeRecursively(SiteService::SITES_ROOT_PATH, 'PHLU.Neos.NodeTypes:Project', $this->workspaceRepository->findByName($workspace)->getFirst()) as $node) {
                if ($node->getProperty('id') == $project->getId()) {
                    $this->nodeDataRepository->update($this->updateProjectNode($node, $project));
                    $projectId = $project->getId();
                }
            }
        }

        if ($projectId === false) {


            // create project node
            $baseNode = $this->nodeDataRepository->findOneByIdentifier('fc3e89af-ca93-4f2d-ab77-a2bd698f291f', $this->workspaceRepository->findByIdentifier('live'));
            /* @var $baseNodeDatabase NodeData */
            $baseNodeDatabase = $this->nodeDataRepository->findOneByPath($baseNode->getPath() . "/database", $this->workspaceRepository->findByIdentifier('live'));
            if ($baseNodeDatabase !== null) {
                $nodeType = $this->nodeTypeManager->getNodeType('PHLU.Neos.NodeTypes:Project');

                if ($this->nodeDataRepository->findOneByPath($baseNodeDatabase->getPath() . "/" . 'project-' . $project->getId(), $this->workspaceRepository->findByIdentifier('live')) === null) {
                    $projectNode = $baseNodeDatabase->createNodeData('project-' . $project->getId(), $nodeType);
                    $this->nodeDataRepository->update($this->updateProjectNode($projectNode, $project));
                }
            }


        }


        $project->setHasChanges(false);
        $this->projectRepository->update($project);


    }


    /**
     * @param NodeData $node
     * @param Project $project
     * @return NodeData
     */
    public function updateProjectNode(NodeData $node, Project $project)
    {


        $node->setProperty('id', $project->getId());
        $node->setProperty('title', $project->getTitleGerman());
        $node->setProperty('status', $project->getPPDBStatus());
        $node->setProperty('statuslifetime', $project->getPPDBStatusLifetime());
        $node->setProperty('titlegerman', $project->getTitleGerman());
        $node->setProperty('titleenglish', $project->getTitleEnglish());
        $node->setProperty('teasertextgerman', $project->getTeaserTextGerman());
        $node->setProperty('teasertextenglish', $project->getTeaserTextEnglish());
        $node->setProperty('abstracttextgerman', $project->getAbstractTextGerman());
        $node->setProperty('abstracttextenglish', $project->getAbstractTextEnglish());
        $node->setProperty('researchmainfocus', $project->getResearchMainFocus());
        $node->setProperty('researchunit', $project->getResearchUnit());
        $node->setProperty('organisationunits', $project->getOrganisationUnits());
        $node->setProperty('financingtypes', $project->getFinancingTypes());
        $node->setProperty('photos', $project->getPhotos());
        $node->setProperty('documents', $project->getDocuments());
        $node->setProperty('links', $project->getLinks());
        $node->setProperty('participants', $project->getParticipants());
        $node->setProperty('startdate', $project->getStartDate());
        $node->setProperty('enddate', $project->getEndDate());
        $node->setProperty('lastmodify', $project->getLastModify());


        return $node;


    }


    /**
     * @Flow\After("method(PHLU\Neos\Models\Domain\Repository\ProjectRepository->add|update())")
     * @return void
     */
    public function update(JoinPointInterface $joinPoint)
    {


        $this->findProjectNodesAndUpdate($joinPoint->getMethodArgument('object'));

    }


}
