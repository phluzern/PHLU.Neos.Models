<?php
namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs! This block will be used as the migration description if getDescription() is not used.
 */
class Version20170410075218 extends AbstractMigration
{

    /**
     * @return string
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on "mysql".');
        
        $this->addSql('CREATE TABLE phlu_neos_models_domain_model_contact (persistence_object_identifier VARCHAR(40) NOT NULL, name VARCHAR(40) DEFAULT NULL, image VARCHAR(40) DEFAULT NULL, eventoid INT NOT NULL, street VARCHAR(255) DEFAULT NULL, streetnote VARCHAR(255) DEFAULT NULL, streetno VARCHAR(255) DEFAULT NULL, zip VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, function LONGTEXT DEFAULT NULL, links LONGTEXT DEFAULT NULL, education LONGTEXT DEFAULT NULL, honorific LONGTEXT DEFAULT NULL, activities LONGTEXT DEFAULT NULL, expertise LONGTEXT DEFAULT NULL, functions LONGTEXT DEFAULT NULL, consulting LONGTEXT DEFAULT NULL, publications LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', projects LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', organisations LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', achievements LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', showportrait TINYINT(1) NOT NULL, showportraitimage TINYINT(1) NOT NULL, haschanges TINYINT(1) NOT NULL, hash VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_BDB2B455E237E06 (name), UNIQUE INDEX UNIQ_BDB2B45C53D045F (image), PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phlu_neos_models_domain_model_course_module_furthereducat_22bcb (persistence_object_identifier VARCHAR(40) NOT NULL, deleted TINYINT(1) NOT NULL, title LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, nr LONGTEXT DEFAULT NULL, ects INT DEFAULT NULL, fee DOUBLE PRECISION DEFAULT NULL, leaders LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', contacts LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', targetgroups LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', sections LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', years LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', genre LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', start DATETIME DEFAULT NULL, isinstock TINYINT(1) DEFAULT NULL, isempfohlen TINYINT(1) DEFAULT NULL, islastminute TINYINT(1) DEFAULT NULL, isneuste TINYINT(1) DEFAULT NULL, lessons LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', id INT NOT NULL, haschanges TINYINT(1) NOT NULL, hash VARCHAR(255) NOT NULL, PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phlu_neos_models_domain_model_course_study_furthereducati_b99a3 (persistence_object_identifier VARCHAR(40) NOT NULL, graduation VARCHAR(255) NOT NULL, targetgroupsmodules LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', deleted TINYINT(1) NOT NULL, title LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, nr LONGTEXT DEFAULT NULL, ects INT DEFAULT NULL, fee DOUBLE PRECISION DEFAULT NULL, leaders LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', contacts LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', targetgroups LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', sections LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', years LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', genre LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', start DATETIME DEFAULT NULL, isinstock TINYINT(1) DEFAULT NULL, isempfohlen TINYINT(1) DEFAULT NULL, islastminute TINYINT(1) DEFAULT NULL, isneuste TINYINT(1) DEFAULT NULL, lessons LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', id INT NOT NULL, haschanges TINYINT(1) NOT NULL, hash VARCHAR(255) NOT NULL, PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phlu_neos_models_domain_model_project (persistence_object_identifier VARCHAR(40) NOT NULL, id INT NOT NULL, projecttype VARCHAR(255) DEFAULT NULL, ppdbstatus VARCHAR(255) DEFAULT NULL, ppdbstatuslifetime VARCHAR(255) DEFAULT NULL, titlegerman VARCHAR(255) DEFAULT NULL, titleenglish LONGTEXT DEFAULT NULL, teasertextgerman LONGTEXT DEFAULT NULL, teasertextenglish LONGTEXT DEFAULT NULL, abstracttextgerman LONGTEXT DEFAULT NULL, abstracttextenglish LONGTEXT DEFAULT NULL, researchmainfocus LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', researchunit LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', organisationunits LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', publications LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', financingtypes LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', photos LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', documents LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', links LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', participants LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', participantsextern LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', participantsintern LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', financiersexternal LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', partnersexternal LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', startdate DATETIME DEFAULT NULL, enddate DATETIME DEFAULT NULL, lastmodify DATETIME DEFAULT NULL, haschanges TINYINT(1) NOT NULL, hash VARCHAR(255) NOT NULL, PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phlu_neos_models_domain_model_publication (persistence_object_identifier VARCHAR(40) NOT NULL, id INT NOT NULL, citationstyle LONGTEXT DEFAULT NULL, url LONGTEXT DEFAULT NULL, title LONGTEXT DEFAULT NULL, language VARCHAR(255) DEFAULT NULL, projects LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', organisations LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', date DATETIME DEFAULT NULL, publicationtype LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', persons LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', haschanges TINYINT(1) NOT NULL, hash VARCHAR(255) NOT NULL, PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phlu_qmpilot_domain_model_qmpilot (persistence_object_identifier VARCHAR(40) NOT NULL, objectid INT NOT NULL, documentid INT NOT NULL, sha1 VARCHAR(40) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, filename VARCHAR(255) DEFAULT NULL, keywords LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', folders LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', public TINYINT(1) NOT NULL, haschanges TINYINT(1) NOT NULL, hash VARCHAR(255) NOT NULL, PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE phlu_neos_models_domain_model_contact ADD CONSTRAINT FK_BDB2B455E237E06 FOREIGN KEY (name) REFERENCES neos_party_domain_model_personname (persistence_object_identifier)');
        $this->addSql('ALTER TABLE phlu_neos_models_domain_model_contact ADD CONSTRAINT FK_BDB2B45C53D045F FOREIGN KEY (image) REFERENCES neos_media_domain_model_image (persistence_object_identifier)');
        $this->addSql('ALTER TABLE neos_flow_resourcemanagement_persistentresource ADD qmpilot VARCHAR(40) DEFAULT NULL, ADD link LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE neos_flow_resourcemanagement_persistentresource ADD CONSTRAINT FK_6954B1F62825B02A FOREIGN KEY (qmpilot) REFERENCES phlu_qmpilot_domain_model_qmpilot (persistence_object_identifier)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6954B1F62825B02A ON neos_flow_resourcemanagement_persistentresource (qmpilot)');
        $this->addSql('ALTER TABLE neos_media_domain_model_asset ADD hidden TINYINT(1) DEFAULT NULL, ADD keywords VARCHAR(255) DEFAULT NULL, ADD searchindex LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE neos_media_domain_model_assetcollection ADD hidden TINYINT(1) DEFAULT NULL');
        $this->addSql('DROP INDEX sourceuripathhash ON neos_redirecthandler_databasestorage_domain_model_redirect');
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on "mysql".');
        
        $this->addSql('ALTER TABLE neos_flow_resourcemanagement_persistentresource DROP FOREIGN KEY FK_6954B1F62825B02A');
        $this->addSql('DROP TABLE phlu_neos_models_domain_model_contact');
        $this->addSql('DROP TABLE phlu_neos_models_domain_model_course_module_furthereducat_22bcb');
        $this->addSql('DROP TABLE phlu_neos_models_domain_model_course_study_furthereducati_b99a3');
        $this->addSql('DROP TABLE phlu_neos_models_domain_model_project');
        $this->addSql('DROP TABLE phlu_neos_models_domain_model_publication');
        $this->addSql('DROP TABLE phlu_qmpilot_domain_model_qmpilot');
        $this->addSql('DROP INDEX UNIQ_6954B1F62825B02A ON neos_flow_resourcemanagement_persistentresource');
        $this->addSql('ALTER TABLE neos_flow_resourcemanagement_persistentresource DROP qmpilot, DROP link');
        $this->addSql('ALTER TABLE neos_media_domain_model_asset DROP hidden, DROP keywords, DROP searchindex');
        $this->addSql('ALTER TABLE neos_media_domain_model_assetcollection DROP hidden');
        $this->addSql('CREATE INDEX sourceuripathhash ON neos_redirecthandler_databasestorage_domain_model_redirect (sourceuripathhash, host)');
    }
}