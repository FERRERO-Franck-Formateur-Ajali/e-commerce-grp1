<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210715135436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse_facturation ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE adresse_facturation ADD CONSTRAINT FK_D9E5A8D519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_D9E5A8D519EB6921 ON adresse_facturation (client_id)');
        $this->addSql('ALTER TABLE adresse_livraison ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE adresse_livraison ADD CONSTRAINT FK_B0B09C919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_B0B09C919EB6921 ON adresse_livraison (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse_facturation DROP FOREIGN KEY FK_D9E5A8D519EB6921');
        $this->addSql('DROP INDEX IDX_D9E5A8D519EB6921 ON adresse_facturation');
        $this->addSql('ALTER TABLE adresse_facturation DROP client_id');
        $this->addSql('ALTER TABLE adresse_livraison DROP FOREIGN KEY FK_B0B09C919EB6921');
        $this->addSql('DROP INDEX IDX_B0B09C919EB6921 ON adresse_livraison');
        $this->addSql('ALTER TABLE adresse_livraison DROP client_id');
    }
}
