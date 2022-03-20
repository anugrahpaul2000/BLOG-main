<?php
    // namespace controllers;

    use libraries\Controller;

class Pages extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $this -> view("pages/home");
    }

    public function login()
    {
        $this -> view("pages/login/header");
        $this -> view("pages/login/loginmain");
        $this -> view("pages/login/footer");
    }

    public function register()
    {
        $this -> view("pages/login/header");
        $this -> view("pages/login/registermain");
        $this -> view("pages/login/footer");
    }

    public function about()
    {
        $this -> view("pages/about");
    }
    
    public function post()
    {
        $this -> view ("pages/post");
    }

    public function clear()
    {
        $this -> view ("clear");
    }
}
