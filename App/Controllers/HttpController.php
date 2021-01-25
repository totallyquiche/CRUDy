<?php declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;

class HttpController extends BaseController
{
    /**
     * Render the home page.
     *
     * @param Request $request
     *
     * @return string
     */
    public function http404(Request $request) : string
    {
        http_response_code(404);

        return $this->loadView('page', [
            'header_text' => '404 Not Found'
        ]);
    }
}