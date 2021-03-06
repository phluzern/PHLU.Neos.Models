<?php
namespace Phlu\Neos\Models\Service\Publication;

/*
 * This file is part of the Phlu.Neos.Models package.
 */


use Phlu\Neos\Models\Domain\Model\Publication;
use Phlu\Neos\Models\Domain\Repository\ContactRepository;
use Phlu\Neos\Models\Domain\Repository\PublicationRepository;
use Neos\Flow\Annotations as Flow;


class PublicationService
{

    protected $defaultData = array(
        'Citationstyle' => '',
        'Title' => '',
        'Language' => '',
        'URL' => '',
        'Persons' => array(),
        'Projects' => array()
    );


    /**
     * @Flow\Inject
     * @var ContactRepository
     */
    protected $contactRepository;



    /**
     * @Flow\Inject
     * @var PublicationRepository
     */
    protected $publicationRepository;



    /**
     * @Flow\Inject
     * @var \Neos\Flow\Persistence\PersistenceManagerInterface
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
        $publication->setDate(isset($data['Date']) && is_object($data['Date']) ? $data['Date'] : new \DateTime());
        $publication->setPublicationType($data['PublicationTypeId']);
        $publication->setPersons($data['Persons']);
        $publication->setOrganisations($data['Organisations']);

        if (isset($data['DOI_URL']) && strlen($data['DOI_URL']) > 6) {
            $publication->setUrl($data['DOI_URL']);
        } else {
            $publication->setUrl($data['URL']);
        }

        if (strlen($publication->getUrl()) < 3 && isset($data['edocURL']) && strlen($data['edocURL']) > 6) {
            $publication->setUrl($data['edocURL']);
        }


        if ($publication->isHasChanges()) {
            // force update contacts publication
            foreach ($publication->getPersons() as $person) {
                $contact = $this->contactRepository->getOneByEventoId($person['EventoID']);
                if ($contact) {
                    $contact->setHash(time());
                    $this->contactRepository->update($contact);
                }
            }
        }

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
