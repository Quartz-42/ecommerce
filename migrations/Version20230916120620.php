<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230916120620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function down(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ALTER is_verified SET NOT NULL');
    }

    public function up(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
