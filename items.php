<?php
	include 'datafile.php';
	$itemList = $system_app->getItemList();
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Items</title>
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
					$orders_drop_active = "";
					$orders_active = "";
					$orderDetails_active = "";
					$master_drop_active = "active";
					$categories_active = "";
					$items_active = "active";
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
                  <a href="items.php" class="text-decoration-none text-muted h4 text-center"><i class="fas fa-pencil-alt"></i> Items</a>
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
							<a href="" class="btn btn-muted float-end" data-toggle="modal" data-target="#addItem"><i class="fas fa-plus-circle"></i> Add Item</a>		
						</div>        
					</div>
					<table class="table table-hover table-light" id="scrolltable-items">
						<thead class="table-dark text-center">
							<tr>
								<th class="align-top" rowspan=2>Item ID</th>
								<th class="align-top" rowspan=2>Category Name</th>
								<th class="align-top" rowspan=2>Item Name</th>
								<th class="align-top" rowspan=2>Product No.</th>
								<th class="align-top border-0 pb-0">Purchase Price</th>
								<th class="align-top border-0 pb-0">Sales Price</th>
								<th class="align-top border-0 pb-0" colspan=3>Order Point</th>
								<th class="align-top" rowspan=2></th>
								<th class="align-top" rowspan=2></th>
							</tr>
							<tr>
								<!-- <td class="py-0"></td> -->
								<!-- <td class="py-0"></td> -->
								<!-- <td class="py-0"></td> -->
								<!-- <td class="py-0"></td> -->
								<td class="align-top py-1 border-0">(&yen;)</td>
								<td class="align-top py-1 border-0">(&yen;)</td>
								<td class="align-top py-1 border-0">(min)</td>
								<td class="align-top py-1 border-0">-</td>
								<td class="align-top py-1 border-0">(max)</td>
								<!-- <td class="py-0"></td> -->
								<!-- <td class="py-0"></td> -->
							</tr>
						</tdead>
						<tbody>
							<?php foreach((array)$itemList as $row){ 
								if($row["item_id"]==""){?>												
								<tr>
									<td class="text-center bg-light"colspan=11>No data.</td>
								</tr>
								<?php }else{?>
								<tr>
									<td><?php echo $row['item_id']; ?></td>
									<td><?php echo $row['category_name']; ?></td>
									<td><?php echo $row['item_name']; ?></td>
									<td><?php echo $row['product_number']; ?></td>
									<td class="text-right"><?php echo number_format($row['purchase_price'],2); ?></td>
									<td class="text-right"><?php echo number_format($row['sales_price'],2); ?></td>
									<td class="text-right"><?php echo $row['min_qty']; ?></td>
									<td>-</td>
									<td class="text-right"><?php echo $row['max_qty']; ?></td>

									<td><a href="" class="btn btn-warning text-light float-end" data-toggle="modal" data-target="#editItem<?php echo $row['item_id'];?>">Update</a>
									</td>

									<td><a href="" class="btn btn-danger text-light float-end" data-toggle="modal" data-target="#deleteItem<?php echo $row['item_id'];?>">Delete</a>	
									</td>
								</tr>
							<?php }}?>               
						</tbody>       
					</table>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<?php foreach((array)$itemList as $row)
		{ ?> 
		<!-- Modal Add Item -->
		<div class="modal fade" id="addItem" tabindex='-1' aria-labelledby="addItemLabel" aria-hidden="true">                                
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>
						<h5 class='modal-title'><i class="fas fa-plus-circle"></i> Add Item</h5>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="datafile.php" method="post">                                  
						<div class='modal-body'>                               
							<label for="categoryName" class="form-label">Category Name</label>
							<select name="categoryName" id="categoryName" class="form-control">
								<?php $system_app->displayCategoriesAsOptions(); ?>
							</select>

							<label for="itemName" class="form-label">Item Name</label>
							<input type="text" name="itemName" id="itemName" class="form-control"></input>

							<label for="productNo" class="form-label">Product No</label>
							<input type="text" name="productNo" id="productNo" class="form-control"></input>

							<label for="purchasePrice" class="form-label">Purchase Price</label>
							<input type="number" name="purchasePrice" id="purchasePrice" class="form-control"></input>

							<label for="salesPrice" class="form-label">Salse Price</label>
							<input type="number" name="salesPrice" id="salesPrice" class="form-control"></input>

							<label for="orderPoint" class="form-label">Order Point</label>
							<div class="row">                                       
								<div class="col-5">
									<input type="number" name="minQty" id="minQty" class="form-control" placeholder="Minimum qty"></input>
								</div>
								<div class="col-2 text-center">
									-
								</div>
								<div class="col-5">
									<input type="number" name="maxQty" id="maxQty" class="form-control" placeholder="Max qty"></input>
								</div>
							</div>                                    
						</div>
						<div class="modal-footer">
							<input type="submit" name="addItem" class="btn btn-primary" value="Add"></input>
							<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
						</div>  
					</form>                                     
				</div>
			</div>
		</div>

		<!-- Modal Edit Item -->
		<div class="modal fade" id="editItem<?php echo $row['item_id'];?>" tabindex="-1" aria-labelledby="editItem<?php echo $row['item_id'];?>Label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class='modal-title'><i class="fas fa-edit"></i> Edit Item</h5>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="datafile.php" method="post">
						<div class='modal-body'>
							<input type="hidden" name="itemId" id="itemId" class="form-control" value="<?php echo $row["item_id"]; ?>"></input>

							<label for="categoryName" class="form-label">Category Name</label>
							<select name="categoryName" id="categoryName" class="form-control">
								<?php $system_app->displaySelectedCategoriesAsOptions($row['category_id']); ?>
							</select>

							<label for="itemName" class="form-label">Item Name</label>
							<input type="text" name="itemName" id="itemName" class="form-control" value="<?php echo $row["item_name"]; ?>"></input>

							<label for="productNo" class="form-label">Product No</label>
							<input type="text" name="productNo" id="productNo" class="form-control" value="<?php echo $row["product_number"]; ?>"></input>

							<label for="purchasePrice" class="form-label">Purchase Price</label>
							<input type="number" name="purchasePrice" id="purchasePrice" class="form-control" value="<?php echo $row["purchase_price"]; ?>"></input>

							<label for="salesPrice" class="form-label">Salse Price</label>
							<input type="number" name="salesPrice" id="salesPrice" class="form-control" value="<?php echo $row["sales_price"]; ?>"></input>

							<label for="orderPoint" class="form-label">Order Point</label>
							<div class="row">                                       
								<div class="col-5">
									<input type="number" name="minQty" id="minQty" class="form-control" placeholder="Minimum qty" value="<?php echo $row["min_qty"]; ?>"></input>
								</div>
								<div class="col-2 text-center">
									-
								</div>
								<div class="col-5">
									<input type="number" name="maxQty" id="maxQty" class="form-control" placeholder="Max qty" value="<?php echo $row["max_qty"]; ?>"></input>
								</div>
							</div>  
						</div>
						<div class="modal-footer">
								<input type="submit" name="editItem" class="btn btn-primary" value="Edit"></input>
								<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
						</div>  
					</form>
				</div>
			</div>
		</div>

		<!-- Modal Delete Item -->
		<div class="modal fade" id="deleteItem<?php echo $row['item_id'];?>" tabindex="-1" aria-labelledby="deleteItem<?php echo $row['item_id'];?>Label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class='modal-title'><i class="fas fa-trash-alt"></i> Delete Item</h5>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden="true">&times;</span>
						</button>
					</div> 
					<form action="datafile.php" method="post">   
						<div class='modal-body'>
							<input type="hidden" name="itemId" id="itemId" class="form-control" value="<?php echo $row["item_id"]; ?>"></input>
							<p class="text-center">Are you sure you want to delete "<span class="text-danger font-weight-bold"><?php echo $row['item_id'].". ".$row['item_name']." (".$row['product_number'].")"; ?></span>" from item list?</p>
						</div> 
						<div class="modal-footer">
							<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>   
							<input type="submit" name="deleteItem" class="btn btn-primary" value="Continue"></input>
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