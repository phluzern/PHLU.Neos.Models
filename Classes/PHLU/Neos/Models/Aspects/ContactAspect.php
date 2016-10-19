<?php

namespace PHLU\Neos\Models\Aspects;


use PHLU\Neos\Models\Domain\Model\Contact;
use PHLU\Neos\Models\Domain\Repository\ContactRepository;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Aop\JoinPointInterface;
use TYPO3\Flow\Error\Exception;
use TYPO3\Flow\Persistence\Doctrine\PersistenceManager;
use TYPO3\Neos\Domain\Service\SiteService;
use TYPO3\TYPO3CR\Domain\Model\NodeData;
use TYPO3\TYPO3CR\Domain\Repository\NodeDataRepository;
use Neoslive\Hybridsearch\Factory\SearchIndexFactory;
use TYPO3\TYPO3CR\Domain\Service\NodeTypeManager;

/**
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class ContactAspect
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
     * @var ContactRepository
     */
    protected $contactRepository;


    /**
     * @Flow\Inject
     * @var SearchIndexFactory
     */
    protected $searchIndexFactory;


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
     * @param Contact $contact
     * @throws \TYPO3\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    protected function findContactNodesAndUpdate(Contact $contact)
    {


        $contactid = false;
        foreach ($this->workspaceRepository->findAll() as $workspace) {
            foreach ($this->nodeDataRepository->findByParentAndNodeTypeRecursively(SiteService::SITES_ROOT_PATH, 'PHLU.Corporate:Contact', $this->workspaceRepository->findByName($workspace)->getFirst()) as $node) {
                if ($node->getProperty('contact') == $contact->getEventoid()) {
                    $this->nodeDataRepository->update($this->updateContactNode($node, $contact));
                    $contactid = $contact->getEventoid();
                }
            }
        }

        if ($contactid === false) {

            // create contact node
            $baseNode = $this->nodeDataRepository->findOneByIdentifier('7f434ec8-ad74-4032-a8fe-6842c4d3e4a1', $this->workspaceRepository->findByIdentifier('live'));
            /* @var $baseNodeDatabase NodeData */
            $baseNodeDatabase = $this->nodeDataRepository->findOneByPath($baseNode->getPath() . "/database", $this->workspaceRepository->findByIdentifier('live'));
            $nodeType = $this->nodeTypeManager->getNodeType('PHLU.Corporate:Contact');
            if ($this->nodeDataRepository->findOneByPath($baseNodeDatabase->getPath() . "/" . 'contact-' . $contact->getEventoid(),$this->workspaceRepository->findByIdentifier('live')) === null) {
                $contactNode = $baseNodeDatabase->createNodeData('contact-' . $contact->getEventoid(), $nodeType);
                $this->nodeDataRepository->update($this->updateContactNode($contactNode, $contact));
            }


        }


        $contact->setHasChanges(false);
        $this->contactRepository->update($contact);


    }


    /**
     * @param NodeData $node
     * @param Contact $contact
     * @return NodeData
     */
    public function updateContactNode(NodeData $node, Contact $contact)
    {


        $node->setProperty('firstname', $contact->getName()->getFirstName());
        $node->setProperty('lastname', $contact->getName()->getLastName());
        $node->setProperty('titlename', $contact->getName()->getTitle());
        $node->setProperty('street', $contact->getStreet());
        $node->setProperty('street2', $contact->getStreetnote());
        $node->setProperty('zip', $contact->getZip());
        $node->setProperty('city', $contact->getCity());
        $node->setProperty('email', $contact->getEmail());
        $node->setProperty('phone', $contact->getPhone());
        $node->setProperty('text', $contact->getName()->getFirstName() . " " . $contact->getName()->getLastName());

        if ($node->getProperty('functionCustom') == '') {
            $node->setProperty('function', $contact->getFunction());
        } else {
            $node->setProperty('function', $node->getProperty('functionCustom'));
        }
        $node->setProperty('image', $contact->getImage());


        $this->searchIndexFactory->updateIndexForNodeData($node);

        return $node;


    }


    /**
     * @Flow\After("method(PHLU\Neos\Models\Domain\Repository\ContactRepository->add|update())")
     * @return void
     */
    public function update(JoinPointInterface $joinPoint)
    {


        $this->findContactNodesAndUpdate($joinPoint->getMethodArgument('object'));

    }


    /**
     * @Flow\Before("method(TYPO3\TYPO3CR\Domain\Repository\NodeDataRepository->update(object.nodeType.name == 'PHLU.Corporate:Contact'))")
     * @return void
     */
    public function updateContactNodeData(JoinPointInterface $joinPoint)
    {


        $object = $joinPoint->getMethodArgument('object');

        if ($object->getProperty('contact') != 0) {

            $contact = $this->contactRepository->getOneByEventoId($object->getProperty('contact'));

            if ($contact) {
                $this->updateContactNode($object, $contact);
            }


        }


    }


}
