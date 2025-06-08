<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250608135632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE resource (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, type VARCHAR(100) NOT NULL, document VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, files JSON DEFAULT NULL, name VARCHAR(255) NOT NULL, organization_id INT NOT NULL, UNIQUE INDEX UNIQ_BC91F416989D9B62 (slug), INDEX IDX_BC91F41632C8A3DE (organization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE resource ADD CONSTRAINT FK_BC91F41632C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE resource DROP FOREIGN KEY FK_BC91F41632C8A3DE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE resource
        SQL);
    }
}
