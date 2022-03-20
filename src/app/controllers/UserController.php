<?php
    // namespace controllers;

    use libraries\Controller;

class UserController extends Controller
{
    private $user;

    public function __construct()
    {
        $this -> user = $this -> model('User');
    }

    public function login()
    {
        $result = $this -> user -> getUser($_POST['email'], $_POST['password']);
    }

    public function register()
    {
        $result = $this -> user -> addUser($_POST['email'], $_POST['name'], $_POST['password']);
        if ($result == 1) {
            $this -> login();
        }
        header("location: ".URLROOT."/public/pages/login");
    }
}
