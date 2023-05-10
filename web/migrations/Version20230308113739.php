<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308113739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D89663B89');
        $this->addSql('DROP INDEX UNIQ_6EEAA67D89663B89 ON commande');
        $this->addSql('ALTER TABLE commande ADD mail_client VARCHAR(255) NOT NULL, ADD adresse_livraison VARCHAR(255) NOT NULL, ADD status VARCHAR(255) NOT NULL, DROP totalproduit, DROP status_cm, CHANGE idpanier_id panier_id INT DEFAULT NULL, CHANGE date_cm date_commande DATE NOT NULL, CHANGE adresselivraison nom_client VARCHAR(255) NOT NULL, CHANGE prixtot prix_total DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DF77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EEAA67DF77D927C ON commande (panier_id)');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF240AA24C7');
        $this->addSql('DROP INDEX IDX_24CC0DF240AA24C7 ON panier');
        $this->addSql('ALTER TABLE panier DROP iduserpanier_id, DROP prixtotal, CHANGE quantite quantite INT DEFAULT NULL, CHANGE date date_ajout DATE NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE isactive isactive INT NOT NULL, CHANGE reset_token reset_token VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DF77D927C');
        $this->addSql('DROP INDEX UNIQ_6EEAA67DF77D927C ON commande');
        $this->addSql('ALTER TABLE commande ADD totalproduit INT NOT NULL, ADD adresselivraison VARCHAR(255) NOT NULL, ADD status_cm INT NOT NULL, DROP nom_client, DROP mail_client, DROP adresse_livraison, DROP status, CHANGE panier_id idpanier_id INT DEFAULT NULL, CHANGE date_commande date_cm DATE NOT NULL, CHANGE prix_total prixtot DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D89663B89 FOREIGN KEY (idpanier_id) REFERENCES panier (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EEAA67D89663B89 ON commande (idpanier_id)');
        $this->addSql('ALTER TABLE panier ADD iduserpanier_id INT DEFAULT NULL, ADD prixtotal DOUBLE PRECISION NOT NULL, CHANGE quantite quantite INT NOT NULL, CHANGE date_ajout date DATE NOT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF240AA24C7 FOREIGN KEY (iduserpanier_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF240AA24C7 ON panier (iduserpanier_id)');
        $this->addSql('ALTER TABLE user CHANGE isactive isactive INT DEFAULT NULL, CHANGE reset_token reset_token VARCHAR(255) DEFAULT NULL');
    }
}
