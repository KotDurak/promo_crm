<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250712104732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE promo_code_purchase (id SERIAL NOT NULL, promo_code_owner_id INT DEFAULT NULL, promo_code_id INT DEFAULT NULL, full_price DOUBLE PRECISION NOT NULL, cashback DOUBLE PRECISION NOT NULL, purchase_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1BDD2A104F69AD2 ON promo_code_purchase (promo_code_owner_id)');
        $this->addSql('CREATE INDEX IDX_1BDD2A102FAE4625 ON promo_code_purchase (promo_code_id)');
        $this->addSql('ALTER TABLE promo_code_purchase ADD CONSTRAINT FK_1BDD2A104F69AD2 FOREIGN KEY (promo_code_owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promo_code_purchase ADD CONSTRAINT FK_1BDD2A102FAE4625 FOREIGN KEY (promo_code_id) REFERENCES promo_code (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organization ADD site_address VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE INDEX idx_purchase_date ON promo_code_purchase(purchase_date)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promo_code_purchase DROP CONSTRAINT FK_1BDD2A104F69AD2');
        $this->addSql('ALTER TABLE promo_code_purchase DROP CONSTRAINT FK_1BDD2A102FAE4625');
        $this->addSql('DROP TABLE promo_code_purchase');
        $this->addSql('ALTER TABLE organization DROP site_address');
    }
}
