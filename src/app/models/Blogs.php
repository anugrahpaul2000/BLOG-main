<?php
    // namespace Model;

    use libraries\Database;

use function PHPSTORM_META\type;

class Blogs
{
    private $db;
    private $status;

    public function __construct()
    {
        $this -> db = new Database;
        $this -> status = "Pending";
    }

    public function addBlog($name, $content, $Author_ID)
    {
        $this -> db -> query("
        INSERT INTO `Blogs` (`Blog_Name`, `Blog_Content`, `Blog_Author_ID`, `Blog_Status`) VALUES ('".$name."', '".$content."', '".$Author_ID."', '".$this -> status."');
        ");

        return ($this -> db -> execute());
    }

    /**
     * getAllBlog
     * Fetches and returns all Blogs from
     * Blogs table
     * @return rows
     */
    public function getAllBlogs()
    {
        $this -> db -> query("
        SELECT `Blog_ID`, `Blog_Name`, `Name`, `Blog_Status` FROM `Blogs`, `User_Details` WHERE `Blog_Author_ID` = `User_ID`;
        ");
        $result = ($this -> db -> resultSet());
        return $result;
    }

    /**
     * change Blog Status
     * updates the status of Blog
     * Approved | Pending | Restricted
     * @param [type] $status
     * @param [type] $id
     * @return string
     */
    public function changeBlogStatus($status, $id)
    {
        $this -> db -> query("
        UPDATE `Blogs` SET `Blog_Status` = '".$status."' WHERE `Blogs`.`Blog_ID` = '".$id."' ;
        ");
        return ($this -> db -> execute());
    }

    /**
     * Getting all details from the Database of Blog
     *
     * @param [type] $Blog_ID
     * @return
     * all rows or error
     */
    public function getBlog($Blog_ID)
    {
        $this -> db -> query("
        SELECT `Blog_ID`, `Blog_Name`, `Blog_Content`, `Name`, `Blog_Status` FROM `Blogs`, `User_Details` WHERE `Blog_Author_ID` = `User_ID`;
        ");
        return ($this -> db -> resultSet())[0];
    }

    public function blogStatusCheck($blog_ID)
    {
        $this -> db -> query("
        SELECT `Blog_Status` FROM `Blogs` WHERE `Blog_ID` = ".$blog_ID.";
        ");
        return (array)($this -> db -> resultSet())[0];
    }

    /**
     * Blog Edit False
     * Default Print of Individual Blog for Admin Blog Page
     * No Input Fields
     *
     * @param [type] $value
     * @return html
     */
    public function blogEditFalse($value)
    {
        switch ($value -> Blog_Status)
        {
            case 'Approved':
                $userStatus = "success";
                break;
            
            case 'Restricted':
                $userStatus = "danger";
                break;

            case 'Pending':
                $userStatus = "warning";
                break;
        }        
        $html='
            <form method="POST" action="'.URLROOT.'/public/AdminController/blogChangeData">
            <tr class="text-align-center bg-'.$userStatus.' text-light">
                <td class="p-3 text-start">'.$value -> Blog_ID.'</td>
                <td class="p-3">'.$value -> Blog_Name.'</td>
                <td class="p-3 fst-italic">'.$value -> Name.' <input type="hidden" name="Blog_ID" 
                value='.$value -> Blog_ID.'> </td>
                ';

        switch ($value -> Blog_Status)
        {
            case 'Approved':
                $html.= '<td class="p-1">
                    <select class="m-1 p-2 rounded" name="status">
                        <option>Approved</option>
                        <option>Restricted</option>
                        <option>Pending</option>
                    </select></td>';
                break;
            
            case 'Restricted':
                $html.= '<td class="p-1">
                    <select class="m-1 p-2 rounded" name="status">
                        <option>Restricted</option>
                        <option>Approved</option>
                        <option>Pending</option>
                    </select></td>';
                break;

            case 'Pending':
                $html.= '<td class="p-1">
                    <select class="m-1 p-2 rounded" name="status">
                        <option>Pending</option>
                        <option>Approved</option>
                        <option>Restricted</option>
                    </select></td>';
                break;
        }
        $html.='
            <td class="p-1">
                <button class="m-1 p-2 border-0 btn-'.$userStatus.' rounded" name="action" value="statusBlog"> 
                    Update Status
                </button>
            </td>
        </tr>
        </form>';
        return $html;
    }

    public function printPostPreviews()
    {
        $data = $this -> getAllBlogs();
        $html = '';
        foreach ($data as $post) {
            $html.='
            <div class="post-preview">
            <form action="'.URLROOT.'/public/BlogController/post" method="POST">
                    <h2 class="post-title">'.$post -> Blog_Name.'</h2>
                <p class="post-meta">
                    Posted by '.$post -> Name.'
                </p>
                <button name="Blog_ID" value="'.$post -> Blog_ID.'" class="p-2 btn rounded bg-primary text-light">
                    Read Post
                </button>
            </form>
            </div>
            <!-- Divider-->
            <hr class="my-4" />
            ';
        }
        return $html;
    }

    public function printPost($Blog_ID)
    {
        $result = $this -> getBlog($Blog_ID);
        $html='
            <p>'.$result -> Blog_Content.'</p>
        ';
        return $html;
    }

    public function printHeadingPost($Blog_ID)
    {
        $result = $this -> getBlog($Blog_ID);
        $html='
            <h1>'.$result -> Blog_Name.'</h1>
            <span class="meta">
                Posted by
                    '.$result -> Name.'
            </span>
        ';
        return $html;
    }
}