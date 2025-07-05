<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250705075245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE organization ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE organization ADD CONSTRAINT FK_C1EE637C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C1EE637C7E3C61F9 ON organization (owner_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE organization DROP CONSTRAINT FK_C1EE637C7E3C61F9');
        $this->addSql('DROP INDEX UNIQ_C1EE637C7E3C61F9');
        $this->addSql('ALTER TABLE organization DROP owner_id');
    }
}
