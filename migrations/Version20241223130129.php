<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20241223130000 extends AbstractMigration {
    public function getDescription(): string {
        return 'Inserta datos para Columnistas, Conductores e Invitados, respetando la herencia JOINED';
    }

    public function up(Schema $schema): void {
        $this->addSql("INSERT INTO persona2 (nombre, apellido, edad, foto, tipo) VALUES ('Juan', 'Pérez', 35, 'foto_juan.jpg', 'conductor')");
        $personaId = $this->connection->lastInsertId();
        $this->addSql("INSERT INTO conductor (3, cumple, apodo, instagram, twitter, youtube) VALUES ($personaId, '1989-05-12', 'El conductor', 'juan_instagram', 'juan_twitter', 'juan_youtube')");
        
        $this->addSql("INSERT INTO persona2 (nombre, apellido, edad, foto, tipo) VALUES ('Ana', 'López', 40, 'foto_ana.jpg', 'columnista')");
        $personaId = $this->connection->lastInsertId();
        $this->addSql("INSERT INTO columnista (4, apodo, columna) VALUES ($personaId, 'Ana la columnista', 'Columna de política')");
        
        $this->addSql("INSERT INTO persona2 (nombre, apellido, edad, foto, tipo) VALUES ('Carlos', 'García', 50, 'foto_carlos.jpg', 'invitado')");
        $personaId = $this->connection->lastInsertId();
        $this->addSql("INSERT INTO invitado (5, apodo, rubro) VALUES ($personaId, 'Carlos el invitado', 'Actor')");
    }

    public function down(Schema $schema): void {
        $this->addSql("DELETE FROM conductor WHERE persona2_id IN (SELECT id FROM persona2 WHERE nombre = 'Juan')");
        $this->addSql("DELETE FROM columnista WHERE persona2_id IN (SELECT id FROM persona2 WHERE nombre = 'Ana')");
        $this->addSql("DELETE FROM invitado WHERE persona2_id IN (SELECT id FROM persona2 WHERE nombre = 'Carlos')");
        $this->addSql("DELETE FROM persona2 WHERE nombre IN ('Juan', 'Ana', 'Carlos')");
    }
}


