<?php

namespace MvcPhpUrlShortner\Models;

use MvcPhpUrlShortner\Database\Database;
use MvcPhpUrlShortner\Objects\UrlObject;
use PDO;
use Random\RandomException;

class UrlModel
{
    public const SHORT_URL_LENGTH = 9;
    public const RANDOM_BYTES = 32;
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * @param $page
     * @param $perPage
     * @return false|array
     */
    public function getUrls($page, $perPage): false|array
    {
        // Calculate the limit and offset based on the page and perPage values
        $limit = $perPage;
        $offset = ($page - 1) * $perPage;

        // Fetch URLs with pagination
        $stmt = $this->db->prepare("SELECT * FROM urls LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     */
    public function getTotalUrlsCount(): mixed
    {
        // Get the total count of URLs in the database
        $stmt = $this->db->query("SELECT COUNT(*) FROM urls");

        return $stmt->fetchColumn();
    }

    /**
     * Create a Short URL for the provided original URL.
     *
     * @param string $originalUrl
     * @return string|null The generated short URL or false if an error occurs.
     */
    public function createShortUrl(string $originalUrl): string|null
    {
        $shortUrl = $this->generateShortUrl($originalUrl);

        // check if the url has already been trimmed down
        if ($this->originalUrlExists($originalUrl)) {
            return $this->getShortUrlByOriginalUrl($originalUrl);
        }
        // Check if the short URL already exists
        if ($this->shortUrlExists($shortUrl)) {
            return null; // Handle the case where a duplicate short URL is generated
        }

        // Insert the record into the database
        $stmt = $this->db->prepare("INSERT INTO urls (original_url, short_url) VALUES (:original_url, :short_url)");
        $stmt->bindParam(':original_url', $originalUrl);
        $stmt->bindParam(':short_url', $shortUrl);

        if ($stmt->execute()) {
            return $shortUrl;
        } else {
            return null; // Handle the case where the insert operation fails
        }
    }

    /**
     * Generate a Short URL based on the original URL.
     * @param string $originalUrl
     * @return string
     * @throws RandomException
     */
    private function generateShortUrl(string $originalUrl): string
    {
        return substr(base64_encode(sha1(uniqid(random_bytes(self::RANDOM_BYTES), true))), 0, self::SHORT_URL_LENGTH);
    }

    /**
     * Check if a short URL already exists in the database.
     *
     * @param string $shortUrl
     * @return bool
     */
    private function shortUrlExists(string $shortUrl): bool
    {
        // Prepare a SQL statement to check for the existence of the short URL
        $sql = "SELECT COUNT(*) FROM urls WHERE short_url = :short_url";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':short_url', $shortUrl, PDO::PARAM_STR);
        $stmt->execute();
        // If the count is greater than 0, the short URL already exists
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Check if a short URL already exists in the database.
     *
     * @param string $originalUrl
     * @return bool
     */
    private function originalUrlExists(string $originalUrl): bool
    {
        // Prepare a SQL statement to check for the existence of the short URL
        $sql = "SELECT COUNT(*) FROM urls WHERE original_url = :original_url";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':original_url', $originalUrl, PDO::PARAM_STR);
        $stmt->execute();
        // If the count is greater than 0, the original URL already exists
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Fetch URL data by original URL.
     *
     * @param string $shortUrl
     * @return array|null
     */
    public function getOriginalUrlByShortUrl(string $shortUrl): ?string
    {
        // Prepare the SQL statement to select the short URL based on the original URL
        $sql = "SELECT original_url FROM urls WHERE short_url = :short_url";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':short_url', $shortUrl, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the short URL
        $originalUrl = $stmt->fetchColumn();

        // If a short URL is found, return it; otherwise, return null
        return $originalUrl ?: null;
    }

    /**
     * Fetch the short URL by original URL.
     *
     * @param string $originalUrl
     * @return string|null
     */
    public function getShortUrlByOriginalUrl(string $originalUrl): ?string
    {
        // Prepare the SQL statement to select the short URL based on the original URL
        $sql = "SELECT short_url FROM urls WHERE original_url = :original_url";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':original_url', $originalUrl, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the short URL
        $shortUrl = $stmt->fetchColumn();

        // If a short URL is found, return it; otherwise, return null
        return $shortUrl ?: null;
    }
}