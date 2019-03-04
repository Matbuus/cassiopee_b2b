<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190304114814 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE localisation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL)');
        $this->addSql('DROP INDEX IDX_BFE0290E9E13E9F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__type_evenement AS SELECT id, portail_b2b_id, nom FROM type_evenement');
        $this->addSql('DROP TABLE type_evenement');
        $this->addSql('CREATE TABLE type_evenement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portail_b2b_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_BFE0290E9E13E9F5 FOREIGN KEY (portail_b2b_id) REFERENCES portail_b2b (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO type_evenement (id, portail_b2b_id, nom) SELECT id, portail_b2b_id, nom FROM __temp__type_evenement');
        $this->addSql('DROP TABLE __temp__type_evenement');
        $this->addSql('CREATE INDEX IDX_BFE0290E9E13E9F5 ON type_evenement (portail_b2b_id)');
        $this->addSql('DROP INDEX IDX_51A00D8C9E13E9F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__metier AS SELECT id, portail_b2b_id, titre FROM metier');
        $this->addSql('DROP TABLE metier');
        $this->addSql('CREATE TABLE metier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portail_b2b_id INTEGER DEFAULT NULL, titre VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_51A00D8C9E13E9F5 FOREIGN KEY (portail_b2b_id) REFERENCES portail_b2b (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO metier (id, portail_b2b_id, titre) SELECT id, portail_b2b_id, titre FROM __temp__metier');
        $this->addSql('DROP TABLE __temp__metier');
        $this->addSql('CREATE INDEX IDX_51A00D8C9E13E9F5 ON metier (portail_b2b_id)');
        $this->addSql('DROP INDEX IDX_C74404559E13E9F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, portail_b2b_id, nom, prenom FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portail_b2b_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL COLLATE BINARY, prenom VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_C74404559E13E9F5 FOREIGN KEY (portail_b2b_id) REFERENCES portail_b2b (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO client (id, portail_b2b_id, nom, prenom) SELECT id, portail_b2b_id, nom, prenom FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE INDEX IDX_C74404559E13E9F5 ON client (portail_b2b_id)');
        $this->addSql('DROP INDEX IDX_B26681E9E13E9F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__evenement AS SELECT id, portail_b2b_id, titre, date FROM evenement');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('CREATE TABLE evenement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portail_b2b_id INTEGER DEFAULT NULL, titre VARCHAR(255) NOT NULL COLLATE BINARY, date DATE NOT NULL, CONSTRAINT FK_B26681E9E13E9F5 FOREIGN KEY (portail_b2b_id) REFERENCES portail_b2b (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO evenement (id, portail_b2b_id, titre, date) SELECT id, portail_b2b_id, titre, date FROM __temp__evenement');
        $this->addSql('DROP TABLE __temp__evenement');
        $this->addSql('CREATE INDEX IDX_B26681E9E13E9F5 ON evenement (portail_b2b_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP INDEX IDX_C74404559E13E9F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, portail_b2b_id, nom, prenom FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portail_b2b_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO client (id, portail_b2b_id, nom, prenom) SELECT id, portail_b2b_id, nom, prenom FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE INDEX IDX_C74404559E13E9F5 ON client (portail_b2b_id)');
        $this->addSql('DROP INDEX IDX_B26681E9E13E9F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__evenement AS SELECT id, portail_b2b_id, titre, date FROM evenement');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('CREATE TABLE evenement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portail_b2b_id INTEGER DEFAULT NULL, titre VARCHAR(255) NOT NULL, date DATE NOT NULL)');
        $this->addSql('INSERT INTO evenement (id, portail_b2b_id, titre, date) SELECT id, portail_b2b_id, titre, date FROM __temp__evenement');
        $this->addSql('DROP TABLE __temp__evenement');
        $this->addSql('CREATE INDEX IDX_B26681E9E13E9F5 ON evenement (portail_b2b_id)');
        $this->addSql('DROP INDEX IDX_51A00D8C9E13E9F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__metier AS SELECT id, portail_b2b_id, titre FROM metier');
        $this->addSql('DROP TABLE metier');
        $this->addSql('CREATE TABLE metier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portail_b2b_id INTEGER DEFAULT NULL, titre VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO metier (id, portail_b2b_id, titre) SELECT id, portail_b2b_id, titre FROM __temp__metier');
        $this->addSql('DROP TABLE __temp__metier');
        $this->addSql('CREATE INDEX IDX_51A00D8C9E13E9F5 ON metier (portail_b2b_id)');
        $this->addSql('DROP INDEX IDX_BFE0290E9E13E9F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__type_evenement AS SELECT id, portail_b2b_id, nom FROM type_evenement');
        $this->addSql('DROP TABLE type_evenement');
        $this->addSql('CREATE TABLE type_evenement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portail_b2b_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO type_evenement (id, portail_b2b_id, nom) SELECT id, portail_b2b_id, nom FROM __temp__type_evenement');
        $this->addSql('DROP TABLE __temp__type_evenement');
        $this->addSql('CREATE INDEX IDX_BFE0290E9E13E9F5 ON type_evenement (portail_b2b_id)');
    }
}
