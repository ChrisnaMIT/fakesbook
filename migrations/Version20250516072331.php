<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250516072331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE share (id SERIAL NOT NULL, sender_id INT NOT NULL, recipient_id INT NOT NULL, post_id INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EF069D5AF624B39D ON share (sender_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EF069D5AE92F8F78 ON share (recipient_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EF069D5A4B89032C ON share (post_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE share ADD CONSTRAINT FK_EF069D5AF624B39D FOREIGN KEY (sender_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE share ADD CONSTRAINT FK_EF069D5AE92F8F78 FOREIGN KEY (recipient_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE share ADD CONSTRAINT FK_EF069D5A4B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE share DROP CONSTRAINT FK_EF069D5AF624B39D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE share DROP CONSTRAINT FK_EF069D5AE92F8F78
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE share DROP CONSTRAINT FK_EF069D5A4B89032C
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE share
        SQL);
    }
}
