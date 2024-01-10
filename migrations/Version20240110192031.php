<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240110192031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE product DROP created_at');
        $this->addSql('ALTER TABLE product DROP updated_at');
        $this->addSql('ALTER TABLE product ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE product ALTER sku TYPE VARCHAR(250)');
        $this->addSql('ALTER INDEX product_sku_key RENAME TO UNIQ_D34A04ADF9038C4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('CREATE SEQUENCE product_id_seq1 INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('ALTER TABLE product ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE product ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('CREATE SEQUENCE product_id_seq');
        $this->addSql('SELECT setval(\'product_id_seq\', (SELECT MAX(id) FROM product))');
        $this->addSql('ALTER TABLE product ALTER id SET DEFAULT nextval(\'product_id_seq\')');
        $this->addSql('ALTER TABLE product ALTER sku TYPE VARCHAR(50)');
        $this->addSql('ALTER INDEX uniq_d34a04adf9038c4 RENAME TO product_sku_key');
    }
}
