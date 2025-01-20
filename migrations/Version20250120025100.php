<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250120025100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clip (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, miniatura VARCHAR(255) DEFAULT NULL, programa_id INTEGER DEFAULT NULL, CONSTRAINT FK_AD201467FD8A7328 FOREIGN KEY (programa_id) REFERENCES programa (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_AD201467FD8A7328 ON clip (programa_id)');
        $this->addSql('CREATE TABLE columna (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titulo VARCHAR(50) NOT NULL, link VARCHAR(255) NOT NULL, edicion_id INTEGER DEFAULT NULL, CONSTRAINT FK_5F77B1FFD651B81E FOREIGN KEY (edicion_id) REFERENCES edicion (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5F77B1FFD651B81E ON columna (edicion_id)');
        $this->addSql('CREATE TABLE edicion (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, tipo VARCHAR(50) NOT NULL)');
        $this->addSql('CREATE TABLE persona3 (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, apodo VARCHAR(50) DEFAULT NULL, nacimiento DATE DEFAULT NULL, edad INTEGER DEFAULT NULL, foto VARCHAR(255) DEFAULT NULL, rubro VARCHAR(100) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE programa (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, fecha DATE NOT NULL, link_youtube VARCHAR(255) DEFAULT NULL, link_spotify VARCHAR(255) DEFAULT NULL, miniatura VARCHAR(255) DEFAULT NULL, edicion VARCHAR(50) DEFAULT NULL, comentario VARCHAR(255) DEFAULT NULL, edicion_class_id INTEGER DEFAULT NULL, CONSTRAINT FK_2F0140D6D63A7C7 FOREIGN KEY (edicion_class_id) REFERENCES edicion (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_2F0140D6D63A7C7 ON programa (edicion_class_id)');
        $this->addSql('CREATE TABLE programa_conductores (programa_id INTEGER NOT NULL, persona3_id INTEGER NOT NULL, PRIMARY KEY(programa_id, persona3_id), CONSTRAINT FK_7B0E6A61FD8A7328 FOREIGN KEY (programa_id) REFERENCES programa (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7B0E6A61CE2D16BD FOREIGN KEY (persona3_id) REFERENCES persona3 (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_7B0E6A61FD8A7328 ON programa_conductores (programa_id)');
        $this->addSql('CREATE INDEX IDX_7B0E6A61CE2D16BD ON programa_conductores (persona3_id)');
        $this->addSql('CREATE TABLE programa_columnistas (programa_id INTEGER NOT NULL, persona3_id INTEGER NOT NULL, PRIMARY KEY(programa_id, persona3_id), CONSTRAINT FK_EF18B087FD8A7328 FOREIGN KEY (programa_id) REFERENCES programa (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EF18B087CE2D16BD FOREIGN KEY (persona3_id) REFERENCES persona3 (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_EF18B087FD8A7328 ON programa_columnistas (programa_id)');
        $this->addSql('CREATE INDEX IDX_EF18B087CE2D16BD ON programa_columnistas (persona3_id)');
        $this->addSql('CREATE TABLE programa_invitados (programa_id INTEGER NOT NULL, persona3_id INTEGER NOT NULL, PRIMARY KEY(programa_id, persona3_id), CONSTRAINT FK_B92EF493FD8A7328 FOREIGN KEY (programa_id) REFERENCES programa (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B92EF493CE2D16BD FOREIGN KEY (persona3_id) REFERENCES persona3 (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B92EF493FD8A7328 ON programa_invitados (programa_id)');
        $this->addSql('CREATE INDEX IDX_B92EF493CE2D16BD ON programa_invitados (persona3_id)');
        $this->addSql('CREATE TABLE rol (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E553F373A909126 ON rol (nombre)');
        $this->addSql('CREATE TABLE symfony_demo_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1F85E0677 ON symfony_demo_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1E7927C74 ON symfony_demo_user (email)');
        $this->addSql('CREATE TABLE vlog (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, miniatura VARCHAR(255) DEFAULT NULL, edicion_id INTEGER DEFAULT NULL, CONSTRAINT FK_1F6E918BD651B81E FOREIGN KEY (edicion_id) REFERENCES edicion (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_1F6E918BD651B81E ON vlog (edicion_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE clip');
        $this->addSql('DROP TABLE columna');
        $this->addSql('DROP TABLE edicion');
        $this->addSql('DROP TABLE persona3');
        $this->addSql('DROP TABLE programa');
        $this->addSql('DROP TABLE programa_conductores');
        $this->addSql('DROP TABLE programa_columnistas');
        $this->addSql('DROP TABLE programa_invitados');
        $this->addSql('DROP TABLE rol');
        $this->addSql('DROP TABLE symfony_demo_user');
        $this->addSql('DROP TABLE vlog');
    }
}
