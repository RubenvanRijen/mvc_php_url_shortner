<?php

namespace MvcPhpUrlShortner\Controllers;

use MvcPhpUrlShortner\Models\UrlModel;

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
        $perPage = 2;

        // Retrieve URLs for the given page
        $urls = $this->getUrlModel()->getUrls($page, $perPage);

        // Total count of URLs
        $totalUrls = $this->getUrlModel()->getTotalUrlsCount();

        // Pass data to the view
        $data = [
            'urls' => $urls,
            'totalUrls' => $totalUrls,
            'perPage' => $perPage,
            'currentPage' => $page,
        ];
        echo $data['urls'][0]['short_url'];
        $this->render('UrlShorten', ["data" => $data]);
    }

}
