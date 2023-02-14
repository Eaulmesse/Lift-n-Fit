<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213143751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_reponse DROP FOREIGN KEY FK_625E69F4E85F12B8');
        $this->addSql('DROP INDEX IDX_625E69F4E85F12B8 ON post_reponse');
        $this->addSql('ALTER TABLE post_reponse ADD date DATETIME NOT NULL, CHANGE post_id post_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_reponse ADD CONSTRAINT FK_625E69F4E85F12B8 FOREIGN KEY (post_id_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_625E69F4E85F12B8 ON post_reponse (post_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_reponse DROP FOREIGN KEY FK_625E69F4E85F12B8');
        $this->addSql('DROP INDEX IDX_625E69F4E85F12B8 ON post_reponse');
        $this->addSql('ALTER TABLE post_reponse DROP date, CHANGE post_id_id post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_reponse ADD CONSTRAINT FK_625E69F4E85F12B8 FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_625E69F4E85F12B8 ON post_reponse (post_id)');
    }
}
