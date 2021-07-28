<?php
	include 'datafile.php';
	$stockList = $system_app->getStock();
	$orderList = $system_app->getOrder();  
?>
<!doctype html>
<html lang="en">
  <head>
    <title>All Stocks</title>
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
					$stocks_drop_active = "active";
					$stocks_active = "active";
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
                  <a href="stocks.php" class="text-decoration-none text-muted h4 text-center"><i class="far fa-clipboard"></i> All Stocks</a>
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
							<a href="" class="btn btn-muted float-end" data-toggle="modal" data-target="#addStock"><i class="fas fa-plus-circle"></i> Add Stock</a>
						</div>        
					</div>
					<table class="table table-hover table-light" id="scrolltable-stocks">
						<thead class="table-dark">
							<tr>
								<th class="align-top">#</th>
								<th class="align-top">Item Name</th>
								<th class="align-top">Product No.</th>
								<th class="align-top">Category Name</th>
								<th class="align-top">Total Qty</th>
								<th class="align-top" colspan=2>In / Out</th>
								<th class="align-top" colspan=3 >Order Point</th>
								<!-- <th style="width:50px;"></th> -->
								<th>(Ref.) In Transit Qty</th>
							</tr>
						</thead>
						<tbody class="">
							<?php foreach((array)$stockList as $row)
							{ 
								if($row["item_id"]==""){?>												
								<tr>
									<td class="text-center bg-light"colspan=11>No data.</td>
								</tr>
							<?php }else{?>
								<tr>
									<td><a href="stock-details.php?item_id=<?php echo $row['item_id'];?>" class="text-muted"><?php echo $row['item_id']; ?></a></td>
									<td><?php echo $row['item_name']; ?></td>
									<td><?php echo $row['product_number']; ?></td>
									<td><?php echo $row['category_name']; ?></td>
									<td class="text-right"><?php echo number_format($row['sum(sum_qty)'],0); ?></td>
									<td class="px-2"><a href="" class="btn btn-primary text-light px-3" data-toggle="modal" data-target="#stockIn<?php echo $row['item_id'];?>">In</a></td>								
									<td class="px-2"><a href="" class="btn btn-danger text-light" data-toggle="modal" data-target="#stockOut<?php echo $row['item_id'];?>">Out</a></td>
									<td><?php
										if($row["item_id"]=="")
										{
											echo "";
										}else{
											$system_app->alertOrderPoint($row['item_id']);} ?></td>
									<td><?php echo "(".$row['min_qty']." - ".$row['max_qty'].")";?></td>
									<td><a href="orders.php?item_id=<?php echo $row['item_id'];?>" class="btn btn-warning text-light">Order</a></td>
									<td class="text-right">(<?php $system_app->getNotReceivedQty($row['item_id']); ?>)</td>
								</tr>
							<?php }}?>               
						</tbody>       
					</table>
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
							<select name="details" id="details" class="form-control">
								<option selected disabled>Select Details</option>
								<option value="Physical Inventory">Physical Inventory</option>
								<option value="Received">Received</option>
								<option value="Sales">Sales</option>
								<option value="Others">Others</option>
							</select>

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
								<select name="details" id="details" class="form-control">
									<option selected disabled>Select Details</option>
									<option value="Physical Inventory">Physical Inventory</option>
									<option value="Received">Received</option>
									<option value="Sales">Sales</option>
									<option value="Others">Others</option>
								</select>

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
						<h5 class='modal-title'><i class="fas fa-minus-circle"></i> Out</h5>
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
							<select name="details" id="details" class="form-control">
								<option selected disabled>Select Details</option>
								<option value="Physical Inventory">Physical Inventory</option>
								<option value="Received">Received</option>
								<option value="Sales">Sales</option>
								<option value="Others">Others</option>
							</select>

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