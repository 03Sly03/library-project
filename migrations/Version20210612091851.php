<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210612091851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_type (book_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_95431C2116A2B381 (book_id), INDEX IDX_95431C21C54C8C93 (type_id), PRIMARY KEY(book_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_type ADD CONSTRAINT FK_95431C2116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_type ADD CONSTRAINT FK_95431C21C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE type_book');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_book (type_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_1CEA6639C54C8C93 (type_id), INDEX IDX_1CEA663916A2B381 (book_id), PRIMARY KEY(type_id, book_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE type_book ADD CONSTRAINT FK_1CEA663916A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_book ADD CONSTRAINT FK_1CEA6639C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE book_type');
    }
}
