<?php

namespace Src\Core\View;

use Exception;

/**
 * Class Loader
 * @package Src\Core\View
 */
class Loader
{
    protected $path;

    /**
     * Loader constructor.
     * @param string $path
     */
    public function __construct(string $path){
        $this->path = $path;
    }

    /**
     * @param string $view
     * @return string
     * @throws Exception
     */
    public function fetch(string $view): string
    {
        if(file_exists($this->path . $view . '.php')){
            return $this->path  . $view . '.php';
        }

        if(file_exists($this->path . $view . '.view.php')){
            return $this->path . $view . '.view.php';
        }

        if(file_exists($this->path . $view)){
            return $this->path.  $view;
        }

        throw new Exception("View does not exists" . $this->path . $view);
    }
}