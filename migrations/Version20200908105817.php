<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200908105817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE data_mod (id INT AUTO_INCREMENT NOT NULL, smartmod_id INT NOT NULL, pmax DOUBLE PRECISION DEFAULT NULL, pmoy DOUBLE PRECISION DEFAULT NULL, qmax DOUBLE PRECISION DEFAULT NULL, qmoy DOUBLE PRECISION DEFAULT NULL, smax DOUBLE PRECISION DEFAULT NULL, smoy DOUBLE PRECISION DEFAULT NULL, cosmin DOUBLE PRECISION DEFAULT NULL, cosmn DOUBLE PRECISION DEFAULT NULL, vmin DOUBLE PRECISION DEFAULT NULL, vmax DOUBLE PRECISION DEFAULT NULL, vmoy DOUBLE PRECISION DEFAULT NULL, ea DOUBLE PRECISION DEFAULT NULL, er DOUBLE PRECISION DEFAULT NULL, eaindex DOUBLE PRECISION DEFAULT NULL, INDEX IDX_5378B2FD17587D82 (smartmod_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE data_mod ADD CONSTRAINT FK_5378B2FD17587D82 FOREIGN KEY (smartmod_id) REFERENCES devices (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE data_mod');
    }
}
