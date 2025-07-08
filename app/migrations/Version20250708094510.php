<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250708094510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE organization (id SERIAL NOT NULL, owner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, api_key VARCHAR(64) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C1EE637CC912ED9D ON organization (api_key)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C1EE637C7E3C61F9 ON organization (owner_id)');
        $this->addSql('CREATE TABLE promo_code (id SERIAL NOT NULL, promo_code_type_id INT NOT NULL, created_by_id INT NOT NULL, organization_id INT NOT NULL, code VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3D8C939E65ED0F18 ON promo_code (promo_code_type_id)');
        $this->addSql('CREATE INDEX IDX_3D8C939EB03A8386 ON promo_code (created_by_id)');
        $this->addSql('CREATE INDEX IDX_3D8C939E32C8A3DE ON promo_code (organization_id)');
        $this->addSql('CREATE TABLE promo_code_type (id SERIAL NOT NULL, organization_id INT NOT NULL, name VARCHAR(255) NOT NULL, cashback INT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_92FF5A5332C8A3DE ON promo_code_type (organization_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, organization_id INT NOT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(50) NOT NULL, password VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE INDEX IDX_8D93D64932C8A3DE ON "user" (organization_id)');
        $this->addSql('ALTER TABLE organization ADD CONSTRAINT FK_C1EE637C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promo_code ADD CONSTRAINT FK_3D8C939E65ED0F18 FOREIGN KEY (promo_code_type_id) REFERENCES promo_code_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promo_code ADD CONSTRAINT FK_3D8C939EB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promo_code ADD CONSTRAINT FK_3D8C939E32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promo_code_type ADD CONSTRAINT FK_92FF5A5332C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64932C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promo_code ADD CONSTRAINT uniq_organization_code UNIQUE (organization_id, code)');
        $this->addSql('ALTER TABLE promo_code_type ADD CONSTRAINT uniq_type_organization UNIQUE (organization_id, type)');
    }

    public function down(Schema $schema): void
    {
        // Сначала удаляем все ограничения
        $this->addSql('ALTER TABLE organization DROP CONSTRAINT IF EXISTS FK_C1EE637C7E3C61F9');
        $this->addSql('ALTER TABLE promo_code DROP CONSTRAINT IF EXISTS FK_3D8C939E65ED0F18');
        $this->addSql('ALTER TABLE promo_code DROP CONSTRAINT IF EXISTS FK_3D8C939EB03A8386');
        $this->addSql('ALTER TABLE promo_code DROP CONSTRAINT IF EXISTS FK_3D8C939E32C8A3DE');
        $this->addSql('ALTER TABLE promo_code_type DROP CONSTRAINT IF EXISTS FK_92FF5A5332C8A3DE');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT IF EXISTS FK_8D93D64932C8A3DE');

        // Удаляем уникальные ограничения
        $this->addSql('ALTER TABLE promo_code DROP CONSTRAINT IF EXISTS uniq_organization_code');
        $this->addSql('ALTER TABLE promo_code_type DROP CONSTRAINT IF EXISTS uniq_type_organization');

        // Теперь можно безопасно удалять таблицы
        $this->addSql('DROP TABLE IF EXISTS organization CASCADE');
        $this->addSql('DROP TABLE IF EXISTS promo_code CASCADE');
        $this->addSql('DROP TABLE IF EXISTS promo_code_type CASCADE');
        $this->addSql('DROP TABLE IF EXISTS "user" CASCADE');


    }
}
