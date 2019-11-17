<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191117113942 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE clinic_specialists (id INT AUTO_INCREMENT NOT NULL, clinic_id_id INT NOT NULL, specialist_id_id INT NOT NULL, INDEX IDX_D21A57C3F6C03764 (clinic_id_id), INDEX IDX_D21A57C3C6F2BC85 (specialist_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clinic_specialists ADD CONSTRAINT FK_D21A57C3F6C03764 FOREIGN KEY (clinic_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE clinic_specialists ADD CONSTRAINT FK_D21A57C3C6F2BC85 FOREIGN KEY (specialist_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE clinic_info CHANGE webpage webpage VARCHAR(255) DEFAULT NULL, CHANGE phone_number phone_number VARCHAR(32) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_visit ADD is_completed TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_info DROP INDEX UNIQ_B1087D9E9D86650F, ADD INDEX IDX_B1087D9E9D86650F (user_id_id)');
        $this->addSql('ALTER TABLE user_info CHANGE user_id_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sending_to_doctor CHANGE description description VARCHAR(2000) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE clinic_specialists');
        $this->addSql('ALTER TABLE clinic_info CHANGE webpage webpage VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE phone_number phone_number VARCHAR(32) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sending_to_doctor CHANGE description description VARCHAR(2000) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user_info DROP INDEX IDX_B1087D9E9D86650F, ADD UNIQUE INDEX UNIQ_B1087D9E9D86650F (user_id_id)');
        $this->addSql('ALTER TABLE user_info CHANGE user_id_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_visit DROP is_completed');
    }
}
