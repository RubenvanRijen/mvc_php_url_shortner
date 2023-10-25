<?php

namespace MvcPhpUrlShortner\Database\Seeders;

use MvcPhpUrlShortner\Models\UrlModel;
use PDO;

class UrlSeeder
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Seed the "urls" table with data.
     *
     * @return void
     */
    public function seed(): void
    {
        $urlData = [
            new UrlModel("https://music.youtube1.com/", "https://music.youtube1.com/", 0),
            new UrlModel("https://music.youtube2.com/", "https://music.youtube2.com/", 0),
            new UrlModel("https://music.youtube3.com/", "https://music.youtube3.com/", 0),
            new UrlModel("https://music.youtube4.com/", "https://music.youtube4.com/", 0),
        ];

        $stmt = $this->db->prepare("INSERT INTO urls (short_url, original_url, usedAmount) VALUES (:short_url, :original_url, :usedAmount)");
        
        foreach ($urlData as $url) {
            $stmt->bindParam(':short_url', $url->short_url);
            $stmt->bindParam(':original_url', $url->original_url);
            $stmt->bindParam(':usedAmount', $url->usedAmount);

            $stmt->execute();
        }
    }
}