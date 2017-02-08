<?php

namespace Phlu\Neos\Models\Aspects;


use Phlu\Neos\Models\Domain\Model\Publication;
use Phlu\Neos\Models\Domain\Repository\PublicationRepository;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Aop\JoinPointInterface;
use Neos\Flow\Error\Exception;
use Neos\Flow\Persistence\Doctrine\PersistenceManager;
use Neos\Neos\Domain\Service\SiteService;
use Neos\ContentRepository\Domain\Model\NodeData;
use Neos\ContentRepository\Domain\Repository\NodeDataRepository;
use Neos\ContentRepository\Domain\Service\NodeTypeManager;
use Neos\ContentRepository\Domain\Service\ContentContextFactory;
use Neoslive\Hybridsearch\Factory\SearchIndexFactory;

/**
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class PublicationAspect
{


    /**
     * @Flow\Inject
     * @var \Neos\ContentRepository\Domain\Repository\WorkspaceRepository
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
     * @var PublicationRepository
     */
    protected $publicationRepository;

    /**
     * @Flow\Inject
     * @var PublicationRepository
     */
    protected $siteService;


    /**
     * @Flow\Inject
     * @var NodeDataRepository
     */
    protected $nodeDataRepository;


    /**
     * @param Publication $publication
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    protected function findPublicationNodesAndUpdate(Publication $publication)
    {



        $publicationId = false;
        foreach ($this->workspaceRepository->findAll() as $workspace) {
            foreach ($this->nodeDataRepository->findByParentAndNodeTypeRecursively(SiteService::SITES_ROOT_PATH, 'Phlu.Neos.NodeTypes:Publication', $this->workspaceRepository->findByName($workspace)->getFirst()) as $node) {
                if ($node->getProperty('Id') == $publication->getId()) {
                    $this->nodeDataRepository->update($this->updatePublicationNode($node, $publication));
                    $publicationId = $publication->getId();
                }
            }
        }

        if ($publicationId === false) {


            // create publication node
            $baseNode = $this->nodeDataRepository->findOneByIdentifier('b70fb030-fa84-474c-81cf-5dedc5ca74ef', $this->workspaceRepository->findByIdentifier('live'));
            /* @var $baseNodeDatabase NodeData */
            $baseNodeDatabase = $this->nodeDataRepository->findOneByPath($baseNode->getPath() . "/database", $this->workspaceRepository->findByIdentifier('live'));




            if ($baseNodeDatabase !== null) {
                $nodeType = $this->nodeTypeManager->getNodeType('Phlu.Neos.NodeTypes:Publication');
                if ($this->nodeDataRepository->findOneByPath($baseNodeDatabase->getPath() . "/" . 'publication-' . $publication->getId(), $this->workspaceRepository->findByIdentifier('live')) === null) {
                    $publicationNode = $baseNodeDatabase->createNodeData('publication-' . $publication->getId(), $nodeType);
                    $this->nodeDataRepository->update($this->updatePublicationNode($publicationNode, $publication));
                }
            }


        }


        $publication->setHasChanges(false);
        $this->publicationRepository->update($publication);


    }


    /**
     * @param NodeData $node
     * @param Publication $publication
     * @return NodeData
     */
    public function updatePublicationNode(NodeData $node, Publication $publication)
    {


        $node->setProperty('Id', $publication->getId());
        $node->setProperty('Citationstyle', $publication->getCitationstyle());
        $node->setProperty('title', $publication->getTitle());
        $node->setProperty('Language', $publication->getLanguage());
        $node->setProperty('Projects', $publication->getProjects());
        $node->setProperty('Date', $publication->getDate());
        $node->setProperty('PublicationType', $publication->getPublicationType());
        $node->setProperty('Persons', $publication->getPersons());
        $node->setProperty('Organisations', $publication->getOrganisations());
        $node->setProperty('Url', $publication->getUrl());

        return $node;


    }


    /**
     * @Flow\After("method(Phlu\Neos\Models\Domain\Repository\PublicationRepository->add|update())")
     * @return void
     */
    public function update(JoinPointInterface $joinPoint)
    {


        $this->findPublicationNodesAndUpdate($joinPoint->getMethodArgument('object'));

    }


}