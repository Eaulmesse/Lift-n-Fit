<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214105841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_reponse ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_reponse ADD CONSTRAINT FK_625E69F4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_625E69F4A76ED395 ON post_reponse (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_reponse DROP FOREIGN KEY FK_625E69F4A76ED395');
        $this->addSql('DROP INDEX IDX_625E69F4A76ED395 ON post_reponse');
        $this->addSql('ALTER TABLE post_reponse DROP user_id');
    }
}
