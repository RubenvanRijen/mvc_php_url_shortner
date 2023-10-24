<?php

namespace MvcPhpUrlShortner\Controllers;

use MvcPhpUrlShortner\Models\UrlModel;

class UrlController extends BaseController
{


    public function __construct()
    {
    }

    /**
     * @return void
     */
    public function index(): void
    {
        $url = new UrlModel("https://tailwindcss.com/docs/installation");
        $this->render('UrlShorten', ["url" => $url]);
    }

}
