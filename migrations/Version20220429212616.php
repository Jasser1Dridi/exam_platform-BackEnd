<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220429212616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE compagne_examen_candidat (compagne_examen_id INT NOT NULL, candidat_id INT NOT NULL, INDEX IDX_1F2574EFC00A3012 (compagne_examen_id), INDEX IDX_1F2574EF8D0EB82 (candidat_id), PRIMARY KEY(compagne_examen_id, candidat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE examen (id INT AUTO_INCREMENT NOT NULL, compagne_examen_id INT DEFAULT NULL, INDEX IDX_514C8FECC00A3012 (compagne_examen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone_number INT NOT NULL, adresse VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compagne_examen_candidat ADD CONSTRAINT FK_1F2574EFC00A3012 FOREIGN KEY (compagne_examen_id) REFERENCES compagne_examen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE compagne_examen_candidat ADD CONSTRAINT FK_1F2574EF8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FECC00A3012 FOREIGN KEY (compagne_examen_id) REFERENCES compagne_examen (id)');
        $this->addSql('ALTER TABLE candidat CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B471BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entrerpise CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE entrerpise ADD CONSTRAINT FK_DDD0618BBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaire ADD examen_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF5C8659A FOREIGN KEY (examen_id) REFERENCES examen (id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF5C8659A ON questionnaire (examen_id)');
        $this->addSql('ALTER TABLE super_admin CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE super_admin ADD CONSTRAINT FK_BC8C2783BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF5C8659A');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B471BF396750');
        $this->addSql('ALTER TABLE entrerpise DROP FOREIGN KEY FK_DDD0618BBF396750');
        $this->addSql('ALTER TABLE super_admin DROP FOREIGN KEY FK_BC8C2783BF396750');
        $this->addSql('DROP TABLE compagne_examen_candidat');
        $this->addSql('DROP TABLE examen');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE candidat CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE entrerpise CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('DROP INDEX IDX_7A64DAF5C8659A ON questionnaire');
        $this->addSql('ALTER TABLE questionnaire DROP examen_id');
        $this->addSql('ALTER TABLE super_admin CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
