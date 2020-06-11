<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200610151454 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, short_content LONGTEXT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_tag (blog_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_6EC3989DAE07E97 (blog_id), INDEX IDX_6EC3989BAD26311 (tag_id), PRIMARY KEY(blog_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_sources (blog_id INT NOT NULL, sources_id INT NOT NULL, INDEX IDX_3EABD871DAE07E97 (blog_id), INDEX IDX_3EABD871DD51D0F7 (sources_id), PRIMARY KEY(blog_id, sources_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, devenir LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE collection_point (id INT AUTO_INCREMENT NOT NULL, collection_point_type_id INT NOT NULL, name VARCHAR(255) NOT NULL, street_number VARCHAR(45) NOT NULL, street_name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, coordinate_x DOUBLE PRECISION DEFAULT NULL, coordinate_y DOUBLE PRECISION DEFAULT NULL, opening_time LONGTEXT NOT NULL, review LONGTEXT DEFAULT NULL, phone VARCHAR(45) DEFAULT NULL, website LONGTEXT DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, INDEX IDX_F05D4B77A9B99F90 (collection_point_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE collection_point_material (collection_point_id INT NOT NULL, material_id INT NOT NULL, INDEX IDX_E5DBD13C31A80092 (collection_point_id), INDEX IDX_E5DBD13CE308AC6F (material_id), PRIMARY KEY(collection_point_id, material_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE collection_point_objet (collection_point_id INT NOT NULL, objet_id INT NOT NULL, INDEX IDX_7952502A31A80092 (collection_point_id), INDEX IDX_7952502AF520CF5A (objet_id), PRIMARY KEY(collection_point_id, objet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE collection_point_category (collection_point_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_9F29BD6831A80092 (collection_point_id), INDEX IDX_9F29BD6812469DE2 (category_id), PRIMARY KEY(collection_point_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE collection_point_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, devenir LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objet (id INT AUTO_INCREMENT NOT NULL, material_id_id INT NOT NULL, use_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, avoid_production LONGTEXT DEFAULT NULL, valide TINYINT(1) NOT NULL, INDEX IDX_46CD4C3829A33219 (material_id_id), INDEX IDX_46CD4C38E3D2B46D (use_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, page_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sources (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, picture LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_tag ADD CONSTRAINT FK_6EC3989DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_tag ADD CONSTRAINT FK_6EC3989BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_sources ADD CONSTRAINT FK_3EABD871DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_sources ADD CONSTRAINT FK_3EABD871DD51D0F7 FOREIGN KEY (sources_id) REFERENCES sources (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE collection_point ADD CONSTRAINT FK_F05D4B77A9B99F90 FOREIGN KEY (collection_point_type_id) REFERENCES collection_point_type (id)');
        $this->addSql('ALTER TABLE collection_point_material ADD CONSTRAINT FK_E5DBD13C31A80092 FOREIGN KEY (collection_point_id) REFERENCES collection_point (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE collection_point_material ADD CONSTRAINT FK_E5DBD13CE308AC6F FOREIGN KEY (material_id) REFERENCES material (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE collection_point_objet ADD CONSTRAINT FK_7952502A31A80092 FOREIGN KEY (collection_point_id) REFERENCES collection_point (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE collection_point_objet ADD CONSTRAINT FK_7952502AF520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE collection_point_category ADD CONSTRAINT FK_9F29BD6831A80092 FOREIGN KEY (collection_point_id) REFERENCES collection_point (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE collection_point_category ADD CONSTRAINT FK_9F29BD6812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C3829A33219 FOREIGN KEY (material_id_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C38E3D2B46D FOREIGN KEY (use_id_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blog_tag DROP FOREIGN KEY FK_6EC3989DAE07E97');
        $this->addSql('ALTER TABLE blog_sources DROP FOREIGN KEY FK_3EABD871DAE07E97');
        $this->addSql('ALTER TABLE collection_point_category DROP FOREIGN KEY FK_9F29BD6812469DE2');
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C38E3D2B46D');
        $this->addSql('ALTER TABLE collection_point_material DROP FOREIGN KEY FK_E5DBD13C31A80092');
        $this->addSql('ALTER TABLE collection_point_objet DROP FOREIGN KEY FK_7952502A31A80092');
        $this->addSql('ALTER TABLE collection_point_category DROP FOREIGN KEY FK_9F29BD6831A80092');
        $this->addSql('ALTER TABLE collection_point DROP FOREIGN KEY FK_F05D4B77A9B99F90');
        $this->addSql('ALTER TABLE collection_point_material DROP FOREIGN KEY FK_E5DBD13CE308AC6F');
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C3829A33219');
        $this->addSql('ALTER TABLE collection_point_objet DROP FOREIGN KEY FK_7952502AF520CF5A');
        $this->addSql('ALTER TABLE blog_sources DROP FOREIGN KEY FK_3EABD871DD51D0F7');
        $this->addSql('ALTER TABLE blog_tag DROP FOREIGN KEY FK_6EC3989BAD26311');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE blog_tag');
        $this->addSql('DROP TABLE blog_sources');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE collection_point');
        $this->addSql('DROP TABLE collection_point_material');
        $this->addSql('DROP TABLE collection_point_objet');
        $this->addSql('DROP TABLE collection_point_category');
        $this->addSql('DROP TABLE collection_point_type');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE objet');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE sources');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
    }
}
