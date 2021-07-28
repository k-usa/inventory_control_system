<?php
	include 'datafile.php';

	if(empty($_GET['item_id']))
	{
		$item_id = 0;
	}
	else
	{
		$item_id = $_GET['item_id'];
	}

	$stockDetails = $system_app->getStockDetails($item_id);
	$stockInfo = $system_app->getStockInfo($item_id);
  
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Stock Details</title>
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
						$stocks_active = "";
						$stockDetails_active = "active";
						$orders_drop_active = "";
						$orders_active = "";
						$orderDetails_active = "";
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
                  <a href="stock-details.php" class="text-decoration-none text-muted h4 text-center"><i class="fas fa-boxes"></i> Stock Details</a>
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
						<form action="" method="get" class="form-inline">
							<select name="item_id" id="item_id" class="form-control mx-3">
								<?php $system_app->displayItemsAsOptions();?>
							</select>
							<button class="btn btn-outline-success my-2 mu-sm-0" type="submit">Search</button>
						</form>
					</div>
					<div class="row my-3">
						<?php if($item_id==0)
							{
								echo "";
							}
							elseif($item_id=="")
							{
								echo "";
							}
							else
							{
							foreach((array)$stockInfo as $rowInfo){ ?>
							<div class="col-7">               
								<table class="table table-bordered table-hover table-light">
									<tr class="table-info">
										<td>Item No</td>
										<td>Item Name</td>
										<td>Product No</td>
										<td>Total</td>
										<td>(Ref.) In Transit</td>
									</tr>
									<tr>
										<td><?php echo $item_id;?></td>
										<td><?php echo $rowInfo['item_name']; ?></td>
										<td><?php echo $rowInfo['product_number']; ?></td>
										<td class="text-right"><?php echo number_format($rowInfo['sum(sum_qty)'],0); ?></td>
										<td class="text-right">(<?php $system_app->getNotReceivedQty($item_id); ?>)</td>                     
									</tr>                   
								</table>
							</div>
							<div class="col-5 border border-info">
								<span class="h5 text-decoration-underline"><u>Item Information</u></span><br>
								<span>Category : <?php echo $rowInfo['category_name']; ?></span><br>
								<span>Purchase Price : <?php echo number_format($rowInfo['purchase_price'],2); ?></span><br>
								<span>Sales Price : <?php echo number_format($rowInfo['sales_price'],2); ?></span><br>
								<span>Order Point(qty) : <?php echo $rowInfo['min_qty']." - ".$rowInfo['max_qty']; ?></span><br>
							</div>
						<?php }}?>					
					</div>
					<table class="table table-hover table-light" id="scrolltable-stock-details">
						<thead class="table-dark">
							<tr>
								<th>#</th>
								<th>Date</th>
								<th>Details</th>
								<th>In</th>
								<th>Out</th>
								<th>Total</th>                   
							</tr>
						</thead>
						<tbody>
							<?php  if($item_id==0){ ?>
								<tr>
									<td class="text-center bg-light"colspan=6>Please search for Item Id or Item Name.</td>
								</tr>
							<?php }elseif($item_id==""){ ?>						
								<tr>
									<td class="text-center bg-light"colspan=6>Please search for Item Id or Item Name.</td>
								</tr>
							<?php }else{foreach((array)$stockDetails as $row){ ?>
								<tr>
									<td><?php echo $row['stock_id']; ?></td>
									<td><?php echo $row['date']; ?></td>
									<td><?php echo $row['details']; ?></td>
									<td class="text-right"><?php echo number_format($row['in_qty'],0); ?></td>
									<td class="text-right"><?php echo number_format($row['out_qty'],0); ?></td>
									<td class="text-right"><?php echo number_format($row['total'],0); ?></td>
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