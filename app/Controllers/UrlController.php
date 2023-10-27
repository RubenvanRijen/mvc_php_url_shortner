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
     * Get the url model so that it's not needed to inject in the controller.
     * @return UrlModel
     */
    private function getUrlModel(): UrlModel
    {
        return new UrlModel();
    }


    /**
     * The main view of the application and getting all the urls.
     * @return void
     */
    public function index(): void
    {
        //Get the requested page from the url params.
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
        $this->render('UrlShortenView', ["data" => $data]);
    }

    /**
     * create the short url when the form is submitted.
     * @return void
     * @throws RandomException
     */
    public function createShortUrl(): void
    {
        // Validate and sanitize the input
        $originalUrl = filter_var($_POST['url'], FILTER_SANITIZE_URL);

        // Validation and error handling, check if it's a valid URL.
        if (!$this->isValidUrl($originalUrl)) {
            $_SESSION['url_error'] = "Invalid URL. Please enter a valid URL.";
            $this->index();
            exit;
        }
        // Check if the short URL already exists for the original URL
        $shortUrl = $this->getUrlModel()->getUrlDataByOriginalUrl($originalUrl);
        // check if url excist otherwise create a new one.
        if (!$shortUrl) {
            $shortUrl = $this->getUrlModel()->createShortUrl($originalUrl);
        }
        if ($shortUrl === null) {
            $_SESSION['generate_error'] = "Er is een fout opgetreden, porbeer het opnieuw";
            $this->index();
            exit;
        }

        // set cookie to show the last created url someone made.
        if (isset($_COOKIE['newUrl'])) {
            // Delete the old cookie by setting an expiration time in the past (e.g., 1 second ago).
            setcookie('newUrl', '', time() - 1, '/');
        }
        setcookie('newUrl', $shortUrl->getShortUrl(), time() + 3600, '/');
        header("Location: /urls");
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
        $urlObject = $this->getUrlModel()->getUrlDataByShortUrl($request['short_url']);
        $this->getUrlModel()->increaseUsedAmount($urlObject->getId());
        if ($urlObject) {
            // Redirect to the original URL
            $originalUrl = $urlObject->getOriginalUrl();
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
