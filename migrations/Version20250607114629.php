<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250607114629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, date_begin DATE NOT NULL, date_end DATE NOT NULL, logo VARCHAR(255) DEFAULT NULL, general_objective LONGTEXT NOT NULL, more_details LONGTEXT DEFAULT NULL, specific_objectives JSON DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, region JSON DEFAULT NULL, UNIQUE INDEX UNIQ_2FB3D0EE989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE project_organization (project_id INT NOT NULL, organization_id INT NOT NULL, INDEX IDX_EB49871F166D1F9C (project_id), INDEX IDX_EB49871F32C8A3DE (organization_id), PRIMARY KEY(project_id, organization_id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_organization ADD CONSTRAINT FK_EB49871F166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_organization ADD CONSTRAINT FK_EB49871F32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expert RENAME INDEX uniq_e5d8ddbee7927c74 TO UNIQ_4F1B9342E7927C74
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expert RENAME INDEX uniq_e5d8ddbe989d9b62 TO UNIQ_4F1B9342989D9B62
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expert_organization RENAME INDEX idx_8b8b5cfac5568ce4 TO IDX_BF436A7BC5568CE4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expert_organization RENAME INDEX idx_8b8b5cfa32c8a3de TO IDX_BF436A7B32C8A3DE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE project_organization DROP FOREIGN KEY FK_EB49871F166D1F9C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_organization DROP FOREIGN KEY FK_EB49871F32C8A3DE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE project
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE project_organization
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expert_organization RENAME INDEX idx_bf436a7b32c8a3de TO IDX_8B8B5CFA32C8A3DE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expert_organization RENAME INDEX idx_bf436a7bc5568ce4 TO IDX_8B8B5CFAC5568CE4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expert RENAME INDEX uniq_4f1b9342989d9b62 TO UNIQ_E5D8DDBE989D9B62
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expert RENAME INDEX uniq_4f1b9342e7927c74 TO UNIQ_E5D8DDBEE7927C74
        SQL);
    }
}
