<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220429204217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidat (id INT AUTO_INCREMENT NOT NULL, cin INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidat_reponse (candidat_id INT NOT NULL, reponse_id INT NOT NULL, INDEX IDX_6BB282D8D0EB82 (candidat_id), INDEX IDX_6BB282DCF18BB82 (reponse_id), PRIMARY KEY(candidat_id, reponse_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compagne_examen (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrerpise (id INT AUTO_INCREMENT NOT NULL, domaine VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exam (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, duration DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, domaine VARCHAR(255) NOT NULL, points VARCHAR(255) NOT NULL, managed_by VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, reponse VARCHAR(255) NOT NULL, istrue TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE super_admin (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidat_reponse ADD CONSTRAINT FK_6BB282D8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidat_reponse ADD CONSTRAINT FK_6BB282DCF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD id INT AUTO_INCREMENT NOT NULL, ADD email VARCHAR(255) NOT NULL, DROP token, CHANGE phone_number phone_number INT NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat_reponse DROP FOREIGN KEY FK_6BB282D8D0EB82');
        $this->addSql('ALTER TABLE candidat_reponse DROP FOREIGN KEY FK_6BB282DCF18BB82');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE candidat_reponse');
        $this->addSql('DROP TABLE compagne_examen');
        $this->addSql('DROP TABLE entrerpise');
        $this->addSql('DROP TABLE exam');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE super_admin');
        $this->addSql('ALTER TABLE user MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user ADD token VARCHAR(45) NOT NULL, DROP id, DROP email, CHANGE phone_number phone_number INT DEFAULT NULL, CHANGE adresse adresse LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD PRIMARY KEY (token)');
    }
}
