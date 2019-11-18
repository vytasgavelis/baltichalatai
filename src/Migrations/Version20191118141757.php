<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191118141757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('INSERT INTO symfony.user (id, role) VALUES (4707, 2);
INSERT INTO symfony.user (id, role) VALUES (4708, 1);
INSERT INTO symfony.user (id, role) VALUES (4709, 1);
INSERT INTO symfony.user (id, role) VALUES (4710, 1);
INSERT INTO symfony.user (id, role) VALUES (4711, 2);
INSERT INTO symfony.user (id, role) VALUES (4712, 2);
INSERT INTO symfony.user (id, role) VALUES (4713, 1);
INSERT INTO symfony.user (id, role) VALUES (4714, 1);
INSERT INTO symfony.user (id, role) VALUES (4715, 1);
INSERT INTO symfony.user (id, role) VALUES (4716, 2);
INSERT INTO symfony.user (id, role) VALUES (4717, 3);
INSERT INTO symfony.user (id, role) VALUES (4718, 1);
INSERT INTO symfony.user (id, role) VALUES (4719, 1);
INSERT INTO symfony.user (id, role) VALUES (4720, 1);
INSERT INTO symfony.user (id, role) VALUES (4721, 1);
INSERT INTO symfony.user (id, role) VALUES (4722, 1);
INSERT INTO symfony.user (id, role) VALUES (4723, 1);
INSERT INTO symfony.user (id, role) VALUES (4724, 1);
INSERT INTO symfony.user (id, role) VALUES (4725, 1);
INSERT INTO symfony.user (id, role) VALUES (4726, 2);
INSERT INTO symfony.user (id, role) VALUES (4727, 1);
INSERT INTO symfony.user (id, role) VALUES (4728, 1);
INSERT INTO symfony.user (id, role) VALUES (4729, 1);
INSERT INTO symfony.user (id, role) VALUES (4730, 1);
INSERT INTO symfony.user (id, role) VALUES (4731, 1);
INSERT INTO symfony.user (id, role) VALUES (4732, 2);
INSERT INTO symfony.user (id, role) VALUES (4733, 1);
INSERT INTO symfony.user (id, role) VALUES (4734, 1);
INSERT INTO symfony.user (id, role) VALUES (4735, 1);
INSERT INTO symfony.user (id, role) VALUES (4736, 1);
INSERT INTO symfony.user (id, role) VALUES (4737, 1);
INSERT INTO symfony.user (id, role) VALUES (4738, 2);
INSERT INTO symfony.user (id, role) VALUES (4739, 2);
INSERT INTO symfony.user (id, role) VALUES (4740, 1);
INSERT INTO symfony.user (id, role) VALUES (4741, 1);
INSERT INTO symfony.user (id, role) VALUES (4742, 1);
INSERT INTO symfony.user (id, role) VALUES (4743, 1);
INSERT INTO symfony.user (id, role) VALUES (4744, 3);
INSERT INTO symfony.user (id, role) VALUES (4745, 1);
INSERT INTO symfony.user (id, role) VALUES (4746, 1);
INSERT INTO symfony.user (id, role) VALUES (4747, 1);
INSERT INTO symfony.user (id, role) VALUES (4748, 1);
INSERT INTO symfony.user (id, role) VALUES (4749, 1);
INSERT INTO symfony.user (id, role) VALUES (4750, 1);
INSERT INTO symfony.user (id, role) VALUES (4751, 1);
INSERT INTO symfony.user (id, role) VALUES (4752, 1);
INSERT INTO symfony.user (id, role) VALUES (4753, 1);
INSERT INTO symfony.user (id, role) VALUES (4754, 1);
INSERT INTO symfony.user (id, role) VALUES (4755, 2);
INSERT INTO symfony.user (id, role) VALUES (4756, 1);
INSERT INTO symfony.user (id, role) VALUES (4757, 1);
INSERT INTO symfony.user (id, role) VALUES (4758, 1);
INSERT INTO symfony.user (id, role) VALUES (4759, 1);
INSERT INTO symfony.user (id, role) VALUES (4760, 2);
INSERT INTO symfony.user (id, role) VALUES (4761, 1);
INSERT INTO symfony.user (id, role) VALUES (4762, 1);
INSERT INTO symfony.user (id, role) VALUES (4763, 1);
INSERT INTO symfony.user (id, role) VALUES (4764, 1);
INSERT INTO symfony.user (id, role) VALUES (4765, 1);
INSERT INTO symfony.user (id, role) VALUES (4766, 1);
INSERT INTO symfony.user (id, role) VALUES (4767, 1);
INSERT INTO symfony.user (id, role) VALUES (4768, 1);
INSERT INTO symfony.user (id, role) VALUES (4769, 1);
INSERT INTO symfony.user (id, role) VALUES (4770, 1);
INSERT INTO symfony.user (id, role) VALUES (4771, 1);
INSERT INTO symfony.user (id, role) VALUES (4772, 2);
INSERT INTO symfony.user (id, role) VALUES (4773, 1);
INSERT INTO symfony.user (id, role) VALUES (4774, 2);
INSERT INTO symfony.user (id, role) VALUES (4775, 1);
INSERT INTO symfony.user (id, role) VALUES (4776, 1);
INSERT INTO symfony.user (id, role) VALUES (4777, 1);
INSERT INTO symfony.user (id, role) VALUES (4778, 1);
INSERT INTO symfony.user (id, role) VALUES (4779, 1);
INSERT INTO symfony.user (id, role) VALUES (4780, 1);
INSERT INTO symfony.user (id, role) VALUES (4781, 1);
INSERT INTO symfony.user (id, role) VALUES (4782, 1);
INSERT INTO symfony.user (id, role) VALUES (4783, 3);
INSERT INTO symfony.user (id, role) VALUES (4784, 1);
INSERT INTO symfony.user (id, role) VALUES (4785, 1);
INSERT INTO symfony.user (id, role) VALUES (4786, 1);
INSERT INTO symfony.user (id, role) VALUES (4787, 2);
INSERT INTO symfony.user (id, role) VALUES (4788, 1);
INSERT INTO symfony.user (id, role) VALUES (4789, 1);
INSERT INTO symfony.user (id, role) VALUES (4790, 1);
INSERT INTO symfony.user (id, role) VALUES (4791, 1);
INSERT INTO symfony.user (id, role) VALUES (4792, 2);
INSERT INTO symfony.user (id, role) VALUES (4793, 1);
INSERT INTO symfony.user (id, role) VALUES (4794, 1);
INSERT INTO symfony.user (id, role) VALUES (4795, 2);
INSERT INTO symfony.user (id, role) VALUES (4796, 1);
INSERT INTO symfony.user (id, role) VALUES (4797, 1);
INSERT INTO symfony.user (id, role) VALUES (4798, 1);
INSERT INTO symfony.user (id, role) VALUES (4799, 1);
INSERT INTO symfony.user (id, role) VALUES (4800, 2);
INSERT INTO symfony.user (id, role) VALUES (4801, 1);
INSERT INTO symfony.user (id, role) VALUES (4802, 1);
INSERT INTO symfony.user (id, role) VALUES (4803, 1);
INSERT INTO symfony.user (id, role) VALUES (4804, 1);
INSERT INTO symfony.user (id, role) VALUES (4805, 1);
INSERT INTO symfony.user (id, role) VALUES (4806, 2);
');
    }

    public function down(Schema $schema): void
    {

    }
}
