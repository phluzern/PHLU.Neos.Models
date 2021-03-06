<?php

namespace Phlu\Neos\Models\Aspects;


use Phlu\Neos\Models\Domain\Model\Project;
use Phlu\Neos\Models\Domain\Repository\ProjectRepository;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Aop\JoinPointInterface;
use Neos\Flow\Error\Exception;
use Neos\Flow\Persistence\Doctrine\PersistenceManager;
use Neos\Neos\Domain\Service\SiteService;
use Neos\ContentRepository\Domain\Model\NodeData;
use Neos\ContentRepository\Domain\Repository\NodeDataRepository;
use Neos\ContentRepository\Domain\Service\NodeTypeManager;
use Neos\ContentRepository\Domain\Service\ContentContextFactory;

/**
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class ProjectAspect
{


    /**
     * @Flow\Inject
     * @var \Neos\ContentRepository\Domain\Repository\WorkspaceRepository
     */
    protected $workspaceRepository;




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
     * @return mixed
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    protected function findProjectNodesAndUpdate(Project $project)
    {


        // create project node
        $baseNode = $this->nodeDataRepository->findOneByIdentifier('fc3e89af-ca93-4f2d-ab77-a2bd698f291f', $this->workspaceRepository->findByIdentifier('live'));

        if (!$baseNode) {
            return null;
        }

        /* @var $baseNodeDatabase NodeData */
        $baseNodeDatabase = $this->nodeDataRepository->findOneByPath($baseNode->getPath() . "/database", $this->workspaceRepository->findByIdentifier('live'));
        $projectNode = $this->nodeDataRepository->findOneByPath($baseNodeDatabase->getPath() . "/" . 'project-' . $project->getId(), $this->workspaceRepository->findByIdentifier('live'));

        if (!$projectNode) {

            if ($baseNodeDatabase !== null) {
                $nodeType = $this->nodeTypeManager->getNodeType('Phlu.Neos.NodeTypes:Project');
                $projectNode = $baseNodeDatabase->createNodeData('project-' . $project->getId(), $nodeType);
                $this->nodeDataRepository->update($this->updateProjectNode($projectNode, $project));
            }


        } else {
            $this->nodeDataRepository->update($this->updateProjectNode($projectNode, $project));
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
        $node->setProperty('projectType', $project->getProjectType());
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
     * @Flow\After("method(Phlu\Neos\Models\Domain\Repository\ProjectRepository->add|update())")
     * @return void
     */
    public function update(JoinPointInterface $joinPoint)
    {


        $this->findProjectNodesAndUpdate($joinPoint->getMethodArgument('object'));

    }


}
