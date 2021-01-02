<?php


namespace Src\Core\View;

use Exception;

/**
 * Class View
 * @package Src\Core\View
 */
class View
{
    /**
     * @var Loader
     */
    protected $loader;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * View constructor.
     * @param Loader $loader
     */
    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * @param $data
     */
    public function setData($data){
        $this->data[] = $data;
    }

    /**
     * @param string $view
     * @param array $data
     * @return false|string
     * @throws Exception
     */
    public function render(string $view,array $data=[])
    {
        ob_start();
        extract($data);
        global $errors;
        include $this->loader->fetch($view);
        return ob_get_clean();
    }
}