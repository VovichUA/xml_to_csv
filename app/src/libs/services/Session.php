<?php


namespace Src\Libs\Services;

/**
 * Class Session
 * @package Src\Libs\Services
 */
class Session
{
    /**
     * @param string $name
     * @param string $data
     */
    public static function set(string $name, string $data){
        $_SESSION[$name] = $data;
        $_SESSION['activity'] = time();
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public static function get(string $name)
    {
        if(isset($_SESSION['activity']))
            if( (time() - $_SESSION['activity']) > 1800){
                session_unset();
                session_destroy();
                return null;
            }

        if(isset($_SESSION[$name]))
            return $_SESSION[$name];

        return null;
    }

    public static function start(){

        @session_start();

        if(!isset($_SESSION['activity'])) {
            $_SESSION['activity'] = time();
        }
    }

    /**
     * @param string $name
     */
    public static function delete(string $name)
    {
        unset($_SESSION[$name]);
    }
}