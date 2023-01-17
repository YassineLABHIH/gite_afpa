<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117110658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipement_ext (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_85A8C415E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipement_int (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1DD8C0F25E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gite (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, contact_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, surface INT NOT NULL, nbr_room INT NOT NULL, nbr_bed INT NOT NULL, is_animal_allowed TINYINT(1) NOT NULL, animal_price DOUBLE PRECISION DEFAULT NULL, description LONGTEXT NOT NULL, INDEX IDX_B638C92C7E3C61F9 (owner_id), INDEX IDX_B638C92CE7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gite_equipement_ext (gite_id INT NOT NULL, equipement_ext_id INT NOT NULL, INDEX IDX_B32663A1652CAE9B (gite_id), INDEX IDX_B32663A1B914D62 (equipement_ext_id), PRIMARY KEY(gite_id, equipement_ext_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gite_equipement_int (gite_id INT NOT NULL, equipement_int_id INT NOT NULL, INDEX IDX_A6A42F12652CAE9B (gite_id), INDEX IDX_A6A42F1293F3EF3B (equipement_int_id), PRIMARY KEY(gite_id, equipement_int_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gite_service (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, gite_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_1527AE9AED5CA9E6 (service_id), INDEX IDX_1527AE9A652CAE9B (gite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, gite_id INT NOT NULL, path VARCHAR(255) NOT NULL, is_main TINYINT(1) NOT NULL, INDEX IDX_14B78418652CAE9B (gite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E19D9AD25E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6497E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gite ADD CONSTRAINT FK_B638C92C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE gite ADD CONSTRAINT FK_B638C92CE7A1254A FOREIGN KEY (contact_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE gite_equipement_ext ADD CONSTRAINT FK_B32663A1652CAE9B FOREIGN KEY (gite_id) REFERENCES gite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gite_equipement_ext ADD CONSTRAINT FK_B32663A1B914D62 FOREIGN KEY (equipement_ext_id) REFERENCES equipement_ext (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gite_equipement_int ADD CONSTRAINT FK_A6A42F12652CAE9B FOREIGN KEY (gite_id) REFERENCES gite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gite_equipement_int ADD CONSTRAINT FK_A6A42F1293F3EF3B FOREIGN KEY (equipement_int_id) REFERENCES equipement_int (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gite_service ADD CONSTRAINT FK_1527AE9AED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE gite_service ADD CONSTRAINT FK_1527AE9A652CAE9B FOREIGN KEY (gite_id) REFERENCES gite (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418652CAE9B FOREIGN KEY (gite_id) REFERENCES gite (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gite DROP FOREIGN KEY FK_B638C92C7E3C61F9');
        $this->addSql('ALTER TABLE gite DROP FOREIGN KEY FK_B638C92CE7A1254A');
        $this->addSql('ALTER TABLE gite_equipement_ext DROP FOREIGN KEY FK_B32663A1652CAE9B');
        $this->addSql('ALTER TABLE gite_equipement_ext DROP FOREIGN KEY FK_B32663A1B914D62');
        $this->addSql('ALTER TABLE gite_equipement_int DROP FOREIGN KEY FK_A6A42F12652CAE9B');
        $this->addSql('ALTER TABLE gite_equipement_int DROP FOREIGN KEY FK_A6A42F1293F3EF3B');
        $this->addSql('ALTER TABLE gite_service DROP FOREIGN KEY FK_1527AE9AED5CA9E6');
        $this->addSql('ALTER TABLE gite_service DROP FOREIGN KEY FK_1527AE9A652CAE9B');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418652CAE9B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497E3C61F9');
        $this->addSql('DROP TABLE equipement_ext');
        $this->addSql('DROP TABLE equipement_int');
        $this->addSql('DROP TABLE gite');
        $this->addSql('DROP TABLE gite_equipement_ext');
        $this->addSql('DROP TABLE gite_equipement_int');
        $this->addSql('DROP TABLE gite_service');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
