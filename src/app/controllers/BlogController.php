<?php
    use libraries\Controller;

class BlogController extends Controller
{
    private $blog;

    public function __construct()
    {
        $this -> blog = $this -> model('Blogs');
    }

    public function addBlog()
    {
        $this -> blog -> addBlog($_POST['name'], $_POST['content'], $_POST['User_ID']);
    }
    
    public function post()
    {
        $data = [
            $_POST['Blog_ID']
        ];
        $this -> view("pages/post", $data);
    }

    public function newPost()
    {
        $this -> view ("pages/addPost");
    }

    public function addPost()
    {
        $this -> blog -> addBlog($_POST['Blog_name'], $_POST['Content'], $_POST['Author_ID']);
        header("location: ".URLROOT."/public"); 
    }
}