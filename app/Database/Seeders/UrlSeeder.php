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
            new UrlObject(shortUrl: "DUJFKEDH6", originalUrl: "https://music.youtube1.com/", usedAmount: 0),
            new UrlObject(shortUrl: "OKDUE48CJ", originalUrl: "https://music.youtube2.com/", usedAmount: 0),
            new UrlObject(shortUrl: "WHSNCJDYE", originalUrl: "https://music.youtube3.com/", usedAmount: 0),
            new UrlObject(shortUrl: "WNCMDFKI8", originalUrl: "https://music.youtube4.com/", usedAmount: 0),
        ];

        $stmt = $this->getDb()->prepare("INSERT INTO urls (short_url, original_url, used_amount) VALUES (:short_url, :original_url, :used_amount)");

        foreach ($urlData as $url) {
            $stmt->bindValue(':short_url', $url->getShortUrl());
            $stmt->bindValue(':original_url', $url->getOriginalUrl());
            $stmt->bindValue(':used_amount', $url->getUsedAmount());

            $stmt->execute();
        }
    }
}
