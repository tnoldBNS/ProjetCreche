<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200928113820 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE galleries (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, nom_image VARCHAR(255) NOT NULL, crea_date DATETIME NOT NULL, album_prive TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galleries_enfants (galleries_id INT NOT NULL, enfants_id INT NOT NULL, INDEX IDX_900E5E85BA96467C (galleries_id), INDEX IDX_900E5E85A586286C (enfants_id), PRIMARY KEY(galleries_id, enfants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE galleries_enfants ADD CONSTRAINT FK_900E5E85BA96467C FOREIGN KEY (galleries_id) REFERENCES galleries (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE galleries_enfants ADD CONSTRAINT FK_900E5E85A586286C FOREIGN KEY (enfants_id) REFERENCES enfants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE effectifs CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE enfants CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE parents CHANGE updated_at updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE galleries_enfants DROP FOREIGN KEY FK_900E5E85BA96467C');
        $this->addSql('DROP TABLE galleries');
        $this->addSql('DROP TABLE galleries_enfants');
        $this->addSql('ALTER TABLE effectifs CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE enfants CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE parents CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }
}
