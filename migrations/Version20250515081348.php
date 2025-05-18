<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250515081348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE follow (id SERIAL NOT NULL, author_id INT NOT NULL, target_id INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_68344470F675F31B ON follow (author_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_68344470158E0B66 ON follow (target_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE follow ADD CONSTRAINT FK_68344470F675F31B FOREIGN KEY (author_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE follow ADD CONSTRAINT FK_68344470158E0B66 FOREIGN KEY (target_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE follow DROP CONSTRAINT FK_68344470F675F31B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE follow DROP CONSTRAINT FK_68344470158E0B66
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE follow
        SQL);
    }
}
