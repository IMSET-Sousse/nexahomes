<?php
  // Import the AdminAccess script to check if the user has admin access.
  require_once('scripts/AdminAccess.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="public/css/dashboard.css">
  <link rel="stylesheet" href="public/css/common.css">
  <link rel="stylesheet" href="public/css/navbar.css">
  <link rel="stylesheet" href="public/css/sidebar.css">
</head>
<body>

<div class="container-fluid">
 <div class="row">
    <div class="col-sm-3 sidebar-col">
     <?php
        // Include the left sidebar content
       require_once('views/common/left-sidebar.php');
     ?>
   </div>
   <div class="col-sm-9 dashboard-col">
    <?php
      // Include the common navbar content
       require_once('views/common/navbar.php');
     ?>
     <div class="dashboard-content">
     <?php
      // Include the database connection script
      require_once('./database.php');
      // Check if the 'page' parameter is set in the URL
      if(isset($_GET['page'])) {
        $page = $_GET['page'];
        // Determine which page to include based on the 'page' parameter
        switch($page) {
          case 'category-list':
              require_once 'views/category/table.php';
          break;

          case 'category-form':
            require_once 'views/category/form.php';
          break;
          case 'products-list':
            require_once 'views/products/table.php';
          break;
          case 'products-form':
            require_once 'views/products/form.php';
          break;
          case 'products-info':
            require_once 'views/products/view.php';
          break;

          case 'contact-list':
            require_once 'views/contact/table.php';
          break;

          case 'contact-info':
            require_once 'views/contact/view.php';
          break;

          default:
             echo "<h1 class='text-center mt-4'>404 No Page found</h1>";
        }

      } else {
         require_once('views/dashboard/index.php');
      }
    ?>
     </div>
   </div>

 </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
