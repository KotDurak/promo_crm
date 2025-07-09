<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250709070545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE withdrawal_request (id SERIAL NOT NULL, requesting_user_id INT DEFAULT NULL, sum NUMERIC(10, 2) NOT NULL, status VARCHAR(255) NOT NULL, card_number VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(20) DEFAULT NULL, comment TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5E56F6D72A841BBC ON withdrawal_request (requesting_user_id)');
        $this->addSql('ALTER TABLE withdrawal_request ADD CONSTRAINT FK_5E56F6D72A841BBC FOREIGN KEY (requesting_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE withdrawal_request DROP CONSTRAINT FK_5E56F6D72A841BBC');
        $this->addSql('DROP TABLE withdrawal_request');

    }
}
