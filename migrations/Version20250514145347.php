<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250514145347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE conversation_profile (conversation_id INT NOT NULL, profile_id INT NOT NULL, PRIMARY KEY(conversation_id, profile_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1A01A4059AC0396 ON conversation_profile (conversation_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1A01A405CCFA12B8 ON conversation_profile (profile_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conversation_profile ADD CONSTRAINT FK_1A01A4059AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conversation_profile ADD CONSTRAINT FK_1A01A405CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conversation DROP CONSTRAINT fk_8a8e26e9838709d5
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_8a8e26e9838709d5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conversation DROP participants_id
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conversation_profile DROP CONSTRAINT FK_1A01A4059AC0396
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conversation_profile DROP CONSTRAINT FK_1A01A405CCFA12B8
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE conversation_profile
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conversation ADD participants_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conversation ADD CONSTRAINT fk_8a8e26e9838709d5 FOREIGN KEY (participants_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_8a8e26e9838709d5 ON conversation (participants_id)
        SQL);
    }
}
