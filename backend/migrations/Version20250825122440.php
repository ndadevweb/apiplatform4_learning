<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250825122440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP CONSTRAINT fk_23a0e66221fc741');
        $this->addSql('DROP SEQUENCE auhtor_id_seq CASCADE');
        $this->addSql('CREATE TABLE author (id SERIAL NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE auhtor');
        $this->addSql('DROP INDEX idx_23a0e66221fc741');
        $this->addSql('ALTER TABLE article RENAME COLUMN auhtor_id TO author_id');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES author (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE article DROP CONSTRAINT FK_23A0E66F675F31B');
        $this->addSql('CREATE SEQUENCE auhtor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE auhtor (id SERIAL NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP INDEX IDX_23A0E66F675F31B');
        $this->addSql('ALTER TABLE article RENAME COLUMN author_id TO auhtor_id');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT fk_23a0e66221fc741 FOREIGN KEY (auhtor_id) REFERENCES auhtor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_23a0e66221fc741 ON article (auhtor_id)');
    }
}
