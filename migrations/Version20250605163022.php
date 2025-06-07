<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250605163022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE association ADD last_update_date DATETIME DEFAULT NULL, DROP adresse, DROP email, DROP telephone
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE coalition ADD last_update_date DATETIME DEFAULT NULL, ADD president VARCHAR(255) DEFAULT NULL, ADD structure VARCHAR(100) DEFAULT NULL, DROP adresse, DROP email, DROP telephone
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE organization ADD telephone VARCHAR(20) DEFAULT NULL, ADD mobile VARCHAR(20) DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD adresse LONGTEXT DEFAULT NULL, ADD region VARCHAR(255) DEFAULT NULL, ADD date_fondation DATE DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ptf ADD particularites JSON DEFAULT NULL, ADD mecanisme JSON DEFAULT NULL, DROP adresse, DROP email
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE association ADD adresse VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD telephone VARCHAR(20) NOT NULL, DROP last_update_date
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE coalition ADD email VARCHAR(255) DEFAULT NULL, ADD telephone VARCHAR(20) DEFAULT NULL, DROP last_update_date, DROP structure, CHANGE president adresse VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE organization DROP telephone, DROP mobile, DROP email, DROP adresse, DROP region, DROP date_fondation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ptf ADD adresse VARCHAR(255) DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL, DROP particularites, DROP mecanisme
        SQL);
    }
}
