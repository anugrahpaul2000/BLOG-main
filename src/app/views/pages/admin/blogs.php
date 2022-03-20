<?php
global $USER;
if (!($USER -> getUserData($_SESSION['user'], 'Status') == 'Approved') && !($USER -> getUserData($_SESSION['user'], 'Role') == 'Admin')) {
  header("location: ".URLROOT."/public/pages/login");
}
?>
<!doctype html>
<html lang="en">
<?php include_once("../app/views/partials/admin/header.php");?>
  
<div class="container-fluid">
  <div class="row">
  <?php include_once("../app/views/partials/admin/navbar.php");?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Products</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>
        </div>
      </div>

      <!-- <form class="row row-cols-lg-auto g-3 align-items-center">
        <div class="col-12">
          <label class="visually-hidden" for="inlineFormInputGroupUsername">Search</label>
          <div class="input-group">
            <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="Enter id,name...">
          </div>
        </div>
      
        
      
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Search</button>
        </div>
        <div class="col-12">
          <a class="btn btn-success" href="add-product.html">Add Product</a>
        </div>
      </form> -->
      <div class="table-responsive">
        <table class="table table-sm">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Author</th>
              <th scope="col">Status</th>
              <th scope="col">Update Status</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              global $ADMIN;
              echo ($ADMIN -> printAllBlogs());
            ?>
          </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item"><a class="page-link" href="#">Previous</a></li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
          </nav>
      </div>
    </main>
  </div>
</div>


    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>