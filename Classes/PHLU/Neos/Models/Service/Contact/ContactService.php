<?php
namespace PHLU\Neos\Models\Service\Contact;

/*
 * This file is part of the PHLU.Neos.Models package.
 */

use PHLU\Neos\Models\Domain\Model\Contact;
use PHLU\Neos\Models\Domain\Model\PersonName;
use PHLU\Neos\Models\Domain\Repository\ContactRepository;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Media\Domain\Repository\ImageRepository;
use TYPO3\Media\Domain\Service\ImageService;

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
        'eventoId' => 0
    );


    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Resource\ResourceManager
     */
    protected $resourceManager;


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
     * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
     */
    protected $persistenceManager;


    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Http\Client\CurlEngine
     */
    protected $browserRequestEngine;

    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Http\Client\Browser
     */
    protected $browser;


    /**
     * Returns a contact model
     *
     * @param array $data
     *
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

                $resource = $this->resourceManager->importResourceFromContent($response->getContent(), basename($data['_imageUrl']));

                if ($resource) {
                    if ($resource->getMediaType() === 'image/jpeg') {

                        $validImage = true;
                        try {
                            $this->imagineService->read($resource->getStream());
                        } catch (\Exception $e) {
                            $validImage = false;
                        }

                        if ($validImage) {
                            if ($contact->getImage()) {
                                $contact->getImage()->setResource($resource);
                                $contact->getImage()->refresh();
                                $contact->getImage()->setTitle($contact->getName()->getFullName());
                                $contact->getImage()->setCaption($contact->getEventoid());
                            } else {
                                $image = new \TYPO3\Media\Domain\Model\Image($resource);
                                if ($image) {
                                    $image->setTitle($contact->getName()->getFullName());
                                    $image->setCaption($contact->getEventoid());
                                    $contact->setImage($image);
                                }
                            }

                        }





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


        if ($contact->isPersisted()) {
            if ($contact->isHasChanges()) {
                $contact->setHasChanges(false);
                $this->contactRepository->update($contact);
            }
        } else {
            $this->contactRepository->add($contact);
        }


        $this->persistenceManager->persistAll();

        return $contact;


    }


}
