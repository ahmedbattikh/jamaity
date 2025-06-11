<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250115130000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add slug column to opportunity table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opportunity ADD COLUMN slug VARCHAR(255) NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8389C3D7989D9B62 ON opportunity (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8389C3D7989D9B62 ON opportunity');
        $this->addSql('ALTER TABLE opportunity DROP COLUMN slug');
    }
}