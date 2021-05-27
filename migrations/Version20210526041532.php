<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210526041532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__score_list AS SELECT id, rundor, vunnit, procent FROM score_list');
        $this->addSql('DROP TABLE score_list');
        $this->addSql('CREATE TABLE score_list (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, rundor INTEGER NOT NULL, vunnit INTEGER NOT NULL, procent DOUBLE PRECISION NOT NULL, poeng INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO score_list (id, rundor, vunnit, procent) SELECT id, rundor, vunnit, procent FROM __temp__score_list');
        $this->addSql('DROP TABLE __temp__score_list');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__score_list AS SELECT id, rundor, vunnit, procent FROM score_list');
        $this->addSql('DROP TABLE score_list');
        $this->addSql('CREATE TABLE score_list (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, rundor INTEGER NOT NULL, vunnit INTEGER NOT NULL, procent INTEGER NOT NULL)');
        $this->addSql('INSERT INTO score_list (id, rundor, vunnit, procent) SELECT id, rundor, vunnit, procent FROM __temp__score_list');
        $this->addSql('DROP TABLE __temp__score_list');
    }
}
