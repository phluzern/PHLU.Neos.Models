<?php
namespace Phlu\Neos\Models\Domain\Repository;

/*
 * This file is part of the Phlu.Neos.Models package.
 */

use Phlu\Neos\Models\Domain\Model\Contact;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;
use Neos\Flow\Persistence\QueryInterface;

/**
 * @Flow\Scope("singleton")
 */
class ContactRepository extends Repository
{


    /**
     * @param $eventoId
     * @return \Neos\Flow\Persistence\QueryInterface
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

        $query = $this->createQuery();
        $query->setOrderings(array('name.lastName' => QueryInterface::ORDER_ASCENDING));


        foreach ($query->execute() as $contact) {

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

                    $organisations[$org['OrganisationId']] =  array('orderingkey' => $org['orderingkey'], 'issuborg' => false,'name' => $org['OrganisationName'],'id' => $org['OrganisationId'],'code' => isset($org['OrganisationCode']) ? $org['OrganisationCode'] : $org['OrganisationId']);
                } else {
                    if (isset($org['OrganisationPath'])) {

                        foreach ($org['OrganisationPath'] as $suborg) {
                            if ($suborg['id'] == $organisationId) {
                                $organisations[$org['OrganisationId']] =  array('orderingkey' => $org['orderingkey'], 'issuborg' => true,'name' => $org['OrganisationName'],'id' => $org['OrganisationId'],'code' => isset($org['OrganisationCode']) ? $org['OrganisationCode'] : $org['OrganisationId']);
                            }
                        }

                    }
                }

            }
        }

        return $organisations;


    }

    /**
     * @return \Neos\Flow\Persistence\QueryInterface
     */
    public function findAllOrderedByName() {


        $query = $this->createQuery();

        return $query->matching($query->greaterThan('eventoid',0))->setOrderings(array('name.lastName' => QueryInterface::ORDER_ASCENDING))->execute();


    }

    /**
     * @param string $emailpart part before @ from email address
     * @return \Neos\Flow\Persistence\QueryInterface
     */
    public function getOneByEmailPart($emailpart) {

        $query = $this->createQuery();

        return $query->matching($query->like('email',$emailpart."@%"))->execute()->getFirst();


    }

    

}
