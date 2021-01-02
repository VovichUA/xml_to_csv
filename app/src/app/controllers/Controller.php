<?php

namespace App\Controllers;

use Src\Core\View\View;
use Src\Core\View\Loader;

/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{
    /**
     * @var View
     */
    protected $view;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->view = new View(
            new Loader('/var/www/marakas/src/app/views/')
        );

    }
}