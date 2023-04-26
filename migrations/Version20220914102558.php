<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220914102558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qna ADD user_id INT DEFAULT NULL, ADD project_id INT DEFAULT NULL, DROP project, DROP user');
        $this->addSql('ALTER TABLE qna ADD CONSTRAINT FK_6BB9CC92A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE qna ADD CONSTRAINT FK_6BB9CC92166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_6BB9CC92A76ED395 ON qna (user_id)');
        $this->addSql('CREATE INDEX IDX_6BB9CC92166D1F9C ON qna (project_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qna DROP FOREIGN KEY FK_6BB9CC92A76ED395');
        $this->addSql('ALTER TABLE qna DROP FOREIGN KEY FK_6BB9CC92166D1F9C');
        $this->addSql('DROP INDEX IDX_6BB9CC92A76ED395 ON qna');
        $this->addSql('DROP INDEX IDX_6BB9CC92166D1F9C ON qna');
        $this->addSql('ALTER TABLE qna ADD project VARCHAR(255) DEFAULT NULL, ADD user VARCHAR(255) NOT NULL, DROP user_id, DROP project_id');
    }
}
