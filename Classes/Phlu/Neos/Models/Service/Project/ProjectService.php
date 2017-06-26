<?php
namespace Phlu\Neos\Models\Service\Project;

/*
 * This file is part of the Phlu.Neos.Models package.
 */


use Phlu\Neos\Models\Domain\Model\Project;
use Phlu\Neos\Models\Domain\Repository\ProjectRepository;
use Neos\Flow\Annotations as Flow;


class ProjectService
{

    protected $defaultData = array(
        'PPDBStatus' => '',
        'PPDBStatus' => '',
        'pPDBStatusLifetime' => 'laufend',
        'TitleGerman' => '',
        'TitleEnglish' => '',
        'TeaserTextGerman' => '',
        'TeaserTextEnglish' => '',
        'AbstractTextGerman' => '',
        'AbstractTextEnglish' => '',
        'ResearchMainFocus' => array(),
        'ResearchUnit' => array(),
        'OrganisationUnits' => array(),
        'FinancingTypes' => array(),
        'Photos' => array(),
        'Documents' => array(),
        'Links' => array(),
        'StartDate' => '',
        'EndDate' => '',
        'LastModify' => '',
        'ProjectType' => '',
        'Participants' => array(),
        'ExternProjectPartners' => array(),
        'ExternProjectFinanciers' => array(),
    );


    /**
     * @Flow\Inject
     * @var ProjectRepository
     */
    protected $projectRepository;


    /**
     * @Flow\Inject
     * @var \Neos\Flow\Persistence\PersistenceManagerInterface
     */
    protected $persistenceManager;


    /**
     * Returns a project model
     *
     * @param array $data
     * @return Project
     * @api
     */
    public function getModel($data)
    {



        // set default values
        foreach ($this->defaultData as $key => $val) {
            if (isset($data[$key]) === false) $data[$key] = $val;
        }

        $hash = sha1(json_encode($data));

        $project = $this->projectRepository->getOneByPpDbId($data['ID']);

        if ($project === null) $project = new Project();


        $project->setId($data['ID']);
        $project->setPPDBStatus($data['PPDBStatus']);
        $project->setTitleGerman($data['TitleGerman'] !== '' ? $data['TitleGerman'] : $data['TitleEnglish']);
        $project->setTitleEnglish($data['TitleEnglish']);
        $project->setTeaserTextGerman($data['TeaserTextGerman'] !== '' ? $data['TeaserTextGerman'] : $data['TeaserTextEnglish']);
        $project->setTeaserTextEnglish($data['TeaserTextEnglish']);
        $project->setAbstractTextGerman($data['AbstractTextGerman'] !== '' ? $data['AbstractTextGerman'] : $data['AbstractTextEnglish']);
        $project->setAbstractTextEnglish($data['AbstractTextEnglish']);
        $project->setResearchMainFocus($data['ResearchMainFocus']);
        $project->setResearchUnit($data['ResearchUnit']);
        $project->setOrganisationUnits($data['OrganisationUnits']);
        $project->setFinancingTypes($data['FinancingTypes']);
        $project->setProjectType($data['ProjectType']);
        $project->setPhotos($data['Photos']);
        $project->setDocuments($data['Documents']);
        $project->setPartnersExternal($data['ExternProjectPartners']);
        $project->setFinanciersExternal($data['ExternProjectFinanciers']);

        $project->setParticipants($data['Participants']);

        $participantsIntern = array();
        $i = 0;
        foreach ($data['Participants'] as $functionName => $participants) {
            foreach ($participants as $participant) {
                 if ($participant['EventoID'] > 0) {
                    $participantsIntern[$functionName][$i] = $participant;
                    $i++;
                }
            }
        }



        $project->setParticipantsIntern($participantsIntern);

        $participantsExtern = array();
        $i = 0;
        foreach ($data['Participants'] as $functionName => $participants) {
            foreach ($participants as $participant) {
                if (!$participant['EventoID']) {
                    $participantsExtern[$functionName][$i] = $participant;
                    $i++;
                }
            }
        }

        $project->setParticipantsExtern($participantsExtern);


        $project->setPublications($data['Publications']);
        $project->setLinks($data['Links']);
        $project->setStartDate(is_object($data['StartDate']) ? $data['StartDate'] : new \DateTime());
        $project->setEndDate(is_object($data['EndDate']) ? $data['EndDate'] : new \DateTime());
        $project->setLastModify(is_object($data['LastModify']) ? $data['LastModify'] : new \DateTime());
        $project->setPPDBStatusLifetime($project->getEndDate()->getTimestamp() > time() ? 'laufend' : 'abgeschlossen');

        $project->setHasChanges($project->getHash() === $hash ? false : true);
        $project->setHash($hash);


        return $project;


    }


    /**
     * Creates or updates a project
     * @param Project $project
     * @return Project persisted project
     * @api
     */
    public
    function createOrUpdateProject(Project $project)
    {


        if ($this->persistenceManager->isNewObject($project) === false) {
            if ($project->isHasChanges()) {
                $project->setHasChanges(false);
                $this->projectRepository->update($project);
            }
        } else {
            $this->projectRepository->add($project);
        }


        $this->persistenceManager->persistAll();

        return $project;


    }


}
