<?php declare(strict_types=1);

namespace App\Controllers;

class ThingamabobController extends BaseController
{
    /**
     * Display all Thingamabobs
     *
     * @return string
     */
    public function index() : string
    {
        return $this->loadView('Thingamabob/index', [
            'thingamabobs' => [
                'Gizmo',
                'Gadget',
                'Whozit',
                'Whatzit',
                'Dinglehopper'
            ]
        ]);
    }
}