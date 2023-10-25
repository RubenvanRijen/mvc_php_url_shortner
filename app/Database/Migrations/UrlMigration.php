<?php

namespace MvcPhpUrlShortner\Database\Migrations;

use PDO;

class UrlMigration
{
    private PDO $db;

    /**
     * constructor
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

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
                UNIQUE (original_url)
            )
        ";

        $this->db->exec($sql);
    }

    /**
     * Drop the table.
     * @return void
     */
    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS urls";
        $this->db->exec($sql);
    }

}

