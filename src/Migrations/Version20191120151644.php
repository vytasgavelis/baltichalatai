<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191120151644 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE clinic_info CHANGE webpage webpage VARCHAR(255) DEFAULT NULL, CHANGE phone_number phone_number VARCHAR(32) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD email VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('ALTER TABLE user_visit CHANGE sending_to_doctor_id_id sending_to_doctor_id_id INT DEFAULT NULL, CHANGE recipe_id_id recipe_id_id INT DEFAULT NULL, CHANGE is_completed is_completed TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_info CHANGE user_id_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sending_to_doctor CHANGE description description VARCHAR(2000) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE clinic_info CHANGE webpage webpage VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE phone_number phone_number VARCHAR(32) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sending_to_doctor CHANGE description description VARCHAR(2000) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user DROP email, DROP roles, DROP password');
        $this->addSql('ALTER TABLE user_info CHANGE user_id_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_visit CHANGE sending_to_doctor_id_id sending_to_doctor_id_id INT DEFAULT NULL, CHANGE recipe_id_id recipe_id_id INT DEFAULT NULL, CHANGE is_completed is_completed TINYINT(1) DEFAULT \'NULL\'');
    }
}
