<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241226184555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE programa (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, fecha DATE NOT NULL, link_youtube VARCHAR(255) NOT NULL, miniatura VARCHAR(255) NOT NULL, edicion VARCHAR(50) NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__columnista AS SELECT apodo, columna, id FROM columnista');
        $this->addSql('DROP TABLE columnista');
        $this->addSql('CREATE TABLE columnista (apodo VARCHAR(50) DEFAULT NULL, columna VARCHAR(50) DEFAULT NULL, id INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_9083851CBF396750 FOREIGN KEY (id) REFERENCES persona2 (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO columnista (apodo, columna, id) SELECT apodo, columna, id FROM __temp__columnista');
        $this->addSql('DROP TABLE __temp__columnista');
        $this->addSql('CREATE TEMPORARY TABLE __temp__conductor AS SELECT cumple, apodo, instagram, twitter, youtube, id FROM conductor');
        $this->addSql('DROP TABLE conductor');
        $this->addSql('CREATE TABLE conductor (cumple DATE DEFAULT NULL, apodo VARCHAR(50) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, id INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_D5F7F18ABF396750 FOREIGN KEY (id) REFERENCES persona2 (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO conductor (cumple, apodo, instagram, twitter, youtube, id) SELECT cumple, apodo, instagram, twitter, youtube, id FROM __temp__conductor');
        $this->addSql('DROP TABLE __temp__conductor');
        $this->addSql('CREATE TEMPORARY TABLE __temp__invitado AS SELECT apodo, rubro, id FROM invitado');
        $this->addSql('DROP TABLE invitado');
        $this->addSql('CREATE TABLE invitado (apodo VARCHAR(50) DEFAULT NULL, rubro VARCHAR(255) DEFAULT NULL, id INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_4982EC17BF396750 FOREIGN KEY (id) REFERENCES persona2 (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO invitado (apodo, rubro, id) SELECT apodo, rubro, id FROM __temp__invitado');
        $this->addSql('DROP TABLE __temp__invitado');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE programa');
        $this->addSql('CREATE TEMPORARY TABLE __temp__columnista AS SELECT apodo, columna, id FROM columnista');
        $this->addSql('DROP TABLE columnista');
        $this->addSql('CREATE TABLE columnista (apodo VARCHAR(50) DEFAULT NULL, columna VARCHAR(50) DEFAULT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, CONSTRAINT FK_9083851CBF396750 FOREIGN KEY (id) REFERENCES persona2 (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO columnista (apodo, columna, id) SELECT apodo, columna, id FROM __temp__columnista');
        $this->addSql('DROP TABLE __temp__columnista');
        $this->addSql('CREATE TEMPORARY TABLE __temp__conductor AS SELECT cumple, apodo, instagram, twitter, youtube, id FROM conductor');
        $this->addSql('DROP TABLE conductor');
        $this->addSql('CREATE TABLE conductor (cumple DATE DEFAULT NULL, apodo VARCHAR(50) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, CONSTRAINT FK_D5F7F18ABF396750 FOREIGN KEY (id) REFERENCES persona2 (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO conductor (cumple, apodo, instagram, twitter, youtube, id) SELECT cumple, apodo, instagram, twitter, youtube, id FROM __temp__conductor');
        $this->addSql('DROP TABLE __temp__conductor');
        $this->addSql('CREATE TEMPORARY TABLE __temp__invitado AS SELECT apodo, rubro, id FROM invitado');
        $this->addSql('DROP TABLE invitado');
        $this->addSql('CREATE TABLE invitado (apodo VARCHAR(50) DEFAULT NULL, rubro VARCHAR(255) DEFAULT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, CONSTRAINT FK_4982EC17BF396750 FOREIGN KEY (id) REFERENCES persona2 (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO invitado (apodo, rubro, id) SELECT apodo, rubro, id FROM __temp__invitado');
        $this->addSql('DROP TABLE __temp__invitado');
    }
}
