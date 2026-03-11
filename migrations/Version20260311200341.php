<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260311200341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parameter (id UUID NOT NULL, name VARCHAR(255) NOT NULL, value DOUBLE PRECISION NOT NULL, exam_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_2A979110578D5E91 ON parameter (exam_id)');
        $this->addSql('ALTER TABLE parameter ADD CONSTRAINT FK_2A979110578D5E91 FOREIGN KEY (exam_id) REFERENCES exam (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parameter DROP CONSTRAINT FK_2A979110578D5E91');
        $this->addSql('DROP TABLE parameter');
    }
}
