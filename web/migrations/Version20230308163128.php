<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308163128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog DROP image_b');
        $this->addSql('ALTER TABLE user CHANGE isactive isactive INT NOT NULL, CHANGE reset_token reset_token VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog ADD image_b VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE isactive isactive INT DEFAULT NULL, CHANGE reset_token reset_token VARCHAR(255) DEFAULT NULL');
    }
}
