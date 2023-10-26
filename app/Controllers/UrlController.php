<?php

namespace MvcPhpUrlShortner\Controllers;

use http\Exception\BadHeaderException;
use MongoDB\Driver\Exception\ExecutionTimeoutException;
use MvcPhpUrlShortner\Models\UrlModel;
use Random\RandomException;

class UrlController extends BaseController
{

    public function __construct()
    {
    }

    /**
     * @return UrlModel
     */
    private function getUrlModel(): UrlModel
    {
        return new UrlModel();
    }


    /**
     * @return void
     */
    public function index(): void
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        // Number of items per page
        $perPage = 5;
        // Retrieve URLs for the given page
        $urls = $this->getUrlModel()->getUrlsSortedByDate($page, $perPage);
        // Total count of URLs
        $totalUrls = $this->getUrlModel()->getTotalUrlsCount();
        // Total pages
        $totalPages = ceil($totalUrls / $perPage);
        // Get new created url from coockies
        $newUrl = isset($_COOKIE['newUrl']) ? $_COOKIE['newUrl'] : null;
        // Pass data to the view
        $data = [
            'urls' => $urls,
            'totalUrls' => $totalUrls,
            'perPage' => $perPage,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'newUrl' => $newUrl,
            'baseUrl' => $this->getBaseUrl()
        ];
        $this->render('UrlShorten', ["data" => $data]);
    }

    /**
     * @return void
     * @throws RandomException
     */
    public function createShortUrl(): void
    {
        // Validate and sanitize the input
        $originalUrl = filter_var($_POST['url'], FILTER_SANITIZE_URL);

        // Add  validation and error handling here, e.g., check if it's a valid URL.
        if (!$this->isValidUrl($originalUrl)) {
            header("Location: /urls");
            exit;
        }
        // Check if the short URL already exists for the original URL
        $shortUrl = $this->getUrlModel()->getShortUrlByOriginalUrl($originalUrl);
        // check if url excist otherwise create a new one.
        if (!$shortUrl) {
            $shortUrl = $this->getUrlModel()->createShortUrl($originalUrl);
        }

        // set cookie to show the last created url someone made.
        if (isset($_COOKIE['newUrl'])) {
            // Delete the old cookie by setting an expiration time in the past (e.g., 1 second ago).
            setcookie('newUrl', '', time() - 1, '/');
        }
        setcookie('newUrl', $shortUrl, time() + 3600, '/');
        header("Location: /urls");
        exit;
    }

    /**
     * redirect with 302 warning.
     * @return void
     */
    private function redirectToUrlIndex(): void
    {
        header("Location: /urls", true, 302);
        exit;
    }

    private function isValidUrl(string $url): bool
    {
        // Use filter_var with FILTER_VALIDATE_URL to validate the URL.
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    /**
     * @param $shortUrl
     * @return void
     */
    public function redirectToOriginalUrl($request)
    {
        $originalUrl = $this->getUrlModel()->getOriginalUrlByShortUrl($request['short_url']);

        if ($originalUrl) {
            // Redirect to the original URL
            header("Location: $originalUrl");
            exit;
        } else {
            // Handle the case where the short URL doesn't exist
            // You can redirect to an error page or display an error message
            echo "Short URL not found";
        }
    }

    /**
     * @return string
     */
    private function getBaseUrl(): string
    {
        // Get the protocol (HTTP or HTTPS)
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        // Get the domain name
        $domain = $_SERVER['HTTP_HOST'];
        // Output the base URL
        return $protocol . $domain;
    }
}
