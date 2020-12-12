<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201029144120 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE text_word_relation (text_item_id INT NOT NULL, word_item_id INT NOT NULL, count INT NOT NULL, INDEX IDX_3A190B6936CE7D61 (text_item_id), INDEX IDX_3A190B69181D25AD (word_item_id), PRIMARY KEY(text_item_id, word_item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE word_alias (id INT AUTO_INCREMENT NOT NULL, word_item_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3FDF6052181D25AD (word_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(64) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE text_item (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE word_item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, black_listed TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_178E26F35E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE text_word_relation ADD CONSTRAINT FK_3A190B6936CE7D61 FOREIGN KEY (text_item_id) REFERENCES text_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE text_word_relation ADD CONSTRAINT FK_3A190B69181D25AD FOREIGN KEY (word_item_id) REFERENCES word_item (id)');
        $this->addSql('ALTER TABLE word_alias ADD CONSTRAINT FK_3FDF6052181D25AD FOREIGN KEY (word_item_id) REFERENCES word_item (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE text_word_relation DROP FOREIGN KEY FK_3A190B6936CE7D61');
        $this->addSql('ALTER TABLE text_word_relation DROP FOREIGN KEY FK_3A190B69181D25AD');
        $this->addSql('ALTER TABLE word_alias DROP FOREIGN KEY FK_3FDF6052181D25AD');
        $this->addSql('DROP TABLE text_word_relation');
        $this->addSql('DROP TABLE word_alias');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE text_item');
        $this->addSql('DROP TABLE word_item');
    }
}
