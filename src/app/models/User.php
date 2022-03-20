<?php
    // namespace Model;

    use libraries\Database;

use function PHPSTORM_META\type;

class User
{
    private $db;
    private $role;
    private $status;

    public function __construct()
    {
        $this -> db = new Database;
        $this -> role = "User";
        $this -> status = "Pending";
    }

    /**
     * addUser
     * Get and Insert to the Database
     * @param [type] $email
     * @param [type] $name
     * @param [type] $password
     * @return void
     */
    public function addUser($email, $name, $password)
    {
        $this -> db -> query("
                INSERT INTO `User_Details` (`Name`, `Email`, `Password`, `Role`, `Status`) 
                VALUES ('".$name."', '".$email."', '".$password."',
                '".$this->role."', '".$this->status."');
        ");
        return ($this -> db -> execute());
    }

    /**
     * Getting all details from the Database if Email and Password authenticate
     *
     * @param [type] $email
     * @param [type] $password
     * @return
     * all rows or error
     */
    public function getUser($email, $password)
    {
        $this -> db -> query("
            SELECT * FROM `User_Details` WHERE (`Email` = '".$email."' and `Password` = '".$password."')
        ");
        $result = ($this -> db -> resultSet())[0];
        $this -> signInAuthenticate($result);
    }

    //Sign In User
    public function signInAuthenticate($result)
    {
        echo $result -> Role;
        echo count((array)$result);
        if (count((array)$result) == 6) {
            $_SESSION['user']=$result;
            /**
             * Redirect to Login if Status is Restricted
             */
            $this -> checkStatus();
            /**
             * If Status is Approved check Role
             */
            $this -> checkRole();
        } else {
            // header('location: login.php?signup=error');
        }
    }

    /**
    * checkStatus
    * If Logged in USER Status is Restricted
    * returns to login page
    * @return void
    */
    public function checkStatus()
    {
        global $USER;
        if (($USER -> getUserData($_SESSION['user'], 'Status')) != 'Approved') {
            header('location: '.URLROOT.'/public/pages/login');
            exit(0);
        }
    }

    /**
     * checkRole
     * Checks the Role of the Logged in User and redirects Accordingly
     * @return void
     */
    public function checkRole()
    {
        global $USER, $CART;
        // $CART -> storeCartDetailInSession($CART -> getAllCart($USER -> getUserData($_SESSION, 'User_ID')));

        switch ($USER -> getUserData($_SESSION['user'], 'Role'))
        {
            case 'Admin':
                header('location: '.URLROOT.'/public/AdminController/admin');
                // header('location: ./Admin/admin_dashboard.php');
                break;
            
            case 'Customer':
                // header('location: ./customer/userdashboard.php');
                header('location: '.URLROOT.'/public/pages/');
                break;
        }
    }


    /**
     * sessionSetCheck
     * checks if session is set with user
     * @param [type] $_SESSION
     * @return void
     */
    public function sessionSetCheck($SESSION)
    {
        return isset($SESSION['user'][0]);
    }

    /**
     * getUserData
     * returns the data from session
     *
     * @param [type] $_SESSION
     * @param [type] $data
     * $data = 'Status' | 'Role' | 'User_ID'
     * @return void
     */
    public function getUserData($object, $data)
    {
        switch ($data)
        {
            case 'Status':
                return $object -> Status;
            
            case 'Role':
                return $object -> Role;

            case 'User_ID':
                return $object -> User_ID;
        }
    }

    /**
     * getAllUsers
     * Fetches and returns the data of all users from
     * User_Details table
     * @return rows
     */
    public function getAllUsers()
    {
        $this -> db -> query("
            SELECT User_ID, Name, Email, Role, Status FROM `User_Details`
        ");
        $result = ($this -> db -> resultSet());
        return $result;
    }

    /**
     * getUserDetails
     * gets User Details from User_ID
     *
     * @param [type] $id
     * @return void
     */
    public function getUserDetails($id)
    {
        // DB::getInstance();
        // $conn = DB::$instance;
        $sql = "SELECT * FROM `User_Details` WHERE `User_ID` = ".$id."";
        // $result = $conn->query($sql);
        // $result -> setFetchMode(\PDO::FETCH_ASSOC);
        $conn = null;
        // return $result -> fetchall();
    }

    /**
     * change User Status
     * updates the status of User
     * Approved | Pending | Restricted
     * @param [type] $status
     * @param [type] $id
     * @return string
     */
    public function changeUserStatus($status, $id)
    {
        $this -> db -> query("
        UPDATE `User_Details` SET `Status` = '".$status."' WHERE `User_Details`.`User_ID` = '".$id."' ;
        ");
        return ($this -> db -> execute());
    }

    /**
     * updateUserData
     * updates User Data
     *
     * @param [type] $id
     * @param [type] $name
     * @return void
     */
    public function updateUserData($id, $name)
    {
        $this -> db -> query("
        UPDATE `User_Details` SET `Status` = 'Pending', `Name` = '".$name."' WHERE `User_Details`.`User_ID` = '".$id."' ;
        ");
        return ($this -> db -> execute());
    }

    /**
     * deleteUserData
     * deletes User from Database
     *
     * @param [type] $id
     * @return void
     */
    public function deleteUserData($id)
    {
        $this -> db -> query("
        DELETE FROM `User_Details` WHERE `User_Details`.`User_ID` = '".$id."' ;
        ");
        return ($this -> db -> execute());
    }

    /**
     * Customer Edit False
     * Default Print of Individual User for Admin Customer Page
     * No Input Fields
     *
     * @param [type] $value
     * @return html
     */
    public function customerEditFalse($value)
    {
        switch ($value -> Status)
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
            <form method="POST" action="'.URLROOT.'/public/AdminController/userChangeData">
            <tr class="text-align-center bg-'.$userStatus.' text-light">
                <td class="p-3 text-start">'.$value -> User_ID.'</td>
                <td class="p-3">'.$value -> Name.'</td>
                <td class="p-3 fst-italic">'.$value -> Email.' </td>
                <td class="p-3 fw-bold">'.$value -> Role.'<input type="hidden" name="User_ID" 
                value='.$value -> User_ID.'> </td>
                <td class="p-1"><a class="m-1 p-2 btn-primary rounded text-decoration-none text-center" 
                href="?action=edit&id='.$value -> User_ID.'" 
                name="action" value="edit"  type="submit">Edit User</a></td>
                <td class="p-1"><button class="m-1 p-2 btn-danger rounded" name="action" 
                value="deleteUser" type="submit">Delete</button></td>';

        switch ($value -> Status)
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
                <button class="m-1 p-2 border-0 btn-'.$userStatus.' rounded" name="action" value="statusUser"> 
                    Update Status
                </button>
            </td>
        </tr>
        </form>';
        return $html;
    }

    /**
     * Customer Edit True
     * Print of Individual User for Admin Customer Page with
     * Input Fields
     *
     * @param [type] $value
     * @param [type] $userStatus
     * @return html
     */
    public function customerEditTrue($value, $userStatus)
    {
        switch ($value -> Status)
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
                <form method="POST" action="'.URLROOT.'/public/AdminController/userChangeData">
                <tr class="text-align-center bg-'.$userStatus.' text-light">
                    <td class="p-3 text-start">'.$value -> User_ID.'</td>
                    <td class="p-3"><input type="text" name="name" value="'.$value -> Name.'"></td>
                    <td class="p-3 fst-italic">'.$value -> Email.' </td>
                    <td class="p-3 fw-bold">'.$value -> Role.'<input type="hidden" name="User_ID" 
                    value='.$value -> User_ID.'> </td>
                    <td class="p-1"><button class="m-1 p-2 btn-primary rounded" name="action" 
                    value="updateUser" type="submit">Update User</button></td>
                    <td class="p-1"><button class="m-1 p-2 btn-danger rounded" name="action" 
                    value="deleteUser" type="submit" disabled>Delete</button></td>';

        switch ($value -> Status)
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
                    <button class="m-1 p-2 border-0 btn-'.$userStatus.' rounded" name="action" value="statusUser" disabled> 
                        Update Status
                    </button>
                </td>
            </tr>
        </form>';
        return $html;
    }

    /**
     * printAllOrders
     * prints All Orders for Customer in Dashboard
     *
     * @return void
     */
    public function printAllOrders()
    {
        global $CART;
        $orders = $CART -> getAllOrders();
        $html = '';
        foreach ($orders as $value) {
            $html.= $CART -> ordersCustomer($value);
        }
        return $html;
    }
}
