<?php

namespace MvcPhpUrlShortner\Models;

use DateTime;
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
     * get all the dates paginated
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
        $stmt = $this->db->prepare("SELECT * FROM urls  LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Sort the urls by date. From newest to oldest.
     * @param $page
     * @param $perPage
     * @return false|array
     */
    public function getUrlsSortedByDate($page, $perPage): false|array
    {
        // Calculate the limit and offset based on the page and perPage values
        $limit = $perPage;
        $offset = ($page - 1) * $perPage;

        // Fetch URLs with pagination
        $stmt = $this->db->prepare("SELECT * FROM urls ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
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
     * Create a Short URL for the provided original URL and return the whole object.
     * @param string $originalUrl
     * @return UrlObject|null 
     * @throws RandomException
     */
    public function createShortUrl(string $originalUrl): UrlObject|null
    {
        $shortUrl = $this->generateShortUrl($originalUrl);

        // check if the url has already been used and shortened.
        if ($this->originalUrlExists($originalUrl)) {
            return $this->getUrlDataByOriginalUrl($originalUrl);
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
            $lastInsertId = $this->db->lastInsertId();
            return $this->getUrlDataById($lastInsertId);
        } else {
            return null;
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
     * @param string $shortUrl
     * @return bool
     */
    public function shortUrlExists(string $shortUrl): bool
    {
        // The SQL statement to check for the existence of the short URL
        $sql = "SELECT COUNT(*) FROM urls WHERE short_url = :short_url";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':short_url', $shortUrl, PDO::PARAM_STR);
        $stmt->execute();
        // If the count is greater than 0, the short URL already exists
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Check if a short URL already exists in the database.
     * @param string $originalUrl
     * @return bool
     */
    public function originalUrlExists(string $originalUrl): bool
    {
        // The a SQL statement to check for the existence of the short URL
        $sql = "SELECT COUNT(*) FROM urls WHERE original_url = :original_url";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':original_url', $originalUrl, PDO::PARAM_STR);
        $stmt->execute();
        // If the count is greater than 0, the original URL already exists
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Increase the used amount of a short url.
     * @return void
     */
    public function increaseUsedAmount(int $id)
    {
        $sql = "UPDATE urls SET used_amount = used_amount + 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    /**
     * Fetch URL data by short URL.
     *
     * @param string $shortUrl
     * @return UrlObject|null
     */
    public function getUrlDataByShortUrl(string $shortUrl): ?UrlObject
    {
        // The SQL statement to select the Url Object based on the short URL
        $sql = "SELECT * FROM urls WHERE short_url = :short_url";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':short_url', $shortUrl, PDO::PARAM_STR);
        $stmt->execute();

        //fetch the data and transform it into an urlObject.
        return $this->fetchUrlObject($stmt);
    }

    /**
     * Summary of fetchUrlObject
     * @param mixed $stmt
     * @return UrlObject|null
     */
    private function fetchUrlObject($stmt): UrlObject|null
    {
        // Fetch the Url data
        $urlData = $stmt->fetch(PDO::FETCH_OBJ);

        // If a Url data is found, return it; otherwise, return null
        if ($urlData) {
            // Convert the created_at string to a DateTime object
            $createdAt = new DateTime($urlData->created_at);
            // Create an instance of UrlObject using the fetched data
            return new UrlObject(
                id: $urlData->id,
                shortUrl: $urlData->short_url,
                originalUrl: $urlData->original_url,
                usedAmount: $urlData->used_amount,
                createdAt: $createdAt
            );
        } else {
            return null;
        }
    }

    /**
     * Fetch the Url object by original URL.
     *
     * @param string $originalUrl
     * @return UrlObject|null
     */
    public function getUrlDataByOriginalUrl(string $originalUrl): ?UrlObject
    {
        // The SQL statement to select the Url object based on the original URL
        $sql = "SELECT * FROM urls WHERE original_url = :original_url";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':original_url', $originalUrl, PDO::PARAM_STR);
        $stmt->execute();

        //fetch the data and transform it into an urlObject.
        return $this->fetchUrlObject($stmt);
    }



    /**
     * get the url object by id
     * @param int $id
     * @return UrlObject|null
     */
    public function getUrlDataById(int $id): ?UrlObject
    {
        // The SQL statement to select the Url obhject based on the ID
        $sql = "SELECT * FROM urls WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        //fetch the data and transform it into an urlObject.
        return $this->fetchUrlObject($stmt);
    }
}
