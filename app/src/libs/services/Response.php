<?php


namespace Src\Libs\Services;

/**
 * Class Response
 * @package Src\Libs\Services
 */
class Response
{
    private static $baseUri;

    private static $uri;

    /**
     *
     * @param $url
     */
    public static function redirect(string $url)
    {
        $url = self::$baseUri . $url;
        header('Location: ' . $url);
        die();
    }

    /**
     * @return mixed
     */
    public static function getBasePath()
    {
        return self::$baseUri;
    }

    /**
     * @param $baseUri
     */
    public static function setBaseUri(string $baseUri)
    {
        self::$baseUri = $baseUri;
    }

    public static function addValidationRedirect($uri){
        self::$uri = $uri;
    }

    public static function validationRedirect(){
        session_write_close();
        header('Location: ' . self::$uri);
        die();
    }
}