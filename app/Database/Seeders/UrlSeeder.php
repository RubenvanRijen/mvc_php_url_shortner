<?php

namespace MvcPhpUrlShortner\Database\Seeders;

use MvcPhpUrlShortner\Objects\UrlObject;
use PDO;

class UrlSeeder extends BaseSeeder
{
    /**
     * Seed the "urls" table with data.
     * @return void
     */
    public function seed(): void
    {
        $urlData = [
            new UrlObject("https://music.youtube1.com/", "https://music.youtube1.com/", 0),
            new UrlObject("https://music.youtube2.com/", "https://music.youtube2.com/", 0),
            new UrlObject("https://music.youtube3.com/", "https://music.youtube3.com/", 0),
            new UrlObject("https://music.youtube4.com/", "https://music.youtube4.com/", 0),
        ];

        $stmt = $this->getDb()->prepare("INSERT INTO urls (short_url, original_url, usedAmount) VALUES (:short_url, :original_url, :usedAmount)");

        foreach ($urlData as $url) {
            $stmt->bindValue(':short_url', $url->getShortUrl());
            $stmt->bindValue(':original_url', $url->getOriginalUrl());
            $stmt->bindValue(':usedAmount', $url->getUsedAmount());

            $stmt->execute();
        }
    }
}