<?php
	include 'datafile.php';
	$stock_amount = $system_app->totalAmountOfStock();
	$stockList = $system_app->getStock();
	
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Dashboard</title>
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
					$dashboard_active = "active";
					$stocks_drop_active = "";
					$stocks_active = "";
					$stockDetails_active = "";
					$orders_drop_active = "";
					$orders_active = "";
					$orderDetails_active = "";
					$master_drop_active = "";
					$categories_active = "";
					$items_active = "";
					$users_active = "";

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
                  <a href="dashboard.php" class="text-decoration-none text-muted h4 text-center"><i class="far fa-clipboard"></i> Dashboard</a>
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
					<div class="row mt-5">
						<div class="card-deck">
							<div class="col-auto mb-3">
								<div class="card" style="width: 300px; height: 250px;">
									<div class="card-header bg-danger text-white">
										<h4><i class="fas fa-boxes"></i> Stock</h4>
									</div>
									<div class="card-body">
										<h4 class="card-title">Total Amount :</h4>
										<h3 class="card-text text-right"><span class="h5">&yen;</span> <?php echo number_format($stock_amount['total_amount'],0); ?></h3>
									</div>
									<div class="card-footer bg-transparent">
										<p class="card-text text-center"><a href="stocks.php" class="btn btn-outline-dark"><i class="fas fa-angle-double-right"></i> Details</a></p>
									</div>
								</div>
							</div>
							<div class="col-auto mb-3">
								<div class="card" style="width: 300px; height: 250px;">
									<div class="card-header bg-warning text-white">
										<h4><i class='fas fa-shopping-cart'></i> Order</h4>
									</div>
									<div class="card-body">
										<h4 class="card-title">On Order:</h4>
										<h3 class="card-text text-right"><?php echo number_format($system_app->countOrders(),0); ?> <span class="h5">items</span></h3>
									</div>
									<div class="card-footer bg-transparent">
										<p class="card-text text-center"><a href="order-details.php" class="btn btn-outline-dark"><i class="fas fa-angle-double-right"></i> Details</a></p>
									</div>
								</div>
							</div>
							<div class="col-auto mb-3">
								<div class="card" style="width: 300px; height: 250px;">
									<div class="card-header bg-primary text-white">
										<h4><i class="fas fa-coins"></i> Sales</h4>
									</div>
									<div class="card-body">
										<h4 class="card-title">Total Amount:</h4>
										<h5 class="card-text text-right">Comming Soon</h5>
									</div>
									<div class="card-footer bg-transparent">
										<p class="card-text text-center"><a href="#" class="btn btn-outline-dark"><i class="fas fa-angle-double-right"></i> Coming Soon</a></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
      </div>   
    </div>

		<!-- Modal -->
		<?php foreach((array)$stockList as $row)
		{ ?>
		<!-- Modal Add Stock -->
		<div class="modal fade" id="addStock" tabindex='-1' aria-labelledby="addStockLabel" aria-hidden="true">
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>
						<h5 class='modal-title'><i class="fas fa-plus-circle"></i> Add Stock</h5>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
								<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="datafile.php" method="post">                                  
						<div class='modal-body'>
							<label for="itemName" class="form-label">Item Name</label>
							<select name="itemName" id="itemName" class="form-control">
									<?php $system_app->displayItemsAsOptions(); ?>
							</select>

							<label for="details" class="form-label">Details</label>
							<input type="text" name="details" id="details" class="form-control"></input>

							<label for="orderNo" class="form-label">Order Number</label>
								<select name="orderNo" id="orderNo" class="form-control">
									<?php  $system_app->displayOrdersAsOptions();?>
								</select>

							<label for="inQty" class="form-label">In(qty)</label>
							<input type="number" name="inQty" id="inQty" class="form-control"></input>  

							<input type="hidden" name="outQty" id="outQty" class="form-control" value=0></input>

						</div>
						<div class="modal-footer">
							<input type="submit" name="adjustStock" class="btn btn-primary" value="Add"></input>
							<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>                              
						</div>  
					</form>                                     
				</div>
			</div>
		</div>

		<!-- Modal Edit Stock (IN) -->
		<div class="modal fade" id="stockIn<?php echo $row['item_id'];?>" tabindex='-1' aria-labelledby="stockIn<?php echo $row['item_id'];?>Label" aria-hidden="true">
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>
						<h5 class='modal-title'><i class="fas fa-plus-circle"></i> In</h5>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
						<form action="datafile.php" method="post">                      
							<div class='modal-body'>
								<input type="hidden" name="itemId" id="itemId" class="form-control" value="<?php echo $row["item_id"]; ?>"></input>

								<label for="itemName" class="form-label">Item Name</label>
								<select name="itemName" id="itemName" class="form-control">
									<?php  $system_app->displaySelectedItemsAsOptions($row['item_id'])?>
								</select>

								<label for="details" class="form-label">Details</label>
								<input type="text" name="details" id="details" class="form-control"></input>

								<label for="orderNo" class="form-label">Order Number</label>
								<select name="orderNo" id="orderNo" class="form-control">
									<?php  $system_app->displaySelectedOrdersAsOptions($row['item_id'])?>
								</select>

								<label for="inQty" class="form-label">In(qty)</label>
								<input type="number" name="inQty" id="inQty" class="form-control"></input>  
						
								<input type="hidden" name="outQty" id="outQty" class="form-control" value=0></input>

							</div>
							<div class="modal-footer">
								<input type="submit" name="adjustStock" class="btn btn-primary" value="In"></input>
								<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
							</div>  
						</form>                                     
						</div>
				</div>
		</div>

		<!-- Modal Edit Stock (OUT) -->
		<div class="modal fade" id="stockOut<?php echo $row['item_id'];?>" tabindex='-1' aria-labelledby="stockOut<?php echo $row['item_id'];?>Label" aria-hidden="true">
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>
						<h5 class='modal-title'><i class="fas fa-plus-circle"></i> Out</h5>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="datafile.php" method="post">        
						<div class='modal-body'>
							<input type="hidden" name="itemId" id="itemId" class="form-control" value="<?php echo $row["item_id"]; ?>"></input>

							<label for="itemName" class="form-label">Item Name</label>
							<select name="itemName" id="itemName" class="form-control">
								<?php  $system_app->displaySelectedItemsAsOptions($row['item_id'])?>
							</select>

							<label for="details" class="form-label">Details</label>
							<input type="text" name="details" id="details" class="form-control"></input>

							<input type="hidden" name="orderNo" id="orderNo" class="form-control" value="-"></input>

							<input type="hidden" name="inQty" id="inQty" class="form-control" value=0></input>  

							<label for="outQty" class="form-label">Out(qty)</label>
							<input type="number" name="outQty" id="outQty" class="form-control"></input>   
						</div>
						<div class="modal-footer">
							<input type="submit" name="adjustStock" class="btn btn-danger" value="Out"></input>
							<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
						</div>  
					</form>                                     
				</div>
			</div>
		</div>


		<?php }?>

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