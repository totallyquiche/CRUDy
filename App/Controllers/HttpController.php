<?php declare(strict_types=1);

namespace App\Controllers;

class HttpController extends BaseController
{
    /**
     * Render the home page.
     *
     * @return string
     */
    public function http404() : string
    {
        http_response_code(404);

        return $this->loadView('page', [
            'header_text' => '404 Not Found'
        ]);
    }
}