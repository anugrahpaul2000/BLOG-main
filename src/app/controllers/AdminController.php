<?php
    use libraries\Controller;

class AdminController extends Controller
{
    private $admin;

    public function __construct()
    {
        $this -> user = $this -> model('Admin');
    }

    public function admin()
    {
        $this -> view ("pages/admin/admin_dashboard");
    }

    public function blogs()
    {
        $this -> view ("pages/admin/blogs");
    }

    public function users()
    {
        $this -> view ("pages/admin/users");
    }

    public function blogChangeData()
    {
        switch ($_POST['action'])
        {
            case 'statusBlog':
                $this -> changeStatusBlog();
                break;

        }
    }

    public function changeStatusBlog()
    {
        global $BLOG;
        $BLOG -> changeBlogStatus($_POST['status'], $_POST['Blog_ID']);
        header("location: ".URLROOT."/public/AdminController/blogs");
    }

    public function userChangeData()
    {
        switch ($_POST['action'])
        {
            case 'updateUser':
                $this -> updateUser();
                break;

            case 'deleteUser':
                $this -> deleteUser();
                break;

            case 'statusUser':
                $this -> changeStatusUser();
                break;
        }
    }

    public function changeStatusUser()
    {
        global $USER;
        $USER -> changeUserStatus($_POST['status'], $_POST['User_ID']);
        header("location: ".URLROOT."/public/AdminController/users");
    }

    public function updateUser()
    {
        global $USER;
        $USER -> updateUserData($_POST['User_ID'], $_POST['name']);
        header("location: ".URLROOT."/public/AdminController/users");
    }

    public function deleteUser()
    {
        global $USER;
        $USER -> deleteUserData($_POST['User_ID']);
        header("location: ".URLROOT."/public/AdminController/users");
    }
}