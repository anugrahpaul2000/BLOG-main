<?php
    namespace libraries;

class Controller
{
    public function model($model)
    {
        //Require Model File
        require_once("../app/models/" . $model . ".php");

        //Initiate Model
        return new $model;
    }

    //Loads the view (checks for file)
    public function view($view, $data = [])
    {
        // echo '../app/views/'. $view . '.php';
        // echo (file_exists('../app/views/'. $view . '.php'));
        // die();
        if (file_exists('../app/views/'. $view . '.php')) {
            require_once('../app/views/'. $view . '.php');
        } else {
            die("../app/views/pages/home.php");
        }
    }
}
