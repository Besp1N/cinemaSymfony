<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240124142021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achievements (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, path_to_svg VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_achievements (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, achievement_id INT DEFAULT NULL, INDEX IDX_51EE02FCA76ED395 (user_id), INDEX IDX_51EE02FCB3EC99FE (achievement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_achievements ADD CONSTRAINT FK_51EE02FCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_achievements ADD CONSTRAINT FK_51EE02FCB3EC99FE FOREIGN KEY (achievement_id) REFERENCES achievements (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_achievements DROP FOREIGN KEY FK_51EE02FCA76ED395');
        $this->addSql('ALTER TABLE user_achievements DROP FOREIGN KEY FK_51EE02FCB3EC99FE');
        $this->addSql('DROP TABLE achievements');
        $this->addSql('DROP TABLE user_achievements');
    }
}
