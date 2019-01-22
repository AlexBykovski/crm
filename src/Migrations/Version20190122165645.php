<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190122165645 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE delivery_detail (id INT AUTO_INCREMENT NOT NULL, document_request_id INT DEFAULT NULL, delivery_date DATETIME DEFAULT NULL, delivery_time VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, station VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_3017861DE3BD13F3 (document_request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_detail (id INT AUTO_INCREMENT NOT NULL, document_request_id INT DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, district VARCHAR(255) DEFAULT NULL, boss_last_name VARCHAR(255) DEFAULT NULL, department VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_9064CEF5E3BD13F3 (document_request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delivery_detail ADD CONSTRAINT FK_3017861DE3BD13F3 FOREIGN KEY (document_request_id) REFERENCES document_request (id)');
        $this->addSql('ALTER TABLE document_detail ADD CONSTRAINT FK_9064CEF5E3BD13F3 FOREIGN KEY (document_request_id) REFERENCES document_request (id)');
        $this->addSql('ALTER TABLE document_request ADD responsible_manager VARCHAR(255) DEFAULT NULL, ADD budget VARCHAR(255) DEFAULT NULL, ADD is_back_dating TINYINT(1) DEFAULT \'0\' NOT NULL, ADD register_from DATETIME DEFAULT NULL, ADD register_to DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE delivery_detail');
        $this->addSql('DROP TABLE document_detail');
        $this->addSql('ALTER TABLE document_request DROP responsible_manager, DROP budget, DROP is_back_dating, DROP register_from, DROP register_to');
    }
}
