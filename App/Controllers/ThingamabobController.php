<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\Thingamabob;
use App\DatabaseAdapter;

class ThingamabobController extends BaseController
{
    /**
     * Display all Thingamabobs
     *
     * @return string
     */
    public function index() : string
    {
        return $this->loadView(
            'Thingamabob/index',
            [
                'thingamabobs' => (new Thingamabob(new DatabaseAdapter))->all()
            ]
        );
    }
}