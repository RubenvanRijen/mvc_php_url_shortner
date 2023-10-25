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
        $url = new UrlModel("https://tailwindcss.com/docs/installation", "https://tailwindcss.com/docs/installation", 1);
        $this->render('UrlShorten', ["url" => $url]);
    }

}
