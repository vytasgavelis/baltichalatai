<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191114181257 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE clinic_info (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, webpage VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(32) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_9C0BE2CE9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_education (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_DBEAD3369D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_specialty (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, specialty_id_id INT NOT NULL, INDEX IDX_E0862B089D86650F (user_id_id), INDEX IDX_E0862B08DC32BB7B (specialty_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(2000) NOT NULL, valid_from DATETIME NOT NULL, valid_duration DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, name_short VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_visit (id INT AUTO_INCREMENT NOT NULL, client_id_id INT NOT NULL, specialist_id_id INT NOT NULL, clinic_id_id INT NOT NULL, sending_to_doctor_id_id INT NOT NULL, recipe_id_id INT NOT NULL, visit_date DATETIME NOT NULL, description VARCHAR(2000) NOT NULL, INDEX IDX_A1BC1261DC2902E0 (client_id_id), INDEX IDX_A1BC1261C6F2BC85 (specialist_id_id), INDEX IDX_A1BC1261F6C03764 (clinic_id_id), INDEX IDX_A1BC1261B55430AD (sending_to_doctor_id_id), INDEX IDX_A1BC126169574A48 (recipe_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_info (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, phone_number VARCHAR(32) NOT NULL, personal_email VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, city LONGTEXT NOT NULL, person_code VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_B1087D9E9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sending_to_doctor (id INT AUTO_INCREMENT NOT NULL, client_id_id INT NOT NULL, specialist_id_id INT NOT NULL, description VARCHAR(2000) DEFAULT NULL, INDEX IDX_210BB3F8DC2902E0 (client_id_id), INDEX IDX_210BB3F8C6F2BC85 (specialist_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialty (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialist_work_hours (id INT AUTO_INCREMENT NOT NULL, specialist_id_id INT NOT NULL, clinic_id_id INT NOT NULL, day INT NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, INDEX IDX_AF3B1A7DC6F2BC85 (specialist_id_id), INDEX IDX_AF3B1A7DF6C03764 (clinic_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_language (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, language_id_id INT NOT NULL, INDEX IDX_345695B59D86650F (user_id_id), INDEX IDX_345695B51C9A06 (language_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clinic_info ADD CONSTRAINT FK_9C0BE2CE9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_education ADD CONSTRAINT FK_DBEAD3369D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_specialty ADD CONSTRAINT FK_E0862B089D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_specialty ADD CONSTRAINT FK_E0862B08DC32BB7B FOREIGN KEY (specialty_id_id) REFERENCES specialty (id)');
        $this->addSql('ALTER TABLE user_visit ADD CONSTRAINT FK_A1BC1261DC2902E0 FOREIGN KEY (client_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_visit ADD CONSTRAINT FK_A1BC1261C6F2BC85 FOREIGN KEY (specialist_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_visit ADD CONSTRAINT FK_A1BC1261F6C03764 FOREIGN KEY (clinic_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_visit ADD CONSTRAINT FK_A1BC1261B55430AD FOREIGN KEY (sending_to_doctor_id_id) REFERENCES sending_to_doctor (id)');
        $this->addSql('ALTER TABLE user_visit ADD CONSTRAINT FK_A1BC126169574A48 FOREIGN KEY (recipe_id_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE user_info ADD CONSTRAINT FK_B1087D9E9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sending_to_doctor ADD CONSTRAINT FK_210BB3F8DC2902E0 FOREIGN KEY (client_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sending_to_doctor ADD CONSTRAINT FK_210BB3F8C6F2BC85 FOREIGN KEY (specialist_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE specialist_work_hours ADD CONSTRAINT FK_AF3B1A7DC6F2BC85 FOREIGN KEY (specialist_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE specialist_work_hours ADD CONSTRAINT FK_AF3B1A7DF6C03764 FOREIGN KEY (clinic_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_language ADD CONSTRAINT FK_345695B59D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_language ADD CONSTRAINT FK_345695B51C9A06 FOREIGN KEY (language_id_id) REFERENCES language (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE clinic_info DROP FOREIGN KEY FK_9C0BE2CE9D86650F');
        $this->addSql('ALTER TABLE user_education DROP FOREIGN KEY FK_DBEAD3369D86650F');
        $this->addSql('ALTER TABLE user_specialty DROP FOREIGN KEY FK_E0862B089D86650F');
        $this->addSql('ALTER TABLE user_visit DROP FOREIGN KEY FK_A1BC1261DC2902E0');
        $this->addSql('ALTER TABLE user_visit DROP FOREIGN KEY FK_A1BC1261C6F2BC85');
        $this->addSql('ALTER TABLE user_visit DROP FOREIGN KEY FK_A1BC1261F6C03764');
        $this->addSql('ALTER TABLE user_info DROP FOREIGN KEY FK_B1087D9E9D86650F');
        $this->addSql('ALTER TABLE sending_to_doctor DROP FOREIGN KEY FK_210BB3F8DC2902E0');
        $this->addSql('ALTER TABLE sending_to_doctor DROP FOREIGN KEY FK_210BB3F8C6F2BC85');
        $this->addSql('ALTER TABLE specialist_work_hours DROP FOREIGN KEY FK_AF3B1A7DC6F2BC85');
        $this->addSql('ALTER TABLE specialist_work_hours DROP FOREIGN KEY FK_AF3B1A7DF6C03764');
        $this->addSql('ALTER TABLE user_language DROP FOREIGN KEY FK_345695B59D86650F');
        $this->addSql('ALTER TABLE user_visit DROP FOREIGN KEY FK_A1BC126169574A48');
        $this->addSql('ALTER TABLE user_language DROP FOREIGN KEY FK_345695B51C9A06');
        $this->addSql('ALTER TABLE user_visit DROP FOREIGN KEY FK_A1BC1261B55430AD');
        $this->addSql('ALTER TABLE user_specialty DROP FOREIGN KEY FK_E0862B08DC32BB7B');
        $this->addSql('DROP TABLE clinic_info');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_education');
        $this->addSql('DROP TABLE user_specialty');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE user_visit');
        $this->addSql('DROP TABLE user_info');
        $this->addSql('DROP TABLE sending_to_doctor');
        $this->addSql('DROP TABLE specialty');
        $this->addSql('DROP TABLE specialist_work_hours');
        $this->addSql('DROP TABLE user_language');
    }
}
