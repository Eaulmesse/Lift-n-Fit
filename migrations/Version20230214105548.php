<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214105548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EC60B243');
        $this->addSql('DROP INDEX IDX_8D93D649EC60B243 ON user');
        $this->addSql('ALTER TABLE user DROP post_reponse_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD post_reponse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EC60B243 FOREIGN KEY (post_reponse_id) REFERENCES post_reponse (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649EC60B243 ON user (post_reponse_id)');
    }
}
