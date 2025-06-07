<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Expert entity table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expert (
            id INT AUTO_INCREMENT NOT NULL, 
            first_name VARCHAR(255) NOT NULL, 
            last_name VARCHAR(255) NOT NULL, 
            email VARCHAR(255) NOT NULL, 
            phone_number VARCHAR(20) NOT NULL, 
            linkedin VARCHAR(255) DEFAULT NULL, 
            description LONGTEXT DEFAULT NULL, 
            slug VARCHAR(255) NOT NULL, 
            birthday DATE DEFAULT NULL, 
            gender VARCHAR(10) DEFAULT NULL, 
            resume VARCHAR(255) DEFAULT NULL, 
            professional_experience JSON DEFAULT NULL, 
            training JSON DEFAULT NULL, 
            UNIQUE INDEX UNIQ_E5D8DDBEE7927C74 (email), 
            UNIQUE INDEX UNIQ_E5D8DDBE989D9B62 (slug), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE expert_organization (
            expert_id INT NOT NULL, 
            organization_id INT NOT NULL, 
            INDEX IDX_8B8B5CFAC5568CE4 (expert_id), 
            INDEX IDX_8B8B5CFA32C8A3DE (organization_id), 
            PRIMARY KEY(expert_id, organization_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        $this->addSql('ALTER TABLE expert_organization ADD CONSTRAINT FK_8B8B5CFAC5568CE4 FOREIGN KEY (expert_id) REFERENCES expert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE expert_organization ADD CONSTRAINT FK_8B8B5CFA32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expert_organization DROP FOREIGN KEY FK_8B8B5CFAC5568CE4');
        $this->addSql('ALTER TABLE expert_organization DROP FOREIGN KEY FK_8B8B5CFA32C8A3DE');
        $this->addSql('DROP TABLE expert');
        $this->addSql('DROP TABLE expert_organization');
    }
}