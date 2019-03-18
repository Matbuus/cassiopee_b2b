<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190318105806 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_4CCB598898DE13AC');
        $this->addSql('DROP INDEX IDX_4CCB5988ED16FA20');
        $this->addSql('CREATE TEMPORARY TABLE __temp__type_prestation AS SELECT id, metier_id, partenaire_id, nom_type, description, tarif_public FROM type_prestation');
        $this->addSql('DROP TABLE type_prestation');
        $this->addSql('CREATE TABLE type_prestation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, metier_id INTEGER DEFAULT NULL, partenaire_id INTEGER DEFAULT NULL, nom_type VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, tarif_public DOUBLE PRECISION NOT NULL, CONSTRAINT FK_4CCB5988ED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4CCB598898DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO type_prestation (id, metier_id, partenaire_id, nom_type, description, tarif_public) SELECT id, metier_id, partenaire_id, nom_type, description, tarif_public FROM __temp__type_prestation');
        $this->addSql('DROP TABLE __temp__type_prestation');
        $this->addSql('CREATE INDEX IDX_4CCB598898DE13AC ON type_prestation (partenaire_id)');
        $this->addSql('CREATE INDEX IDX_4CCB5988ED16FA20 ON type_prestation (metier_id)');
        $this->addSql('DROP INDEX IDX_32FFA373DCF28B17');
        $this->addSql('DROP INDEX UNIQ_32FFA3732E4D1423');
        $this->addSql('CREATE TEMPORARY TABLE __temp__partenaire AS SELECT id, prestation_proposee_id, nom, prenom FROM partenaire');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('CREATE TABLE partenaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, prestation_proposee_id INTEGER DEFAULT NULL, metier_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL COLLATE BINARY, prenom VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_32FFA3732E4D1423 FOREIGN KEY (prestation_proposee_id) REFERENCES prestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_32FFA373ED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO partenaire (id, prestation_proposee_id, nom, prenom) SELECT id, prestation_proposee_id, nom, prenom FROM __temp__partenaire');
        $this->addSql('DROP TABLE __temp__partenaire');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_32FFA3732E4D1423 ON partenaire (prestation_proposee_id)');
        $this->addSql('CREATE INDEX IDX_32FFA373ED16FA20 ON partenaire (metier_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_32FFA3732E4D1423');
        $this->addSql('DROP INDEX IDX_32FFA373ED16FA20');
        $this->addSql('CREATE TEMPORARY TABLE __temp__partenaire AS SELECT id, prestation_proposee_id, nom, prenom FROM partenaire');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('CREATE TABLE partenaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, prestation_proposee_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, metiers_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO partenaire (id, prestation_proposee_id, nom, prenom) SELECT id, prestation_proposee_id, nom, prenom FROM __temp__partenaire');
        $this->addSql('DROP TABLE __temp__partenaire');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_32FFA3732E4D1423 ON partenaire (prestation_proposee_id)');
        $this->addSql('CREATE INDEX IDX_32FFA373DCF28B17 ON partenaire (metiers_id)');
        $this->addSql('DROP INDEX IDX_4CCB5988ED16FA20');
        $this->addSql('DROP INDEX IDX_4CCB598898DE13AC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__type_prestation AS SELECT id, metier_id, partenaire_id, nom_type, description, tarif_public FROM type_prestation');
        $this->addSql('DROP TABLE type_prestation');
        $this->addSql('CREATE TABLE type_prestation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, metier_id INTEGER DEFAULT NULL, partenaire_id INTEGER DEFAULT NULL, nom_type VARCHAR(255) NOT NULL, description CLOB NOT NULL, tarif_public DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO type_prestation (id, metier_id, partenaire_id, nom_type, description, tarif_public) SELECT id, metier_id, partenaire_id, nom_type, description, tarif_public FROM __temp__type_prestation');
        $this->addSql('DROP TABLE __temp__type_prestation');
        $this->addSql('CREATE INDEX IDX_4CCB5988ED16FA20 ON type_prestation (metier_id)');
        $this->addSql('CREATE INDEX IDX_4CCB598898DE13AC ON type_prestation (partenaire_id)');
    }
}
