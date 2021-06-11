<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210606091804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrower DROP FOREIGN KEY FK_DB904DB4CE73868F');
        $this->addSql('DROP TABLE borrower');
        $this->addSql('DROP TABLE loan');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE borrower (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, loan_id INT DEFAULT NULL, firstname VARCHAR(190) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lastname VARCHAR(190) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, phone VARCHAR(190) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, active TINYINT(1) NOT NULL, creation_date DATETIME NOT NULL, modification_date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_DB904DB4A76ED395 (user_id), INDEX IDX_DB904DB4CE73868F (loan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE loan (id INT AUTO_INCREMENT NOT NULL, borrowing_date DATETIME NOT NULL, return_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE borrower ADD CONSTRAINT FK_DB904DB4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE borrower ADD CONSTRAINT FK_DB904DB4CE73868F FOREIGN KEY (loan_id) REFERENCES loan (id)');
    }
}
