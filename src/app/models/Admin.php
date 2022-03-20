<?php
    // namespace Model;

use libraries\Database;

class Admin extends Database
{
    // /**
    //  * addProduct
    //  * Add Product in Store and Database
    //  *
    //  * @param [type] $SKU
    //  * @param [type] $name
    //  * @param [type] $category
    //  * @param [type] $price
    //  * @param [type] $description
    //  * @return void
    //  */
    // public function addProduct($SKU, $name, $category, $price, $description)
    // {
    //     $status = "Pending";
    //     if ($this -> imageUpload($SKU) == "Product Successfully Added") {
    //         DB::getInstance();
    //         $conn = DB::$instance;
    //         $sql = (
    //             "INSERT INTO `Product_Details` (`Product_ID`, `Product_SKU`, `Product_Name`, 
    //             `Product_Category`, `Product_Price`, `Product_Description`, 
    //             `Product_Image`, `Product_Status`) 
    //             VALUES (NULL, '".$SKU."', '".$name."', '".$category."', '".$price."',
    //              '".$description."', '".$SKU.".png', '".$status."');
    //             ");
    //         try {
    //             $conn->exec($sql);
    //             return "Product Added Successfully \nKindly wait for Confirmation Mail";
    //         } catch (\PDOException $e) {
    //             return "Some ERROR Occured";
    //         }
    //         $conn = null;
    //     } else {
    //         return "Product Not Added";
    //     }
    // }

    // /**
    //  * imageUpload
    //  * checks and Uploads Image
    //  *
    //  * @param [type] $SKU
    //  * @return void
    //  */
    // public function imageUpload($SKU)
    // {
    //     $target_dir = "../Products/product_images/";
    //     $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    //     $uploadOk = 1;
    //     $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    //     // Check if file already exists
    //     if (file_exists($target_file)) {
    //         return "Sorry, file already exists.";
    //         $uploadOk = 0;
    //     }
        
    //     // Check file size
    //     if ($_FILES["fileToUpload"]["size"] > 200000) {
    //         return "Sorry, your file is too large.";
    //         $uploadOk = 0;
    //     }
        
    //     // Allow certain file formats
    //     if ($imageFileType != "png") {
    //         return "Sorry, only PNG files are allowed.";
    //         $uploadOk = 0;
    //     }
        
    //     // Check if $uploadOk is set to 0 by an error
    //     if ($uploadOk == 0) {
    //         return "Sorry, your file was not uploaded.";
    //     } // if everything is ok, try to upload file
    //     else {
    //         if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $SKU . ".png")) {
    //             return "Product Successfully Added";
    //         } else {
    //             return "Product Not Added";
    //         }
    //     }
    // }

    /**
     * Prints All Users
     *
     * @param [type] $data
     * @return void
     */
    public function printAllUsers()
    {
        global $USER;
        $data = $USER -> getAllUsers();
        $html = '';
        foreach ($data as $value) {
            $html.= $USER -> customerEditFalse($value);
        }
        return $html;
    }

    /**
     * Print Selected User Details
     * with Input Values
     *
     * @param [type] $id
     * @return html
     */
    public function editUserPrint($id)
    {
        global $USER;
        $data = $USER -> getAllUsers();
        $html = '';
        foreach ($data as $value) {
            $userStatus = "info";
            if ($value -> User_ID == $id) {
                $html.= $USER -> customerEditTrue($value, $userStatus);
            } else {
                $html.= $USER -> customerEditFalse($value);
            }
        }
        return $html;
    }


    /**
     * displayAllBlogs
     * Prints all Blogs
     *
     * @return html
     */
    public function printAllBlogs()
    {
        global $BLOG;
        $data = $BLOG -> getAllBlogs();
        $html = '';
        foreach ($data as $value) {
            $html.= $BLOG -> blogEditFalse($value);
        }
        return $html;
    }

    // /**
    //  * Edit Product Print
    //  * with Input Fields
    //  *
    //  * @param [type] $id
    //  * @return void
    //  */
    // public function editProductPrint($id)
    // {
    //     global $PRODUCT;
    //     $data = $PRODUCT -> getAllProducts();
    //     $html = '';
    //     foreach ($data as $value) {
    //         if ($value['Product_ID'] == $id) {
    //             $html.= $PRODUCT -> productEditTrue($value, "info");
    //         } else {
    //             $html.= $PRODUCT -> productEditFalse($value);
    //         }
    //     }
    //     return $html;
    // }

    /**
     * printAllOrders
     * Prints all Orders in Orders Page for Admin
     *
     * @return void
     */
    // public function printAllOrders()
    // {
    //     global $CART;
    //     $orders = $CART -> getAllOrders();
    //     $html = '';
    //     foreach ($orders as $value) {
    //         $html.= $CART -> orderEditFalse($value);
    //     }
    //     return $html;
    // }
}
