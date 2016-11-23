<?php
namespace PHLU\Neos\Models\Service\Publication;

/*
 * This file is part of the PHLU.Neos.Models package.
 */


use PHLU\Neos\Models\Domain\Model\Publication;
use PHLU\Neos\Models\Domain\Repository\PublicationRepository;
use TYPO3\Flow\Annotations as Flow;


class PublicationService
{

    protected $defaultData = array(
        'Citationstyle' => '',
        'Title' => '',
        'Language' => '',
        'Projects' => array()
    );


    /**
     * @Flow\Inject
     * @var PublicationRepository
     */
    protected $publicationRepository;



    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
     */
    protected $persistenceManager;




    /**
     * Returns a publication model
     *
     * @param array $data
     * @return Publication
     * @api
     */
    public function getModel($data)
    {


        // set default values
        foreach ($this->defaultData as $key => $val) {
            if (isset($data[$key]) === false) $data[$key] = $val;
        }

        $hash = sha1(json_encode($data));

        $publication = $this->publicationRepository->getOneByPpDbId($data['ID']);

        if ($publication === null) $publication = new Publication();

        $publication->setId($data['ID']);
        $publication->setCitationstyle($data['Citationstyle']);
        $publication->setTitle($data['Title']);
        $publication->setLanguage($data['Language']);
        $publication->setProjects($data['Projects']);
        $publication->setDate(is_object($data['Date']) ? $data['Date'] : new \DateTime());
        $publication->setPublicationType($data['PublicationTypeId']);
        $publication->setPersons($data['Persons']);
        $publication->setOrganisations($data['Organisations']);


        $publication->setHasChanges($publication->getHash() === $hash ? false : true);
        $publication->setHash($hash);


        return $publication;


    }


    /**
     * Creates or updates a publication
     * @param Publication $publication
     * @return Publication persisted publication
     * @api
     */
    public function createOrUpdatePublication(Publication $publication)
    {


        if ($this->persistenceManager->isNewObject($publication) === false) {
            if ($publication->isHasChanges()) {
                $publication->setHasChanges(false);
                $this->publicationRepository->update($publication);
            }
        } else {
            $this->publicationRepository->add($publication);
        }


        $this->persistenceManager->persistAll();

        return $publication;


    }


}
