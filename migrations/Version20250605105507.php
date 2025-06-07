<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250605105507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE association (titre VARCHAR(255) NOT NULL, numero_jort VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) NOT NULL, abreviation VARCHAR(100) DEFAULT NULL, lieux VARCHAR(255) DEFAULT NULL, president VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, telephone2 VARCHAR(20) NOT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, google VARCHAR(255) DEFAULT NULL, annee_fondation INT NOT NULL, site_web VARCHAR(255) DEFAULT NULL, structure VARCHAR(100) NOT NULL, domaine VARCHAR(100) NOT NULL, description_presentation LONGTEXT DEFAULT NULL, parent_id INT DEFAULT NULL, id INT NOT NULL, INDEX IDX_FD8521CC727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE coalition (titre VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, abreviation VARCHAR(100) DEFAULT NULL, lieux VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, telephone VARCHAR(20) DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, domaine VARCHAR(100) DEFAULT NULL, id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, date_debut DATETIME DEFAULT NULL, date_fin DATETIME DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, detail_evenement LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, statut VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE event_organization (event_id INT NOT NULL, organization_id INT NOT NULL, INDEX IDX_2CFD698F71F7E88B (event_id), INDEX IDX_2CFD698F32C8A3DE (organization_id), PRIMARY KEY(event_id, organization_id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE opportunity (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, opportunity_details LONGTEXT DEFAULT NULL, eligibility_criteria JSON DEFAULT NULL, how_to_apply LONGTEXT DEFAULT NULL, due_date DATE DEFAULT NULL, type_of_opportunities VARCHAR(255) DEFAULT NULL, regions JSON DEFAULT NULL, intervention_themes JSON DEFAULT NULL, organisme VARCHAR(255) DEFAULT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, statut VARCHAR(100) DEFAULT NULL, budget LONGTEXT DEFAULT NULL, contact_email VARCHAR(255) DEFAULT NULL, contact_telephone VARCHAR(255) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE organization (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, contact_information LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, vis_avis LONGTEXT DEFAULT NULL, coordinates LONGTEXT DEFAULT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C1EE637C989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ptf (titre VARCHAR(255) NOT NULL, annee INT DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, abreviation VARCHAR(100) DEFAULT NULL, lieux VARCHAR(255) DEFAULT NULL, mission LONGTEXT DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, telephone1 VARCHAR(20) DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, linkedin VARCHAR(255) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, priorites_strategiques LONGTEXT DEFAULT NULL, mission_theme_prioritaire LONGTEXT DEFAULT NULL, nom_contact VARCHAR(255) DEFAULT NULL, poste VARCHAR(255) DEFAULT NULL, numero_telephone_contact VARCHAR(20) DEFAULT NULL, fax VARCHAR(20) DEFAULT NULL, domaine VARCHAR(100) DEFAULT NULL, priorites JSON DEFAULT NULL, id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE association ADD CONSTRAINT FK_FD8521CC727ACA70 FOREIGN KEY (parent_id) REFERENCES association (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE association ADD CONSTRAINT FK_FD8521CCBF396750 FOREIGN KEY (id) REFERENCES organization (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE coalition ADD CONSTRAINT FK_A7CD7AC7BF396750 FOREIGN KEY (id) REFERENCES organization (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_organization ADD CONSTRAINT FK_2CFD698F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_organization ADD CONSTRAINT FK_2CFD698F32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ptf ADD CONSTRAINT FK_4432C9DDBF396750 FOREIGN KEY (id) REFERENCES organization (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE association DROP FOREIGN KEY FK_FD8521CC727ACA70
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE association DROP FOREIGN KEY FK_FD8521CCBF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE coalition DROP FOREIGN KEY FK_A7CD7AC7BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_organization DROP FOREIGN KEY FK_2CFD698F71F7E88B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_organization DROP FOREIGN KEY FK_2CFD698F32C8A3DE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ptf DROP FOREIGN KEY FK_4432C9DDBF396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE association
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE coalition
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event_organization
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE opportunity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE organization
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ptf
        SQL);
    }
}
