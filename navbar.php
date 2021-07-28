<?php
	include 'datafile.php';
	$stockList = $system_app->getStock();
    
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Navbar</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />    
    <link rel="stylesheet" href="css/nav.css">
   

  </head>
  <body>
    <div class="wrapper">
      <nav class="" id="sidebar">
        <div class="sidebar-header">
          <h3><a href="#" class=""><i class="fas fa-dolly-flatbed"></i> Inventory</a></h3>
        </div>

        <ul class="list-unstyled components">           
          <li class="">
            <a href="dashboard.php" class="active">Home</a>
          </li>
          <li class="">
            <a href="stock-details.php" class="">Stock Details</a>
          </li>
         
          <li>
            <a href="#orderSubmenu" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">Order</a>
              <ul class="collapse list-unstyled" id="orderSubmenu">
                <li>
                  <a href="orders.php" class="">Order</a>
                </li>
                <li>
                  <a href="order-details.php" class="">Order Details</a>
                </li>
              </ul>
          </li>
          <li>
            <a href="#masterSubmenu" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">Master</a>
              <ul class="collapse list-unstyled" id="masterSubmenu">
                <li>
                  <a href="categories.php" class="">Categories</a>
                </li>
                <li>
                  <a href="items.php" class="">Items</a>
                </li>
              </ul>
          </li>         
        </ul>
      </nav>

      <div class="" id="content">       
        <nav class="navbar navbar-expand-lg navbar-transparent nabvar-absolute fixed-top navbar-light border-bottom border-dark border-2">
          <div class="container-fluid">
            <div class="nabvar-wrapper">
              <div class="navbar-minimize d-flex align-item-center">
                <button type="button" id="sidebarCollapse" class="navbar-btn btn-fab btn-round mr-2">
                  <i class="fas fa-chevron-right text-muted"></i>
                </button>

                <span class="align-center">
                  <a href="dashboard.php" class="text-decoration-none text-muted h4 text-center">Dashboard</a>
                </span>
              </div>
              
            </div>
            <button type="button" class="navbar-toggler" data-target="#menu" data-toggle="collapse">
              <span class="navbar-toggler-icon"></span>
            </button>    
            <div class="collapse navbar-collapse" id="menu">
              <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fas fa-user"></i> [firstname / lastname]</a>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
                  </li>
                </ul>
            </div>
          </div>
          


        </nav>
      </div>
    </div>
      


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script type="text/javascript">
      $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            $(this).toggleClass('active');
        });
      });
    </script>
  </body>
</html>