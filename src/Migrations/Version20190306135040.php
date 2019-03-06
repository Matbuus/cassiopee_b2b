<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190306135040 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_BFE0290E9E13E9F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__type_evenement AS SELECT id, portail_b2b_id, nom FROM type_evenement');
        $this->addSql('DROP TABLE type_evenement');
        $this->addSql('CREATE TABLE type_evenement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portail_b2b_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_BFE0290E9E13E9F5 FOREIGN KEY (portail_b2b_id) REFERENCES portail_b2b (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO type_evenement (id, portail_b2b_id, nom) SELECT id, portail_b2b_id, nom FROM __temp__type_evenement');
        $this->addSql('DROP TABLE __temp__type_evenement');
        $this->addSql('CREATE INDEX IDX_BFE0290E9E13E9F5 ON type_evenement (portail_b2b_id)');
        $this->addSql('DROP INDEX IDX_C74404559E13E9F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, portail_b2b_id, nom, prenom FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portail_b2b_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL COLLATE BINARY, prenom VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_C74404559E13E9F5 FOREIGN KEY (portail_b2b_id) REFERENCES portail_b2b (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO client (id, portail_b2b_id, nom, prenom) SELECT id, portail_b2b_id, nom, prenom FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE INDEX IDX_C74404559E13E9F5 ON client (portail_b2b_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__partenaire AS SELECT id, nom, prenom FROM partenaire');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('CREATE TABLE partenaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, prestation_proposee_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL COLLATE BINARY, prenom VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_32FFA3732E4D1423 FOREIGN KEY (prestation_proposee_id) REFERENCES prestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO partenaire (id, nom, prenom) SELECT id, nom, prenom FROM __temp__partenaire');
        $this->addSql('DROP TABLE __temp__partenaire');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_32FFA3732E4D1423 ON partenaire (prestation_proposee_id)');
        $this->addSql('DROP INDEX IDX_51A00D8C9E13E9F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__metier AS SELECT id, portail_b2b_id, titre FROM metier');
        $this->addSql('DROP TABLE metier');
        $this->addSql('CREATE TABLE metier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portail_b2b_id INTEGER DEFAULT NULL, partenaires_id INTEGER DEFAULT NULL, titre VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_51A00D8C9E13E9F5 FOREIGN KEY (portail_b2b_id) REFERENCES portail_b2b (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_51A00D8C38898CF5 FOREIGN KEY (partenaires_id) REFERENCES partenaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO metier (id, portail_b2b_id, titre) SELECT id, portail_b2b_id, titre FROM __temp__metier');
        $this->addSql('DROP TABLE __temp__metier');
        $this->addSql('CREATE INDEX IDX_51A00D8C9E13E9F5 ON metier (portail_b2b_id)');
        $this->addSql('CREATE INDEX IDX_51A00D8C38898CF5 ON metier (partenaires_id)');
        $this->addSql('DROP INDEX IDX_B26681E9E13E9F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__evenement AS SELECT id, portail_b2b_id, titre, date FROM evenement');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('CREATE TABLE evenement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portail_b2b_id INTEGER DEFAULT NULL, titre VARCHAR(255) NOT NULL COLLATE BINARY, date DATE NOT NULL, CONSTRAINT FK_B26681E9E13E9F5 FOREIGN KEY (portail_b2b_id) REFERENCES portail_b2b (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO evenement (id, portail_b2b_id, titre, date) SELECT id, portail_b2b_id, titre, date FROM __temp__evenement');
        $this->addSql('DROP TABLE __temp__evenement');
        $this->addSql('CREATE INDEX IDX_B26681E9E13E9F5 ON evenement (portail_b2b_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__type_prestation AS SELECT id, nom_type, description, tarif_public FROM type_prestation');
        $this->addSql('DROP TABLE type_prestation');
        $this->addSql('CREATE TABLE type_prestation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, metier_id INTEGER DEFAULT NULL, partenaire_id INTEGER DEFAULT NULL, nom_type VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, tarif_public DOUBLE PRECISION NOT NULL, CONSTRAINT FK_4CCB5988ED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4CCB598898DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO type_prestation (id, nom_type, description, tarif_public) SELECT id, nom_type, description, tarif_public FROM __temp__type_prestation');
        $this->addSql('DROP TABLE __temp__type_prestation');
        $this->addSql('CREATE INDEX IDX_4CCB5988ED16FA20 ON type_prestation (metier_id)');
        $this->addSql('CREATE INDEX IDX_4CCB598898DE13AC ON type_prestation (partenaire_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

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
        $this->addSql('DROP INDEX IDX_51A00D8C38898CF5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__metier AS SELECT id, portail_b2b_id, titre FROM metier');
        $this->addSql('DROP TABLE metier');
        $this->addSql('CREATE TABLE metier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portail_b2b_id INTEGER DEFAULT NULL, titre VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO metier (id, portail_b2b_id, titre) SELECT id, portail_b2b_id, titre FROM __temp__metier');
        $this->addSql('DROP TABLE __temp__metier');
        $this->addSql('CREATE INDEX IDX_51A00D8C9E13E9F5 ON metier (portail_b2b_id)');
        $this->addSql('DROP INDEX UNIQ_32FFA3732E4D1423');
        $this->addSql('CREATE TEMPORARY TABLE __temp__partenaire AS SELECT id, nom, prenom FROM partenaire');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('CREATE TABLE partenaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO partenaire (id, nom, prenom) SELECT id, nom, prenom FROM __temp__partenaire');
        $this->addSql('DROP TABLE __temp__partenaire');
        $this->addSql('DROP INDEX IDX_BFE0290E9E13E9F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__type_evenement AS SELECT id, portail_b2b_id, nom FROM type_evenement');
        $this->addSql('DROP TABLE type_evenement');
        $this->addSql('CREATE TABLE type_evenement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portail_b2b_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO type_evenement (id, portail_b2b_id, nom) SELECT id, portail_b2b_id, nom FROM __temp__type_evenement');
        $this->addSql('DROP TABLE __temp__type_evenement');
        $this->addSql('CREATE INDEX IDX_BFE0290E9E13E9F5 ON type_evenement (portail_b2b_id)');
        $this->addSql('DROP INDEX IDX_4CCB5988ED16FA20');
        $this->addSql('DROP INDEX IDX_4CCB598898DE13AC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__type_prestation AS SELECT id, nom_type, description, tarif_public FROM type_prestation');
        $this->addSql('DROP TABLE type_prestation');
        $this->addSql('CREATE TABLE type_prestation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_type VARCHAR(255) NOT NULL, description CLOB NOT NULL, tarif_public DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO type_prestation (id, nom_type, description, tarif_public) SELECT id, nom_type, description, tarif_public FROM __temp__type_prestation');
        $this->addSql('DROP TABLE __temp__type_prestation');
    }
}
