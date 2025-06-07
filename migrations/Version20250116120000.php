<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add area_of_expertise and region fields to expert table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expert ADD area_of_expertise VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE expert ADD region VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expert DROP area_of_expertise');
        $this->addSql('ALTER TABLE expert DROP region');
    }
}