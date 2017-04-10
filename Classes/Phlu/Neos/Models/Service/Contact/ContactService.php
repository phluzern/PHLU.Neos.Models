<?php
namespace Phlu\Neos\Models\Service\Contact;

/*
 * This file is part of the Phlu.Neos.Models package.
 */

use Aws\CloudFront\Exception\Exception;

use Phlu\Neos\Models\Domain\Model\Contact;
use Phlu\Neos\Models\Domain\Model\PersonName;
use Phlu\Neos\Models\Domain\Repository\ContactRepository;
use Neos\Flow\Annotations as Flow;
use Neos\Media\Domain\Repository\AssetCollectionRepository;
use Neos\Media\Domain\Repository\AssetRepository;
use Neos\Media\Domain\Repository\ImageRepository;
use Neos\Media\Domain\Service\ImageService;
use Neos\Media\Domain\Model\AssetCollection;


class ContactService
{

    protected $defaultData = array(
        'firstname' => 'Vorname',
        'lastname' => 'Name',
        'title' => '',
        'street' => '',
        'streetno' => '',
        'zip' => '',
        'city' => '',
        'phone' => '',
        'email' => '',
        'function' => '',
        'gender' => 0,
        '_imageUrl' => '',
        'eventoId' => 0,
        'showPortrait' => false,
        'showPortraitImage' => false,
        'organisations' => array()
    );


    /**
     * @Flow\Inject
     * @var \Neos\Flow\ResourceManagement\ResourceManager
     */
    protected $resourceManager;


    /**
     * @Flow\Inject
     * @var AssetCollectionRepository
     */
    protected $assetCollectionRepository;

    /**
     * @Flow\Inject
     * @var \Phlu\Neos\Models\AssetRepository
     */
    protected $assetRepository;

    /**
     * @Flow\Inject
     * @var ContactRepository
     */
    protected $contactRepository;

    /**
     * @Flow\Inject
     * @var ImageService
     */
    protected $imageService;

    /**
     * @Flow\Inject
     * @var ImageRepository
     */
    protected $imageRepository;

    /**
     * @var \Imagine\Image\ImagineInterface
     * @Flow\Inject(lazy = false)
     */
    protected $imagineService;


    /**
     * @Flow\Inject
     * @var \Neos\Flow\Persistence\PersistenceManagerInterface
     */
    protected $persistenceManager;


    /**
     * @Flow\Inject
     * @var \Neos\Flow\Http\Client\CurlEngine
     */
    protected $browserRequestEngine;

    /**
     * @Flow\Inject
     * @var \Neos\Flow\Http\Client\Browser
     */
    protected $browser;


    /**
     * @var AssetCollection
     */
    protected $assetCollection = false;



    /**
     * Returns a contact model
     * @return AssetCollection
     * @api
     */
    public function getAssetCollection() {


        if ($this->assetCollection === false) {
            foreach ($this->assetCollectionRepository->findAll() as $collection) {
                if ($collection->getTitle() == 'Contacts') {
                    $this->assetCollection = $collection;
                }
            }
            if ($this->assetCollection === false) {
                $this->assetCollection = new AssetCollection('Contacts');
                $this->assetCollection->setHidden(true);
                $this->assetCollectionRepository->add($this->assetCollection);
                $this->persistenceManager->persistAll();
            }

        }

        return $this->assetCollection;

    }



    /**
     * Returns a contact model
     *
     * @param array $data
     * @return Contact
     * @api
     */
    public function getModel($data)
    {


        // set default values
        foreach ($this->defaultData as $key => $val) {
            if (isset($data[$key]) === false) $data[$key] = $val;
        }


        if ($data['eventoId'] === 0) return null;

        $hash = sha1(json_encode($data));


        $contact = $this->contactRepository->getOneByEventoId($data['eventoId']);

        if ($contact === null) $contact = new Contact();

        if ($contact->getName() === null) {
            $name = new PersonName();
        } else {
            $name = $contact->getName();
        }

        $name->setFirstName($data['firstname']);
        $name->setLastName($data['lastname']);
        $name->setTitle($data['title']);
        $contact->setName($name);
        $contact->setEventoid($data['eventoId']);
        $contact->setStreet($data['street']);
        $contact->setStreetno($data['streetno']);
        $contact->setZip($data['zip']);
        $contact->setCity($data['city']);
        $contact->setPhone($data['phone']);
        $contact->setEmail($data['email']);
        $contact->setFunction($data['function']);
        $contact->setFunctions($data['functions']);
        $contact->setLinks($data['links']);
        $contact->setEducation($data['education']);
        $contact->setHonorific($data['honorific']);
        $contact->setActivities($data['activities']);
        $contact->setExpertise($data['expertise']);
        $contact->setConsulting($data['consulting']);
        $contact->setPublications($data['publications']);
        $contact->setProjects($data['projects']);
        $contact->setShowPortrait($data['showPortrait']);
        $contact->setShowPortraitImage($data['showPortraitImage']);
        $contact->setOrganisations($data['organisations']);
        $contact->setAchievements($data['achievements']);


        $contact->setHasChanges($contact->getHash() === $hash ? false : true);
        $contact->setHash($hash);



        if ($contact->isHasChanges() && $data['_imageUrl']) {

            // import image
            $this->browserRequestEngine->setOption(CURLOPT_SSL_VERIFYPEER, FALSE);
            $this->browserRequestEngine->setOption(CURLOPT_CONNECTTIMEOUT, 60);
            $this->browserRequestEngine->setOption(CURLOPT_TIMEOUT, 60);
            $this->browser->setRequestEngine($this->browserRequestEngine);

            $response = $this->browser->request($data['_imageUrl'], 'GET');

            if ($response->getStatusCode() == 200) {

                $sha1 = sha1($response->getContent());

                $resource = $this->resourceManager->getResourceBySha1($sha1);

                if (!$resource) {
                    $resource = $this->resourceManager->importResourceFromContent($response->getContent(), basename($data['_imageUrl']));
                }

                if ($resource) {
                    if ($resource->getMediaType() === 'image/jpeg') {

                        $validImage = true;
                        try {
                            $this->imagineService->read($resource->getStream());
                        } catch (\Exception $e) {
                            $validImage = false;
                        }



                        if ($validImage) {

                            $existingAsset = $this->assetRepository->findOneByResourceSha1($resource->getSha1());


                            if ($contact->getImage()) {

                                if ($existingAsset) {
                                    $resource = $existingAsset->getResource();
                                }

                                $contact->getImage()->setHidden(true);
                                $contact->getImage()->setResource($resource);
                                $contact->getImage()->refresh();
                                $contact->getImage()->setTitle($contact->getName()->getFullName());
                                $contact->getImage()->setCaption($contact->getEventoid());

                            } else {

                                if ($existingAsset) {
                                    $contact->setImage($existingAsset);
                                } else {

                                    $image = new \Neos\Media\Domain\Model\Image($resource);
                                    if ($image) {
                                        $image->setTitle($contact->getName()->getFullName());
                                        $image->setCaption($contact->getEventoid());
                                        $image->setHidden(true);
                                        $contact->setImage($image);

                                    }
                                }

                            }

                        }





                    }
                }

            }


            // find assets with same sha1, set hidden
            if ($contact->getImage()) {
                foreach ($this->assetRepository->findAllByResourceSha1($contact->getImage()->getResource()->getSha1()) as $asset) {
                    if (!$asset->getHidden()) {
                        $asset->setHidden(true);
                        $this->assetRepository->update($asset);
                    }
                }
            }


        }


        return $contact;


    }


    /**
     * Creates or updates a contact
     * @param Contact $contact
     * @return Contact persisted contact
     * @api
     */
    public function createOrUpdateContact(Contact $contact)
    {


        $updated = false;

        if ($this->persistenceManager->isNewObject($contact) === false) {
            if ($contact->isHasChanges()) {
                $contact->setHasChanges(false);
                $this->contactRepository->update($contact);
                $updated = true;
            }
        } else {
            $this->contactRepository->add($contact);
            $updated = true;
        }


        // add to asset collection
        if ($updated && $contact->getImage()) {
            $this->getAssetCollection()->addAsset($contact->getImage());
            $this->assetCollectionRepository->update($this->getAssetCollection());
        }


        $this->persistenceManager->persistAll();

        return $contact;


    }


}
