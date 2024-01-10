<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240110164817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE seat (id INT AUTO_INCREMENT NOT NULL, move_theater_id_id INT DEFAULT NULL, seat_row VARCHAR(255) NOT NULL, seat_number VARCHAR(255) NOT NULL, seat_type VARCHAR(255) NOT NULL, INDEX IDX_3D5C3666B75856F (move_theater_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE seat ADD CONSTRAINT FK_3D5C3666B75856F FOREIGN KEY (move_theater_id_id) REFERENCES movie_theaters (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seat DROP FOREIGN KEY FK_3D5C3666B75856F');
        $this->addSql('DROP TABLE seat');
    }
}
