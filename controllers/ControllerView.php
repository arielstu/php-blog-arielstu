<?php 

class ControllerView
{
    private static $path_view = './views/';
    public static $root_home = 'http://localhost/arielstu/';
    public static function load_view_on($view, $obj = [])
    {

        require_once(self::$path_view . 'header_on.php');
        require_once(self::$path_view . $view . '.php');
        require_once(self::$path_view . 'footer_on.php');
    }
    public static function load_view_off($view, $obj = [])
    {

        require_once(self::$path_view . 'header_off.php');
        require_once(self::$path_view . $view . '.php');
        require_once(self::$path_view . 'footer_off.php');
    }
}