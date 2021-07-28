<?php
	include 'datafile.php';
	$categoryList = $system_app->getCategoryList();
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Categories</title>
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
					$categories_active = "active";
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
                  <a href="categories.php" class="text-decoration-none text-muted h4 text-center"><i class="far fa-folder-open"></i> Categories</a>
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
							<a href="" class="btn btn-muted float-end" data-toggle="modal" data-target="#addCategory"><i class="fas fa-plus-circle"></i> Add Category</a>
						</div>        
					</div>
					<table class="table table-hover table-light">
						<thead class="table-dark">
							<tr>
								<th>Category ID</th>
								<th>Category Name</th>
								<th>Memo</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach((array)$categoryList as $row)
								{ 
								if($row["category_id"]==""){?>												
								<tr>
									<td class="text-center bg-light"colspan=5>No data.</td>
								</tr>
								<?php }else{?>
								<tr>
									<td><?php echo $row['category_id']; ?></td>
									<td><?php echo $row['category_name']; ?></td>
									<td><?php echo $row['memo']; ?></td>
									<td><a href="" class="btn btn-warning text-light float-end" data-toggle="modal" data-target="#editCategory<?php echo $row['category_id'];?>">Update</a>
									</td>
									<td><a href="" class="btn btn-danger text-light float-end" data-toggle="modal" data-target="#deleteCategory<?php echo $row['category_id'];?>">Delete</a>
									</td>
								</tr>
							<?php }}?>               
						</tbody>       
					</table>
    		</div>
			</div>
		</div>

		<!-- Modal -->
		<?php foreach((array)$categoryList as $row)
		{ ?>
		<!-- Modal Add Category -->
		<div class="modal fade" id="addCategory" tabindex='-1' aria-labelledby="addCategoryLabel" aria-hidden="true">
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>
						<h5 class='modal-title'><i class="fas fa-plus-circle"></i> Add Category</h5>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
								<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="datafile.php" method="post">                                  
						<div class='modal-body'>                               
							<label for="categoryName" class="form-label">Category Name</label>
							<input type="text" name="categoryName" id="categoryName" class="form-control"></input>
							<label for="categoryMemo" class="form-label">Memo</label>
							<input type="text" name="categoryMemo" id="categoryMemo" class="form-control"></input>                                  
						</div>
						<div class="modal-footer">
							<input type="submit" name="addCategory" class="btn btn-primary" value="Add"></input>
							<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
						</div>  
					</form>                                     
				</div>
			</div>
		</div>

		<!-- Modal Edit Category -->
		<div class="modal fade" id="editCategory<?php echo $row['category_id'];?>" tabindex="-1" aria-labelledby="editCategory<?php echo $row['category_id'];?>Label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class='modal-title'><i class="fas fa-edit"></i> Edit Category</h5>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="datafile.php" method="post">
						<div class='modal-body'>
							<input type="hidden" name="categoryId" id="categoryId" class="form-control" value="<?php echo $row["category_id"]; ?>"></input>

							<label for="categoryName" class="form-label">Category Name</label>
							<input type="text" name="categoryName" id="categoryName" class="form-control" value="<?php echo $row['category_name'];?>"></input>
							
							<label for="categoryMemo" class="form-label">Memo</label>
							<input type="text" name="categoryMemo" id="categoryMemo" class="form-control" value="<?php echo $row['memo'];?>"></input>
						</div>
						<div class="modal-footer">
							<input type="submit" name="editCategory" class="btn btn-primary" value="Edit"></input>
							<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
						</div>  
					</form>
				</div>
			</div>
		</div>

		<!-- Modal Delete Category -->
		<div class="modal fade" id="deleteCategory<?php echo $row['category_id'];?>" tabindex="-1" aria-labelledby="deleteCategory<?php echo $row['category_id'];?>Label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class='modal-title'><i class="fas fa-trash-alt"></i> Delete Category</h5>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden="true">&times;</span>
						</button>
					</div> 
					<form action="datafile.php" method="post">   
						<div class='modal-body'>
							<input type="hidden" name="categoryId" id="categoryId" class="form-control" value="<?php echo $row["category_id"]; ?>"></input>
							<p class="text-center">Are you sure you want to delete "<span class="text-danger font-weight-bold"><?php echo $row['category_id'].". ".$row['category_name']; ?></span>" from category list?</p>
						</div>    
						<div class="modal-footer">																
							<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>   
							<input type="submit" name="deleteCategory" class="btn btn-primary" value="Continue"></input>
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