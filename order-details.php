<?php
	include 'datafile.php';
	$orderList = $system_app->getOrder();   
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Order Details</title>
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
			<div>
				<?php
					$dashboard_active = "";
					$stocks_drop_active = "";
					$stocks_active = "";
					$stockDetails_active = "";
					$orders_drop_active = "active";
					$orders_active = "";
					$orderDetails_active = "active";
					$master_drop_active = "";
					$categories_active = "";
					$items_active = "";
					$users_active ="";

					$system_app->navbar($dashboard_active,$stocks_drop_active,$stocks_active,$stockDetails_active,$orders_drop_active,$orders_active,$orderDetails_active,$master_drop_active,$categories_active,$items_active,$users_active);
					
				?>
			</div>
			<div class="" id="content">
				<nav class="navbar navbar-expand-lg navbar-transparent nabvar-absolute fixed-top navbar-light border-bottom border-dark border-2">
          <div class="container-fluid">
            <div class="nabvar-wrapper">
              <div class="navbar-minimize d-flex align-item-center">
                <button type="button" id="sidebarCollapse" class="navbar-btn btn-fab btn-round mr-2">
                  <i class="fas fa-chevron-right text-muted"></i>
                </button>

                <span class="align-center">
                  <a href="order-details.php" class="text-decoration-none text-muted h4 text-center"><i class="fas fa-shipping-fast"></i> Order Details</a>
                </span>
              </div>             
            </div>
            <button type="button" class="navbar-toggler" data-target="#menu" data-toggle="collapse">
              <span class="navbar-toggler-icon"></span>
            </button>    
            <div class="collapse navbar-collapse" id="menu">
              <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
										<a href="profile.php?id=<?php echo $_SESSION['login_id'];?>" class="nav-link"><i class="fas fa-user"></i> <?php echo $_SESSION['firstname']." ".$_SESSION['lastname'];?></a>
                  </li>
                  <li class="nav-item">
                    <a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
                  </li>
                </ul>
            </div>
          </div>
        </nav>
				<div class="container">
					<div class="row mt-3">
						<div class="col-lg-12">
							<?php
								if(isset($_GET["success"]) && isset($_GET["message"]))
								{
									$stat = ($_GET["success"]==1)?"success":"danger";
									$message = $_GET["message"];

									echo "<div class='alert alert-".$stat." text-center' role='alert'>".$message."</div>";
								}
							?>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col">
							<a href="orders.php" class="btn btn-muted float-end" ><i class="fas fa-plus-circle"></i> Add Order</a>
						</div>  								
					</div>
					<table class="table table-hover table-light">
						<thead class="table-dark">
							<tr>
								<th class="align-top">#</th>
								<th class="align-top">Date</th>
								<th class="align-top">Item Id</th>
								<th class="align-top">Item Name</th>
								<th class="align-top">Category Name</th>
								<th class="align-top">Order Qty</th>
								<th class="align-top">Recieved Qty</th>
								<th class="align-top">Not Recieved Qty</th>
								<th class="align-top">Status</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach((array)$orderList as $row)
							{ 
								if($row["item_id"]==""){?>												
								<tr>
								<td class="text-center bg-light"colspan=9>No data.</td>
								</tr>
								<?php }else{?>
								<tr>
									<td><?php echo $row['order_id']; ?></td>
									<td><?php echo $row['order_date']; ?></td>
									<td><?php echo $row['item_id']; ?></td>
									<td><?php echo $row['item_name']; ?></td>
									<td><?php echo $row['category_name']; ?></td>
									<td class="text-right"><?php echo number_format($row['order_qty'],0); ?></td>
									<td class="text-right"><?php echo number_format($row['in_qty'],0); ?></td>
									<td class="text-right"><?php echo number_format($row['not_received_qty'],0); ?></td>
									<?php
										if($row['status'] == 'In Transit'){ ?>                           
											<td><span class="badge badge-pill badge-info"><?php echo ($row['status']); ?></span></td>
										<?php }else{ ?>                           
												<td><span class="badge badge-pill badge-danger"><?php echo ($row['status']); ?></span></td>
										<?php   
										}
									?>
								</tr>
							<?php }}?>               
						</tbody>       
					</table>
				</div>
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