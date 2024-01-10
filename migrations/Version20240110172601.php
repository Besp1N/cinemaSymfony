<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240110172601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, duration TIME NOT NULL, description VARCHAR(500) NOT NULL, genre VARCHAR(255) NOT NULL, relase_year INT NOT NULL, director VARCHAR(255) NOT NULL, rating DOUBLE PRECISION NOT NULL, image VARCHAR(600) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE screaning (id INT AUTO_INCREMENT NOT NULL, movie_theater_id INT NOT NULL, movie_id INT NOT NULL, start_time DATETIME NOT NULL, INDEX IDX_42888FBD3EFE3445 (movie_theater_id), INDEX IDX_42888FBD8F93B6FC (movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE screaning ADD CONSTRAINT FK_42888FBD3EFE3445 FOREIGN KEY (movie_theater_id) REFERENCES movie_theaters (id)');
        $this->addSql('ALTER TABLE screaning ADD CONSTRAINT FK_42888FBD8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE screaning DROP FOREIGN KEY FK_42888FBD3EFE3445');
        $this->addSql('ALTER TABLE screaning DROP FOREIGN KEY FK_42888FBD8F93B6FC');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE screaning');
    }
}
