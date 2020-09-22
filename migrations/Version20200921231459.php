<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200921231459 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absences (id INT AUTO_INCREMENT NOT NULL, effectifs_id INT DEFAULT NULL, enfants_id INT DEFAULT NULL, motif VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_F9C0EFFF2608AD9F (effectifs_id), INDEX IDX_F9C0EFFFA586286C (enfants_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commissions (id INT AUTO_INCREMENT NOT NULL, nom_commission VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE effectifs (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, nom_image VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, cp VARCHAR(20) NOT NULL, ville VARCHAR(50) NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_D144B81167B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enfants (id INT AUTO_INCREMENT NOT NULL, familles_id INT NOT NULL, commissions_id INT DEFAULT NULL, nom_image VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, nationnalit VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, date_arrivee DATE NOT NULL, date_depart DATE DEFAULT NULL, lieu_naissance VARCHAR(255) NOT NULL, rgpd TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_23E2BAC3D335D67 (familles_id), INDEX IDX_23E2BAC3C23E429B (commissions_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE familles (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_9F94FD2767B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galleries (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, nom_image VARCHAR(255) NOT NULL, crea_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galleries_enfants (galleries_id INT NOT NULL, enfants_id INT NOT NULL, INDEX IDX_900E5E85BA96467C (galleries_id), INDEX IDX_900E5E85A586286C (enfants_id), PRIMARY KEY(galleries_id, enfants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, sujets_id INT DEFAULT NULL, users_id INT DEFAULT NULL, sondages_id INT DEFAULT NULL, contenu LONGTEXT NOT NULL, crea_date DATETIME NOT NULL, INDEX IDX_DB021E9650B0AC57 (sujets_id), INDEX IDX_DB021E9667B3B43D (users_id), UNIQUE INDEX UNIQ_DB021E9665C3BD4A (sondages_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parents (id INT AUTO_INCREMENT NOT NULL, familles_id INT NOT NULL, nom_image VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, langue_maternelle VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, adresse LONGTEXT NOT NULL, cp VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_FD501D6AD335D67 (familles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pointeuse (id INT AUTO_INCREMENT NOT NULL, effectifs_id INT DEFAULT NULL, parents_id INT DEFAULT NULL, enfants_id INT DEFAULT NULL, arrivee DATETIME NOT NULL, depart DATETIME DEFAULT NULL, INDEX IDX_58EB56172608AD9F (effectifs_id), INDEX IDX_58EB5617B706B6D3 (parents_id), INDEX IDX_58EB5617A586286C (enfants_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponses (id INT AUTO_INCREMENT NOT NULL, sondages_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, INDEX IDX_1E512EC665C3BD4A (sondages_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponses_users (reponses_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_42F2C304E4084792 (reponses_id), INDEX IDX_42F2C30467B3B43D (users_id), PRIMARY KEY(reponses_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sondages (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sujets (id INT AUTO_INCREMENT NOT NULL, themes_id INT DEFAULT NULL, users_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, create_date DATETIME NOT NULL, INDEX IDX_959E33AB94F4A9D2 (themes_id), INDEX IDX_959E33AB67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE themes (id INT AUTO_INCREMENT NOT NULL, nom_theme VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tickets (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, INDEX IDX_54469DF467B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tickets_commissions (tickets_id INT NOT NULL, commissions_id INT NOT NULL, INDEX IDX_C90DCF978FDC0E9A (tickets_id), INDEX IDX_C90DCF97C23E429B (commissions_id), PRIMARY KEY(tickets_id, commissions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transmission (id INT AUTO_INCREMENT NOT NULL, pointeuse_id INT NOT NULL, type VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, INDEX IDX_7F87199FA411B1BF (pointeuse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(70) NOT NULL, telephone VARCHAR(50) NOT NULL, register_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absences ADD CONSTRAINT FK_F9C0EFFF2608AD9F FOREIGN KEY (effectifs_id) REFERENCES effectifs (id)');
        $this->addSql('ALTER TABLE absences ADD CONSTRAINT FK_F9C0EFFFA586286C FOREIGN KEY (enfants_id) REFERENCES enfants (id)');
        $this->addSql('ALTER TABLE effectifs ADD CONSTRAINT FK_D144B81167B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE enfants ADD CONSTRAINT FK_23E2BAC3D335D67 FOREIGN KEY (familles_id) REFERENCES familles (id)');
        $this->addSql('ALTER TABLE enfants ADD CONSTRAINT FK_23E2BAC3C23E429B FOREIGN KEY (commissions_id) REFERENCES commissions (id)');
        $this->addSql('ALTER TABLE familles ADD CONSTRAINT FK_9F94FD2767B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE galleries_enfants ADD CONSTRAINT FK_900E5E85BA96467C FOREIGN KEY (galleries_id) REFERENCES galleries (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE galleries_enfants ADD CONSTRAINT FK_900E5E85A586286C FOREIGN KEY (enfants_id) REFERENCES enfants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9650B0AC57 FOREIGN KEY (sujets_id) REFERENCES sujets (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9667B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9665C3BD4A FOREIGN KEY (sondages_id) REFERENCES sondages (id)');
        $this->addSql('ALTER TABLE parents ADD CONSTRAINT FK_FD501D6AD335D67 FOREIGN KEY (familles_id) REFERENCES familles (id)');
        $this->addSql('ALTER TABLE pointeuse ADD CONSTRAINT FK_58EB56172608AD9F FOREIGN KEY (effectifs_id) REFERENCES effectifs (id)');
        $this->addSql('ALTER TABLE pointeuse ADD CONSTRAINT FK_58EB5617B706B6D3 FOREIGN KEY (parents_id) REFERENCES parents (id)');
        $this->addSql('ALTER TABLE pointeuse ADD CONSTRAINT FK_58EB5617A586286C FOREIGN KEY (enfants_id) REFERENCES enfants (id)');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC665C3BD4A FOREIGN KEY (sondages_id) REFERENCES sondages (id)');
        $this->addSql('ALTER TABLE reponses_users ADD CONSTRAINT FK_42F2C304E4084792 FOREIGN KEY (reponses_id) REFERENCES reponses (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponses_users ADD CONSTRAINT FK_42F2C30467B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sujets ADD CONSTRAINT FK_959E33AB94F4A9D2 FOREIGN KEY (themes_id) REFERENCES themes (id)');
        $this->addSql('ALTER TABLE sujets ADD CONSTRAINT FK_959E33AB67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF467B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tickets_commissions ADD CONSTRAINT FK_C90DCF978FDC0E9A FOREIGN KEY (tickets_id) REFERENCES tickets (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tickets_commissions ADD CONSTRAINT FK_C90DCF97C23E429B FOREIGN KEY (commissions_id) REFERENCES commissions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transmission ADD CONSTRAINT FK_7F87199FA411B1BF FOREIGN KEY (pointeuse_id) REFERENCES pointeuse (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enfants DROP FOREIGN KEY FK_23E2BAC3C23E429B');
        $this->addSql('ALTER TABLE tickets_commissions DROP FOREIGN KEY FK_C90DCF97C23E429B');
        $this->addSql('ALTER TABLE absences DROP FOREIGN KEY FK_F9C0EFFF2608AD9F');
        $this->addSql('ALTER TABLE pointeuse DROP FOREIGN KEY FK_58EB56172608AD9F');
        $this->addSql('ALTER TABLE absences DROP FOREIGN KEY FK_F9C0EFFFA586286C');
        $this->addSql('ALTER TABLE galleries_enfants DROP FOREIGN KEY FK_900E5E85A586286C');
        $this->addSql('ALTER TABLE pointeuse DROP FOREIGN KEY FK_58EB5617A586286C');
        $this->addSql('ALTER TABLE enfants DROP FOREIGN KEY FK_23E2BAC3D335D67');
        $this->addSql('ALTER TABLE parents DROP FOREIGN KEY FK_FD501D6AD335D67');
        $this->addSql('ALTER TABLE galleries_enfants DROP FOREIGN KEY FK_900E5E85BA96467C');
        $this->addSql('ALTER TABLE pointeuse DROP FOREIGN KEY FK_58EB5617B706B6D3');
        $this->addSql('ALTER TABLE transmission DROP FOREIGN KEY FK_7F87199FA411B1BF');
        $this->addSql('ALTER TABLE reponses_users DROP FOREIGN KEY FK_42F2C304E4084792');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E9665C3BD4A');
        $this->addSql('ALTER TABLE reponses DROP FOREIGN KEY FK_1E512EC665C3BD4A');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E9650B0AC57');
        $this->addSql('ALTER TABLE sujets DROP FOREIGN KEY FK_959E33AB94F4A9D2');
        $this->addSql('ALTER TABLE tickets_commissions DROP FOREIGN KEY FK_C90DCF978FDC0E9A');
        $this->addSql('ALTER TABLE effectifs DROP FOREIGN KEY FK_D144B81167B3B43D');
        $this->addSql('ALTER TABLE familles DROP FOREIGN KEY FK_9F94FD2767B3B43D');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E9667B3B43D');
        $this->addSql('ALTER TABLE reponses_users DROP FOREIGN KEY FK_42F2C30467B3B43D');
        $this->addSql('ALTER TABLE sujets DROP FOREIGN KEY FK_959E33AB67B3B43D');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF467B3B43D');
        $this->addSql('DROP TABLE absences');
        $this->addSql('DROP TABLE commissions');
        $this->addSql('DROP TABLE effectifs');
        $this->addSql('DROP TABLE enfants');
        $this->addSql('DROP TABLE familles');
        $this->addSql('DROP TABLE galleries');
        $this->addSql('DROP TABLE galleries_enfants');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE parents');
        $this->addSql('DROP TABLE pointeuse');
        $this->addSql('DROP TABLE reponses');
        $this->addSql('DROP TABLE reponses_users');
        $this->addSql('DROP TABLE sondages');
        $this->addSql('DROP TABLE sujets');
        $this->addSql('DROP TABLE themes');
        $this->addSql('DROP TABLE tickets');
        $this->addSql('DROP TABLE tickets_commissions');
        $this->addSql('DROP TABLE transmission');
        $this->addSql('DROP TABLE users');
    }
}
