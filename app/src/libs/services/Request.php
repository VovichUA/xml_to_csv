<?php

namespace Src\Libs\Services;

/**
 * Class Request
 * @package Src\Libs\Services
 */
class Request
{
    /**
     * @var array
     */
    private $postParams;

    private $files;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->postParams = $_POST ? $_POST : [];
        $this->files = $_FILES ? $_FILES : [] ;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function get(string $name)
    {
        if(array_key_exists($name, $this->postParams)){
            return $this->postParams[$name];
        }

        return null;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function file(string $name)
    {
        if(array_key_exists($name, $this->files)){
            return $this->files[$name];
        }

        return null;
    }

}