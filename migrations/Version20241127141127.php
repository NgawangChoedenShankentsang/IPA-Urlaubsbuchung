<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241127141127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE holiday (id INT AUTO_INCREMENT NOT NULL, status_id_id INT NOT NULL, employee_id_id INT NOT NULL, type_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_DC9AB234881ECFA7 (status_id_id), INDEX IDX_DC9AB2349749932E (employee_id_id), INDEX IDX_DC9AB234714819A0 (type_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE holiday ADD CONSTRAINT FK_DC9AB234881ECFA7 FOREIGN KEY (status_id_id) REFERENCES holiday_status (id)');
        $this->addSql('ALTER TABLE holiday ADD CONSTRAINT FK_DC9AB2349749932E FOREIGN KEY (employee_id_id) REFERENCES employees (id)');
        $this->addSql('ALTER TABLE holiday ADD CONSTRAINT FK_DC9AB234714819A0 FOREIGN KEY (type_id_id) REFERENCES holiday_types (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE holiday DROP FOREIGN KEY FK_DC9AB234881ECFA7');
        $this->addSql('ALTER TABLE holiday DROP FOREIGN KEY FK_DC9AB2349749932E');
        $this->addSql('ALTER TABLE holiday DROP FOREIGN KEY FK_DC9AB234714819A0');
        $this->addSql('DROP TABLE holiday');
    }
}
