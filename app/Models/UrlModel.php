<?php

namespace MvcPhpUrlShortner\Models;

use MvcPhpUrlShortner\Database\Database;
use PDO;

class UrlModel
{
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
}