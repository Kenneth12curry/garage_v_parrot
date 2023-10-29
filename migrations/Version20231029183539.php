<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231029183539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE administrateur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE employe_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE equipement_id_seq CASCADE');
        $this->addSql('ALTER TABLE equipement DROP CONSTRAINT fk_b8b4c6f34a4a3511');
        $this->addSql('DROP TABLE equipement');
        $this->addSql('ALTER TABLE administrateur ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE avis ALTER id DROP DEFAULT');
        $this->addSql('ALTER INDEX fk_avis_employe_id RENAME TO IDX_8F91ABF01B65292');
        $this->addSql('ALTER TABLE contact_form ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE employe ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE horaire ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE images ALTER id DROP DEFAULT');
        $this->addSql('ALTER INDEX fk_images_vehicule_id RENAME TO IDX_E01FBE6A4A4A3511');
        $this->addSql('ALTER TABLE service ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE "user" ALTER id DROP DEFAULT');
        $this->addSql('ALTER INDEX user_login_key RENAME TO UNIQ_8D93D649AA08CB10');
        $this->addSql('ALTER TABLE vehicule ALTER id DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE messenger_messages_id_seq');
        $this->addSql('SELECT setval(\'messenger_messages_id_seq\', (SELECT MAX(id) FROM messenger_messages))');
        $this->addSql('ALTER TABLE messenger_messages ALTER id SET DEFAULT nextval(\'messenger_messages_id_seq\')');
        $this->addSql('ALTER TABLE messenger_messages ADD PRIMARY KEY (id)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE administrateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE employe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE equipement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE equipement (id SERIAL NOT NULL, vehicule_id INT DEFAULT NULL, nom_equipement VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX fk_equipement_vehicule_id ON equipement (vehicule_id)');
        $this->addSql('ALTER TABLE equipement ADD CONSTRAINT fk_b8b4c6f34a4a3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE SEQUENCE user_id_seq');
        $this->addSql('SELECT setval(\'user_id_seq\', (SELECT MAX(id) FROM "user"))');
        $this->addSql('ALTER TABLE "user" ALTER id SET DEFAULT nextval(\'user_id_seq\')');
        $this->addSql('ALTER INDEX uniq_8d93d649aa08cb10 RENAME TO user_login_key');
        $this->addSql('CREATE SEQUENCE images_id_seq');
        $this->addSql('SELECT setval(\'images_id_seq\', (SELECT MAX(id) FROM images))');
        $this->addSql('ALTER TABLE images ALTER id SET DEFAULT nextval(\'images_id_seq\')');
        $this->addSql('ALTER INDEX idx_e01fbe6a4a4a3511 RENAME TO fk_images_vehicule_id');
        $this->addSql('ALTER TABLE messenger_messages DROP CONSTRAINT messenger_messages_pkey');
        $this->addSql('DROP INDEX IDX_75EA56E0FB7336F0');
        $this->addSql('DROP INDEX IDX_75EA56E0E3BD61CE');
        $this->addSql('DROP INDEX IDX_75EA56E016BA31DB');
        $this->addSql('ALTER TABLE messenger_messages ALTER id DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE avis_id_seq');
        $this->addSql('SELECT setval(\'avis_id_seq\', (SELECT MAX(id) FROM avis))');
        $this->addSql('ALTER TABLE avis ALTER id SET DEFAULT nextval(\'avis_id_seq\')');
        $this->addSql('ALTER INDEX idx_8f91abf01b65292 RENAME TO fk_avis_employe_id');
        $this->addSql('CREATE SEQUENCE administrateur_id_seq');
        $this->addSql('SELECT setval(\'administrateur_id_seq\', (SELECT MAX(id) FROM administrateur))');
        $this->addSql('ALTER TABLE administrateur ALTER id SET DEFAULT nextval(\'administrateur_id_seq\')');
        $this->addSql('CREATE SEQUENCE contact_form_id_seq');
        $this->addSql('SELECT setval(\'contact_form_id_seq\', (SELECT MAX(id) FROM contact_form))');
        $this->addSql('ALTER TABLE contact_form ALTER id SET DEFAULT nextval(\'contact_form_id_seq\')');
        $this->addSql('CREATE SEQUENCE vehicule_id_seq');
        $this->addSql('SELECT setval(\'vehicule_id_seq\', (SELECT MAX(id) FROM vehicule))');
        $this->addSql('ALTER TABLE vehicule ALTER id SET DEFAULT nextval(\'vehicule_id_seq\')');
        $this->addSql('CREATE SEQUENCE service_id_seq');
        $this->addSql('SELECT setval(\'service_id_seq\', (SELECT MAX(id) FROM service))');
        $this->addSql('ALTER TABLE service ALTER id SET DEFAULT nextval(\'service_id_seq\')');
        $this->addSql('CREATE SEQUENCE horaire_id_seq');
        $this->addSql('SELECT setval(\'horaire_id_seq\', (SELECT MAX(id) FROM horaire))');
        $this->addSql('ALTER TABLE horaire ALTER id SET DEFAULT nextval(\'horaire_id_seq\')');
        $this->addSql('CREATE SEQUENCE employe_id_seq');
        $this->addSql('SELECT setval(\'employe_id_seq\', (SELECT MAX(id) FROM employe))');
        $this->addSql('ALTER TABLE employe ALTER id SET DEFAULT nextval(\'employe_id_seq\')');
    }
}
