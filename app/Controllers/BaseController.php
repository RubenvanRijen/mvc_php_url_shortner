<?php

namespace MvcPhpUrlShortner\Controllers;

class BaseController
{


    /**
     * The function to render a view in a function
     * @param $view
     * @param array $data
     * @return void
     */
    protected function render($view, array $data = []): void
    {
        extract($data);

        include "./app/Views/$view.php";
    }
}