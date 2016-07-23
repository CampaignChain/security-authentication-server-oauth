<?php
/*
 * Copyright 2016 CampaignChain, Inc. <info@campaignchain.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160621000001 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE campaignchain_security_authentication_server_oauth_access_token (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_4BDE0A2B5F37A13B (token), INDEX IDX_4BDE0A2B19EB6921 (client_id), INDEX IDX_4BDE0A2BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campaignchain_security_authentication_server_oauth_auth_code (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, redirect_uri LONGTEXT NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_FD3DC5105F37A13B (token), INDEX IDX_FD3DC51019EB6921 (client_id), INDEX IDX_FD3DC510A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campaignchain_security_authentication_server_oauth_client (id INT AUTO_INCREMENT NOT NULL, random_id VARCHAR(255) NOT NULL, redirect_uris LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', secret VARCHAR(255) NOT NULL, allowed_grant_types LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', name VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campaignchain_security_authentication_server_oauth_refresh_token (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_28674D685F37A13B (token), INDEX IDX_28674D6819EB6921 (client_id), INDEX IDX_28674D68A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE campaignchain_security_authentication_server_oauth_access_token ADD CONSTRAINT FK_4BDE0A2B19EB6921 FOREIGN KEY (client_id) REFERENCES campaignchain_security_authentication_server_oauth_client (id)');
        $this->addSql('ALTER TABLE campaignchain_security_authentication_server_oauth_access_token ADD CONSTRAINT FK_4BDE0A2BA76ED395 FOREIGN KEY (user_id) REFERENCES campaignchain_user (id)');
        $this->addSql('ALTER TABLE campaignchain_security_authentication_server_oauth_auth_code ADD CONSTRAINT FK_FD3DC51019EB6921 FOREIGN KEY (client_id) REFERENCES campaignchain_security_authentication_server_oauth_client (id)');
        $this->addSql('ALTER TABLE campaignchain_security_authentication_server_oauth_auth_code ADD CONSTRAINT FK_FD3DC510A76ED395 FOREIGN KEY (user_id) REFERENCES campaignchain_user (id)');
        $this->addSql('ALTER TABLE campaignchain_security_authentication_server_oauth_refresh_token ADD CONSTRAINT FK_28674D6819EB6921 FOREIGN KEY (client_id) REFERENCES campaignchain_security_authentication_server_oauth_client (id)');
        $this->addSql('ALTER TABLE campaignchain_security_authentication_server_oauth_refresh_token ADD CONSTRAINT FK_28674D68A76ED395 FOREIGN KEY (user_id) REFERENCES campaignchain_user (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaignchain_security_authentication_server_oauth_access_token DROP FOREIGN KEY FK_4BDE0A2BA76ED395');
        $this->addSql('ALTER TABLE campaignchain_security_authentication_server_oauth_auth_code DROP FOREIGN KEY FK_FD3DC510A76ED395');
        $this->addSql('ALTER TABLE campaignchain_security_authentication_server_oauth_refresh_token DROP FOREIGN KEY FK_28674D68A76ED395');
        $this->addSql('ALTER TABLE campaignchain_security_authentication_server_oauth_access_token DROP FOREIGN KEY FK_4BDE0A2B19EB6921');
        $this->addSql('ALTER TABLE campaignchain_security_authentication_server_oauth_auth_code DROP FOREIGN KEY FK_FD3DC51019EB6921');
        $this->addSql('ALTER TABLE campaignchain_security_authentication_server_oauth_refresh_token DROP FOREIGN KEY FK_28674D6819EB6921');
        $this->addSql('DROP TABLE campaignchain_security_authentication_server_oauth_access_token');
        $this->addSql('DROP TABLE campaignchain_security_authentication_server_oauth_auth_code');
        $this->addSql('DROP TABLE campaignchain_security_authentication_server_oauth_client');
        $this->addSql('DROP TABLE campaignchain_security_authentication_server_oauth_refresh_token');
    }
}
