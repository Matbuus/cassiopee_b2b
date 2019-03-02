<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190302100439 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE prestation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL)');
        $this->addSql('CREATE TABLE portail_b2b (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE partenaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('CREATE TABLE metier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE evenement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, date DATE NOT NULL)');
        $this->addSql('CREATE TABLE type_prestation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_type VARCHAR(255) NOT NULL, description CLOB NOT NULL, tarif_public DOUBLE PRECISION NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE prestation');
        $this->addSql('DROP TABLE portail_b2b');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE metier');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE type_prestation');
    }
}
