<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220201110140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE champagne (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, image_filename VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_champagne (order_id INT NOT NULL, champagne_id INT NOT NULL, INDEX IDX_54B34C1E8D9F6D38 (order_id), INDEX IDX_54B34C1E7A9D3D4B (champagne_id), PRIMARY KEY(order_id, champagne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_champagne ADD CONSTRAINT FK_54B34C1E8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_champagne ADD CONSTRAINT FK_54B34C1E7A9D3D4B FOREIGN KEY (champagne_id) REFERENCES champagne (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_champagne DROP FOREIGN KEY FK_54B34C1E7A9D3D4B');
        $this->addSql('ALTER TABLE order_champagne DROP FOREIGN KEY FK_54B34C1E8D9F6D38');
        $this->addSql('DROP TABLE champagne');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_champagne');
    }
}
