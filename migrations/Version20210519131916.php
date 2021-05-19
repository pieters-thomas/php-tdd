<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210519131916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bookings (id INT AUTO_INCREMENT NOT NULL, booked_by_id INT NOT NULL, booked_room_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_7A853C35F4A5BD90 (booked_by_id), INDEX IDX_7A853C35CF848E36 (booked_room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, only_for_premium_members TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C35F4A5BD90 FOREIGN KEY (booked_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C35CF848E36 FOREIGN KEY (booked_room_id) REFERENCES room (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY FK_7A853C35CF848E36');
        $this->addSql('DROP TABLE bookings');
        $this->addSql('DROP TABLE room');
    }
}
