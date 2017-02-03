<?php
namespace PHLU\Neos\Models\Domain\Repository;

/*
 * This file is part of the PHLU.Neos.Models package.
 */

use PHLU\Neos\Models\Domain\Model\Contact;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;
use TYPO3\Flow\Persistence\QueryInterface;

/**
 * @Flow\Scope("singleton")
 */
class ContactRepository extends Repository
{


    /**
     * @param $eventoId
     * @return \TYPO3\Flow\Persistence\QueryInterface
     */
    public function getOneByEventoId($eventoId) {


        $query = $this->createQuery();

        return $query->matching($query->equals('eventoid', $eventoId))->execute()->getFirst();


    }


    /**
     * @param array collection of $organisationID ppdb
     * @param boolean $recursive
     * @return array
     */
    public function getByOrganisationIds($organisationIDs,$recursive = true) {


        $contacts = array();

        if (!$organisationIDs) {
            return $contacts;
        }

        foreach ($this->findAll() as $contact) {

            /* @var Contact $contact */


            $contactOrganisationIds = array();
            if (is_array($contact->getOrganisations())) {
                foreach ($contact->getOrganisations() as $organisation) {
                    array_push($contactOrganisationIds, $organisation['OrganisationId']);
                    if ($recursive) {
                        if (is_array($organisation['OrganisationPath'])) {
                            foreach ($organisation['OrganisationPath'] as $suborganisation) {
                                if (isset($suborganisation['id'])) {
                                    array_push($contactOrganisationIds, $suborganisation['id']);
                                }
                            }
                        }
                    }
                }
            }

            $found = false;
            if (count($contactOrganisationIds)) {

            }
            foreach ($organisationIDs as $o) {
                if ($found == false && in_array($o,$contactOrganisationIds)) {
                    $found = true;
                }
            }

            if ($found) {
                $contacts[$contact->getEventoid()] = $contact;
            }


        }

        return $contacts;


    }

    /**
     * @param string $organisationId from ppdb
     * @return array
     */
    public function getOrganisations($organisationId) {



        $contacts = $this->getByOrganisationIds(array($organisationId));
        $organisations = array();

        foreach ($contacts as $contact) {
            /* @var Contact $contact */
            foreach ($contact->getOrganisations() as $org) {

                if ($org['OrganisationId'] == $organisationId) {
                    $organisations[$org['OrganisationId']] =  array('issuborg' => false,'name' => $org['OrganisationName'],'id' => $org['OrganisationId'],'code' => $org['OrganisationCode']);
                } else {
                    if (isset($org['OrganisationPath'])) {

                        foreach ($org['OrganisationPath'] as $suborg) {
                            if ($suborg['id'] == $organisationId) {
                                $organisations[$org['OrganisationId']] =  array('issuborg' => true,'name' => $org['OrganisationName'],'id' => $org['OrganisationId'],'code' => $org['OrganisationCode']);
                            }
                        }

                    }
                }

            }
        }

        return $organisations;


    }

    /**
     * @return \TYPO3\Flow\Persistence\QueryInterface
     */
    public function findAllOrderedByName() {


        $query = $this->createQuery();

        return $query->matching($query->greaterThan('eventoid',0))->setOrderings(array('name.lastName' => QueryInterface::ORDER_ASCENDING))->execute();


    }

    /**
     * @param string $emailpart part before @ from email address
     * @return \TYPO3\Flow\Persistence\QueryInterface
     */
    public function getOneByEmailPart($emailpart) {


        $query = $this->createQuery();

        return $query->matching($query->like('email',$emailpart."%"))->execute()->getFirst();


    }

    

}
