<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190216105617 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE document_detail ADD house VARCHAR(255) DEFAULT NULL, ADD apartment VARCHAR(255) DEFAULT NULL, ADD region VARCHAR(255) DEFAULT NULL, ADD subway VARCHAR(255) DEFAULT NULL, CHANGE boss_last_name boss_fio VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE document_request ADD series VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE document_detail ADD boss_last_name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP boss_fio, DROP house, DROP apartment, DROP region, DROP subway');
        $this->addSql('ALTER TABLE document_request DROP series');
    }
}
