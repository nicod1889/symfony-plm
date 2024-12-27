<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241216123409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__persona AS SELECT id, nombre, apellido, dni, edad, club_id FROM persona');
        $this->addSql('DROP TABLE persona');
        $this->addSql('CREATE TABLE persona (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, apellido VARCHAR(50) NOT NULL, dni INTEGER NOT NULL, edad INTEGER NOT NULL, club_id INTEGER DEFAULT NULL, CONSTRAINT FK_51E5B69B61190A32 FOREIGN KEY (club_id) REFERENCES club (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO persona (id, nombre, apellido, dni, edad, club_id) SELECT id, nombre, apellido, dni, edad, club_id FROM __temp__persona');
        $this->addSql('DROP TABLE __temp__persona');
        $this->addSql('CREATE INDEX IDX_51E5B69B61190A32 ON persona (club_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__persona AS SELECT id, nombre, apellido, dni, edad, club_id FROM persona');
        $this->addSql('DROP TABLE persona');
        $this->addSql('CREATE TABLE persona (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, apellido VARCHAR(50) NOT NULL, dni INTEGER NOT NULL, edad INTEGER NOT NULL, club_id INTEGER NOT NULL, CONSTRAINT FK_51E5B69B61190A32 FOREIGN KEY (club_id) REFERENCES club (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO persona (id, nombre, apellido, dni, edad, club_id) SELECT id, nombre, apellido, dni, edad, club_id FROM __temp__persona');
        $this->addSql('DROP TABLE __temp__persona');
        $this->addSql('CREATE INDEX IDX_51E5B69B61190A32 ON persona (club_id)');
    }
}
