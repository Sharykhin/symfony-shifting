<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190125140254 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->connection->exec('
        CREATE PROCEDURE createOrUpdateReport(IN userId INT, IN dt DATE, IN amountVal DECIMAL(10,2))
        BEGIN
            DECLARE reportID int DEFAULT null;
            SELECT id INTO reportID FROM reports where `user_id`=userId and `date`=dt FOR UPDATE;
            if reportID IS NULL THEN
                INSERT INTO reports(`user_id`, `amount`, `date`) VALUES(userId, amountVal, dt);
            ELSE
                UPDATE reports SET `amount`=amount + amountVal WHERE `id`=reportID;
            END IF;
        END;
        ');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->connection->exec('DROP  PROCEDURE IF EXISTS createOrUpdateReport;');
    }
}
