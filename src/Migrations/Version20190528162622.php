<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190528162622 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE type_prestation_type_evenement');
        $this->addSql('DROP INDEX IDX_B26681E19EB6921');
        $this->addSql('DROP INDEX IDX_B26681EC68BE09C');
        $this->addSql('DROP INDEX IDX_B26681E88939516');
        $this->addSql('DROP INDEX IDX_B26681E170A1CCC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__evenement AS SELECT id, client_id, localisation_id, type_evenement_id, etat_evenement_id, titre, date, lat, lng FROM evenement');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('CREATE TABLE evenement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, client_id INTEGER NOT NULL, localisation_id INTEGER NOT NULL, type_evenement_id INTEGER NOT NULL, etat_evenement_id INTEGER DEFAULT NULL, titre VARCHAR(255) NOT NULL COLLATE BINARY, date DATE NOT NULL, lat DOUBLE PRECISION NOT NULL, lng DOUBLE PRECISION NOT NULL, adress VARCHAR(255) NOT NULL, CONSTRAINT FK_B26681E19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B26681EC68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B26681E88939516 FOREIGN KEY (type_evenement_id) REFERENCES type_evenement (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B26681E170A1CCC FOREIGN KEY (etat_evenement_id) REFERENCES etat (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO evenement (id, client_id, localisation_id, type_evenement_id, etat_evenement_id, titre, date, lat, lng) SELECT id, client_id, localisation_id, type_evenement_id, etat_evenement_id, titre, date, lat, lng FROM __temp__evenement');
        $this->addSql('DROP TABLE __temp__evenement');
        $this->addSql('CREATE INDEX IDX_B26681E19EB6921 ON evenement (client_id)');
        $this->addSql('CREATE INDEX IDX_B26681EC68BE09C ON evenement (localisation_id)');
        $this->addSql('CREATE INDEX IDX_B26681E88939516 ON evenement (type_evenement_id)');
        $this->addSql('CREATE INDEX IDX_B26681E170A1CCC ON evenement (etat_evenement_id)');
        $this->addSql('DROP INDEX IDX_4CCB5988BC08CF77');
        $this->addSql('DROP INDEX IDX_4CCB5988ED16FA20');
        $this->addSql('CREATE TEMPORARY TABLE __temp__type_prestation AS SELECT id, metier_id, type_event_id, nom_type, description, tarif_public FROM type_prestation');
        $this->addSql('DROP TABLE type_prestation');
        $this->addSql('CREATE TABLE type_prestation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, metier_id INTEGER DEFAULT NULL, type_event_id INTEGER DEFAULT NULL, nom_type VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, tarif_public DOUBLE PRECISION NOT NULL, CONSTRAINT FK_4CCB5988ED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4CCB5988BC08CF77 FOREIGN KEY (type_event_id) REFERENCES type_evenement (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO type_prestation (id, metier_id, type_event_id, nom_type, description, tarif_public) SELECT id, metier_id, type_event_id, nom_type, description, tarif_public FROM __temp__type_prestation');
        $this->addSql('DROP TABLE __temp__type_prestation');
        $this->addSql('CREATE INDEX IDX_4CCB5988BC08CF77 ON type_prestation (type_event_id)');
        $this->addSql('CREATE INDEX IDX_4CCB5988ED16FA20 ON type_prestation (metier_id)');
        $this->addSql('DROP INDEX IDX_9D37606498DE13AC');
        $this->addSql('DROP INDEX IDX_9D376064EEA87261');
        $this->addSql('CREATE TEMPORARY TABLE __temp__type_prestation_partenaire AS SELECT type_prestation_id, partenaire_id FROM type_prestation_partenaire');
        $this->addSql('DROP TABLE type_prestation_partenaire');
        $this->addSql('CREATE TABLE type_prestation_partenaire (type_prestation_id INTEGER NOT NULL, partenaire_id INTEGER NOT NULL, PRIMARY KEY(type_prestation_id, partenaire_id), CONSTRAINT FK_9D376064EEA87261 FOREIGN KEY (type_prestation_id) REFERENCES type_prestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9D37606498DE13AC FOREIGN KEY (partenaire_id) REFERENCES client (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO type_prestation_partenaire (type_prestation_id, partenaire_id) SELECT type_prestation_id, partenaire_id FROM __temp__type_prestation_partenaire');
        $this->addSql('DROP TABLE __temp__type_prestation_partenaire');
        $this->addSql('CREATE INDEX IDX_9D37606498DE13AC ON type_prestation_partenaire (partenaire_id)');
        $this->addSql('CREATE INDEX IDX_9D376064EEA87261 ON type_prestation_partenaire (type_prestation_id)');
        $this->addSql('DROP INDEX IDX_C7440455ED16FA20');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, metier_id, nom, prenom, dtype FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, metier_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL COLLATE BINARY, prenom VARCHAR(255) NOT NULL COLLATE BINARY, dtype VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_C7440455ED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO client (id, metier_id, nom, prenom, dtype) SELECT id, metier_id, nom, prenom, dtype FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE INDEX IDX_C7440455ED16FA20 ON client (metier_id)');
        $this->addSql('DROP INDEX IDX_51C88FADEEA87261');
        $this->addSql('DROP INDEX IDX_51C88FAD98DE13AC');
        $this->addSql('DROP INDEX IDX_51C88FADFD02F13');
        $this->addSql('DROP INDEX IDX_51C88FAD8831D022');
        $this->addSql('CREATE TEMPORARY TABLE __temp__prestation AS SELECT id, evenement_id, partenaire_id, etat_prestation_id, type_prestation_id, date_debut, date_fin FROM prestation');
        $this->addSql('DROP TABLE prestation');
        $this->addSql('CREATE TABLE prestation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, evenement_id INTEGER NOT NULL, partenaire_id INTEGER NOT NULL, etat_prestation_id INTEGER DEFAULT NULL, type_prestation_id INTEGER NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, CONSTRAINT FK_51C88FADFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_51C88FAD98DE13AC FOREIGN KEY (partenaire_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_51C88FAD8831D022 FOREIGN KEY (etat_prestation_id) REFERENCES etat (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_51C88FADEEA87261 FOREIGN KEY (type_prestation_id) REFERENCES type_prestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO prestation (id, evenement_id, partenaire_id, etat_prestation_id, type_prestation_id, date_debut, date_fin) SELECT id, evenement_id, partenaire_id, etat_prestation_id, type_prestation_id, date_debut, date_fin FROM __temp__prestation');
        $this->addSql('DROP TABLE __temp__prestation');
        $this->addSql('CREATE INDEX IDX_51C88FADEEA87261 ON prestation (type_prestation_id)');
        $this->addSql('CREATE INDEX IDX_51C88FAD98DE13AC ON prestation (partenaire_id)');
        $this->addSql('CREATE INDEX IDX_51C88FADFD02F13 ON prestation (evenement_id)');
        $this->addSql('CREATE INDEX IDX_51C88FAD8831D022 ON prestation (etat_prestation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE partenaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, metier_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL COLLATE BINARY, prenom VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('CREATE INDEX IDX_32FFA373ED16FA20 ON partenaire (metier_id)');
        $this->addSql('CREATE TABLE type_prestation_type_evenement (type_prestation_id INTEGER NOT NULL, type_evenement_id INTEGER NOT NULL, PRIMARY KEY(type_prestation_id, type_evenement_id))');
        $this->addSql('CREATE INDEX IDX_A48D8D0E88939516 ON type_prestation_type_evenement (type_evenement_id)');
        $this->addSql('CREATE INDEX IDX_A48D8D0EEEA87261 ON type_prestation_type_evenement (type_prestation_id)');
        $this->addSql('DROP INDEX IDX_C7440455ED16FA20');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, metier_id, nom, prenom, dtype FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, metier_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, dtype VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO client (id, metier_id, nom, prenom, dtype) SELECT id, metier_id, nom, prenom, dtype FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE INDEX IDX_C7440455ED16FA20 ON client (metier_id)');
        $this->addSql('DROP INDEX IDX_B26681E19EB6921');
        $this->addSql('DROP INDEX IDX_B26681EC68BE09C');
        $this->addSql('DROP INDEX IDX_B26681E88939516');
        $this->addSql('DROP INDEX IDX_B26681E170A1CCC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__evenement AS SELECT id, client_id, localisation_id, type_evenement_id, etat_evenement_id, titre, date, lat, lng FROM evenement');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('CREATE TABLE evenement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, client_id INTEGER NOT NULL, localisation_id INTEGER NOT NULL, type_evenement_id INTEGER NOT NULL, etat_evenement_id INTEGER DEFAULT NULL, titre VARCHAR(255) NOT NULL, date DATE NOT NULL, lat DOUBLE PRECISION NOT NULL, lng DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO evenement (id, client_id, localisation_id, type_evenement_id, etat_evenement_id, titre, date, lat, lng) SELECT id, client_id, localisation_id, type_evenement_id, etat_evenement_id, titre, date, lat, lng FROM __temp__evenement');
        $this->addSql('DROP TABLE __temp__evenement');
        $this->addSql('CREATE INDEX IDX_B26681E19EB6921 ON evenement (client_id)');
        $this->addSql('CREATE INDEX IDX_B26681EC68BE09C ON evenement (localisation_id)');
        $this->addSql('CREATE INDEX IDX_B26681E88939516 ON evenement (type_evenement_id)');
        $this->addSql('CREATE INDEX IDX_B26681E170A1CCC ON evenement (etat_evenement_id)');
        $this->addSql('DROP INDEX IDX_51C88FADFD02F13');
        $this->addSql('DROP INDEX IDX_51C88FAD98DE13AC');
        $this->addSql('DROP INDEX IDX_51C88FAD8831D022');
        $this->addSql('DROP INDEX IDX_51C88FADEEA87261');
        $this->addSql('CREATE TEMPORARY TABLE __temp__prestation AS SELECT id, evenement_id, partenaire_id, etat_prestation_id, type_prestation_id, date_debut, date_fin FROM prestation');
        $this->addSql('DROP TABLE prestation');
        $this->addSql('CREATE TABLE prestation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, evenement_id INTEGER NOT NULL, partenaire_id INTEGER NOT NULL, etat_prestation_id INTEGER DEFAULT NULL, type_prestation_id INTEGER NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL)');
        $this->addSql('INSERT INTO prestation (id, evenement_id, partenaire_id, etat_prestation_id, type_prestation_id, date_debut, date_fin) SELECT id, evenement_id, partenaire_id, etat_prestation_id, type_prestation_id, date_debut, date_fin FROM __temp__prestation');
        $this->addSql('DROP TABLE __temp__prestation');
        $this->addSql('CREATE INDEX IDX_51C88FADFD02F13 ON prestation (evenement_id)');
        $this->addSql('CREATE INDEX IDX_51C88FAD98DE13AC ON prestation (partenaire_id)');
        $this->addSql('CREATE INDEX IDX_51C88FAD8831D022 ON prestation (etat_prestation_id)');
        $this->addSql('CREATE INDEX IDX_51C88FADEEA87261 ON prestation (type_prestation_id)');
        $this->addSql('DROP INDEX IDX_4CCB5988ED16FA20');
        $this->addSql('DROP INDEX IDX_4CCB5988BC08CF77');
        $this->addSql('CREATE TEMPORARY TABLE __temp__type_prestation AS SELECT id, metier_id, type_event_id, nom_type, description, tarif_public FROM type_prestation');
        $this->addSql('DROP TABLE type_prestation');
        $this->addSql('CREATE TABLE type_prestation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, metier_id INTEGER DEFAULT NULL, type_event_id INTEGER DEFAULT NULL, nom_type VARCHAR(255) NOT NULL, description CLOB NOT NULL, tarif_public DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO type_prestation (id, metier_id, type_event_id, nom_type, description, tarif_public) SELECT id, metier_id, type_event_id, nom_type, description, tarif_public FROM __temp__type_prestation');
        $this->addSql('DROP TABLE __temp__type_prestation');
        $this->addSql('CREATE INDEX IDX_4CCB5988ED16FA20 ON type_prestation (metier_id)');
        $this->addSql('CREATE INDEX IDX_4CCB5988BC08CF77 ON type_prestation (type_event_id)');
        $this->addSql('DROP INDEX IDX_9D376064EEA87261');
        $this->addSql('DROP INDEX IDX_9D37606498DE13AC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__type_prestation_partenaire AS SELECT type_prestation_id, partenaire_id FROM type_prestation_partenaire');
        $this->addSql('DROP TABLE type_prestation_partenaire');
        $this->addSql('CREATE TABLE type_prestation_partenaire (type_prestation_id INTEGER NOT NULL, partenaire_id INTEGER NOT NULL, PRIMARY KEY(type_prestation_id, partenaire_id))');
        $this->addSql('INSERT INTO type_prestation_partenaire (type_prestation_id, partenaire_id) SELECT type_prestation_id, partenaire_id FROM __temp__type_prestation_partenaire');
        $this->addSql('DROP TABLE __temp__type_prestation_partenaire');
        $this->addSql('CREATE INDEX IDX_9D376064EEA87261 ON type_prestation_partenaire (type_prestation_id)');
        $this->addSql('CREATE INDEX IDX_9D37606498DE13AC ON type_prestation_partenaire (partenaire_id)');
    }
}
