<?php
    namespace libraries;

    // use Model\User;
    // use Model\Admin;

    // use controllers\Pages;
    // use controllers\UserController;

class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        if (isset($_GET['url'])) {
            $url = $this -> getURL();

            //Looks in controllers folder and capitalizes the first Word
            if (file_exists("../app/controllers/". ucwords($url[0]) .".php")) {
                //Sets a new Controller
                $this -> currentController = ucwords($url[0]);
                unset($url[0]);
            }

            //require new Controller
            require_once("../app/controllers/" . $this -> currentController .".php");
            $this -> currentController = new $this -> currentController;

            //checking second part of URL
            if (isset($url[1])) {
                if (method_exists($this -> currentController, $url[1])) {
                    $this -> currentMethod = $url[1];
                    unset($url[1]);
                }
            }

            //Get Parameters
            $this -> params = $url ? array_values($url) : [];

            //Call a callback with array of params
            call_user_func_array([$this -> currentController, $this -> currentMethod], $this -> params);
        }
    }

    public function getURL()
    {
        if (isset($_GET['url'])) {
            //Trims / from the end of URL
            $url = rtrim($_GET['url'], '/');
            //Filters Strings/Number
            $url = filter_var($url, FILTER_SANITIZE_URL);
            //Break into Array
            $url = explode('/', $url);
            return $url;
        }
    }
}
