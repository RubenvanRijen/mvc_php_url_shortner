<?php

namespace MvcPhpUrlShortner\Database\Migrations;

use PDO;

class UrlMigration extends BaseMigration
{


    /**
     * create the table
     * @return void
     */
    public function up(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS urls (
                id INT AUTO_INCREMENT PRIMARY KEY,
                original_url VARCHAR(255) NOT NULL,
                short_url VARCHAR(255) NOT NULL,
                usedAmount INT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE (original_url, short_url)
            )
        ";

        $this->getDb()->exec($sql);
    }

    /**
     * Drop the table.
     * @return void
     */
    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS urls";
        $this->getDb()->exec($sql);
    }
}
