<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201212183515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create cat table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE cat (
                id INT AUTO_INCREMENT NOT NULL,
                email VARCHAR(255) NOT NULL,
                age INT NOT NULL,
                height DOUBLE PRECISION NOT NULL,
                has_drive_licence TINYINT(1) NOT NULL,
                created_at DATETIME NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE cat');
    }
}
