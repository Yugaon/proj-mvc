<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210527020246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE score_list ADD COLUMN total_rundor INTEGER DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__score_list AS SELECT id, rundor, vunnit, procent, poeng FROM score_list');
        $this->addSql('DROP TABLE score_list');
        $this->addSql('CREATE TABLE score_list (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, rundor INTEGER NOT NULL, vunnit INTEGER NOT NULL, procent DOUBLE PRECISION NOT NULL, poeng INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO score_list (id, rundor, vunnit, procent, poeng) SELECT id, rundor, vunnit, procent, poeng FROM __temp__score_list');
        $this->addSql('DROP TABLE __temp__score_list');
    }
}
