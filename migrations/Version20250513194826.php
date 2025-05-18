<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250513194826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE friend_request (id SERIAL NOT NULL, sender_id INT NOT NULL, recipient_id INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F284D94F624B39D ON friend_request (sender_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F284D94E92F8F78 ON friend_request (recipient_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE friendship (id SERIAL NOT NULL, person_a_id INT NOT NULL, person_b_id INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7234A45FB138D773 ON friendship (person_a_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7234A45FA38D789D ON friendship (person_b_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE friend_request ADD CONSTRAINT FK_F284D94F624B39D FOREIGN KEY (sender_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE friend_request ADD CONSTRAINT FK_F284D94E92F8F78 FOREIGN KEY (recipient_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE friendship ADD CONSTRAINT FK_7234A45FB138D773 FOREIGN KEY (person_a_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE friendship ADD CONSTRAINT FK_7234A45FA38D789D FOREIGN KEY (person_b_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE friend_request DROP CONSTRAINT FK_F284D94F624B39D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE friend_request DROP CONSTRAINT FK_F284D94E92F8F78
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE friendship DROP CONSTRAINT FK_7234A45FB138D773
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE friendship DROP CONSTRAINT FK_7234A45FA38D789D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE friend_request
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE friendship
        SQL);
    }
}
