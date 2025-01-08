<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107203444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, created_on DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE club (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, city VARCHAR(50) NOT NULL, socios INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE columnista (apodo VARCHAR(50) DEFAULT NULL, columna VARCHAR(50) DEFAULT NULL, id INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_9083851CBF396750 FOREIGN KEY (id) REFERENCES persona2 (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE TABLE columnista_programa (columnista_id INTEGER NOT NULL, programa_id INTEGER NOT NULL, PRIMARY KEY(columnista_id, programa_id), CONSTRAINT FK_D9878D9A41382120 FOREIGN KEY (columnista_id) REFERENCES columnista (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D9878D9AFD8A7328 FOREIGN KEY (programa_id) REFERENCES programa (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D9878D9A41382120 ON columnista_programa (columnista_id)');
        $this->addSql('CREATE INDEX IDX_D9878D9AFD8A7328 ON columnista_programa (programa_id)');
        $this->addSql('CREATE TABLE conductor (cumple DATE DEFAULT NULL, apodo VARCHAR(50) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, id INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_D5F7F18ABF396750 FOREIGN KEY (id) REFERENCES persona2 (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE TABLE conductor_programa (conductor_id INTEGER NOT NULL, programa_id INTEGER NOT NULL, PRIMARY KEY(conductor_id, programa_id), CONSTRAINT FK_FA046A3A49DECF0 FOREIGN KEY (conductor_id) REFERENCES conductor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FA046A3FD8A7328 FOREIGN KEY (programa_id) REFERENCES programa (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_FA046A3A49DECF0 ON conductor_programa (conductor_id)');
        $this->addSql('CREATE INDEX IDX_FA046A3FD8A7328 ON conductor_programa (programa_id)');
        $this->addSql('CREATE TABLE edificio (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, street VARCHAR(100) NOT NULL, number_street INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE invitado (apodo VARCHAR(50) DEFAULT NULL, rubro VARCHAR(255) DEFAULT NULL, id INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_4982EC17BF396750 FOREIGN KEY (id) REFERENCES persona2 (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE TABLE persona (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, apellido VARCHAR(50) NOT NULL, dni INTEGER NOT NULL, edad INTEGER NOT NULL, club_id INTEGER DEFAULT NULL, CONSTRAINT FK_51E5B69B61190A32 FOREIGN KEY (club_id) REFERENCES club (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_51E5B69B61190A32 ON persona (club_id)');
        $this->addSql('CREATE TABLE persona2 (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, edad INTEGER NOT NULL, foto VARCHAR(255) NOT NULL, tipo VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE persona3 (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, apodo VARCHAR(50) DEFAULT NULL, nacimiento DATE DEFAULT NULL, edad INTEGER DEFAULT NULL, foto VARCHAR(255) DEFAULT NULL, rubro VARCHAR(100) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE producto (id VARCHAR(255) NOT NULL, name VARCHAR(100) NOT NULL, sku VARCHAR(50) NOT NULL, price INTEGER NOT NULL, created_on DATETIME NOT NULL, category_id INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_A7BB061512469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_A7BB061512469DE2 ON producto (category_id)');
        $this->addSql('CREATE INDEX product_sku ON producto (sku)');
        $this->addSql('CREATE INDEX product_price ON producto (price)');
        $this->addSql('CREATE TABLE programa (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, fecha DATE NOT NULL, link_youtube VARCHAR(255) NOT NULL, link_spotify VARCHAR(255) DEFAULT NULL, miniatura_pequeña VARCHAR(255) NOT NULL, miniatura_grande VARCHAR(255) NOT NULL, edicion VARCHAR(50) DEFAULT NULL)');
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
        $this->addSql('CREATE TABLE symfony_demo_comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL, post_id INTEGER NOT NULL, author_id INTEGER NOT NULL, CONSTRAINT FK_53AD8F834B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_53AD8F83F675F31B FOREIGN KEY (author_id) REFERENCES symfony_demo_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_53AD8F834B89032C ON symfony_demo_comment (post_id)');
        $this->addSql('CREATE INDEX IDX_53AD8F83F675F31B ON symfony_demo_comment (author_id)');
        $this->addSql('CREATE TABLE symfony_demo_post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL, author_id INTEGER NOT NULL, CONSTRAINT FK_58A92E65F675F31B FOREIGN KEY (author_id) REFERENCES symfony_demo_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_58A92E65F675F31B ON symfony_demo_post (author_id)');
        $this->addSql('CREATE TABLE symfony_demo_post_tag (post_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(post_id, tag_id), CONSTRAINT FK_6ABC1CC44B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6ABC1CC4BAD26311 FOREIGN KEY (tag_id) REFERENCES symfony_demo_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6ABC1CC44B89032C ON symfony_demo_post_tag (post_id)');
        $this->addSql('CREATE INDEX IDX_6ABC1CC4BAD26311 ON symfony_demo_post_tag (tag_id)');
        $this->addSql('CREATE TABLE symfony_demo_tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4D5855405E237E06 ON symfony_demo_tag (name)');
        $this->addSql('CREATE TABLE symfony_demo_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1F85E0677 ON symfony_demo_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1E7927C74 ON symfony_demo_user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE columnista');
        $this->addSql('DROP TABLE columnista_programa');
        $this->addSql('DROP TABLE conductor');
        $this->addSql('DROP TABLE conductor_programa');
        $this->addSql('DROP TABLE edificio');
        $this->addSql('DROP TABLE invitado');
        $this->addSql('DROP TABLE persona');
        $this->addSql('DROP TABLE persona2');
        $this->addSql('DROP TABLE persona3');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE programa');
        $this->addSql('DROP TABLE programa_conductores');
        $this->addSql('DROP TABLE programa_columnistas');
        $this->addSql('DROP TABLE programa_invitados');
        $this->addSql('DROP TABLE rol');
        $this->addSql('DROP TABLE symfony_demo_comment');
        $this->addSql('DROP TABLE symfony_demo_post');
        $this->addSql('DROP TABLE symfony_demo_post_tag');
        $this->addSql('DROP TABLE symfony_demo_tag');
        $this->addSql('DROP TABLE symfony_demo_user');
    }
}
