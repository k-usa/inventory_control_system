<?php
	include 'datafile.php';
  
  $login_id = $_GET["id"];
  $userDetails = $system_app->getUserDetails($login_id);
  
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Profile</title>
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
                  <a href="profile.php?id=<?php echo $userDetails["login_id"]; ?>" class="text-decoration-none text-muted h4 text-center"><i class="far fa-address-card"></i> Profile</a>
                </span>
              </div>             
            </div>
            <button type="button" class="navbar-toggler" data-target="#menu" data-toggle="collapse">
              <span class="navbar-toggler-icon"></span>
            </button>    
            <div class="collapse navbar-collapse" id="menu">
              <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
										<a href="profile.php?id=<?php echo $_SESSION['login_id'];?>" class="nav-link active"><i class="fas fa-user"></i> <?php echo $_SESSION['firstname']." ".$_SESSION['lastname'];?></a>
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
          <div class="row">
            <div class="col-4 mx-md-0">
              <div class="card mt-3" id=profile>
                <div class="card card-header p-0">
                </div>
                <div class="card card-body">
                  <h1 class="card-title fs-3"><?php echo $userDetails["first_name"]." ".$userDetails["last_name"]; ?></h1>
                  <p class="card-subtitle fst-italic text-muted mb-4">@ <?php echo $userDetails["username"]; ?></p>
                </div>
              </div>
            </div>
            <div class="col-8 mx-md-0">
              <form action="#" method="post" id=updateAccountForm>
                <div class="row mt-3">
                  <div class="col-md">
                    <input type="hidden" class="form-control" name="loginId" id="loginId" value="<?php echo $userDetails["login_id"]; ?>">          
                  </div>                    
                </div>
                <div class="row mt-3">
                  <div class="col-md">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="fname" id="fname" value="<?php echo $userDetails["first_name"]; ?>">          
                  </div>
                  <div class="col-md">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lname" id="lname" value="<?php echo $userDetails["last_name"]; ?>">
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md">
                    <label for="dep" class="form-label">Department</label>
                    <input type="text" class="form-control" name="dep" id="dep" value="<?php echo $userDetails["department"]; ?>">          
                  </div>                    
                </div>
                <?php
                  if($_SESSION["status"] == "A")
                  {
                ?>
                <div class="row mt-3">
                  <div class="col-md">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                      <?php
                        if($userDetails["status"] == "A")
                        { 
                          echo "<option selected value='A'>Admin</option>
                          <option value='U'>User</option>";
                        }
                        else
                        {
                          echo "<option selected value='U'>User</option>
                          <option value='A'>Admin</option>";
                        }
                      ?>
                    </select>
                  </div>                    
                </div>
                <?php }else{?>
                  <input type="hidden" class="form-control" name="status" id="status" value="<?php echo $userDetails["status"]; ?>">   
                <?php }?>
                <div class="row mt-3">
                  <div class="col-md">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" value="<?php echo $userDetails["username"]; ?>">
                  </div>
                </div>
                  <div class="row mt-3">
                    <div class="col-md">
                    <button type="button" data-toggle="modal" data-target="#updateAccount" class="btn btn-primary text-light w-100 mt-3">Update</button>
                    </div>
                  </div>
              </form>     
              <div class="mt-3">    
                <span class="float-start">
                  <div class="row">
                    <a href='#' class='text-muted fst-italic text-decoration-none fs-6 btn' data-toggle='modal' data-target="#changePassword"><i class='fas fa-lock text-muted'></i> Change Password</a>
                  </div>
                </span>
              </div>                  
            </div>
          </div>
				</div>
			</div>
		</div>

		<!-- Modal -->
	
		<!-- Modal Update Account-->
    <div class="modal fade" id="updateAccount" tabindex='-1' aria-labelledby="updateAccountLabel" aria-hidden="true">     
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Update Account</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="datafile.php" method="post" id=updateAccountForm> 
            <div class="modal-body">
              <p class="">Enter Password to proceed with the update.</p>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" form="updateAccountForm">
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-primary" name="updateAccount" value="Update" form="updateAccountForm">
              <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
		
    <!-- Modal Change Password -->
    <div class="modal fade" id="changePassword" tabindex='-1' aria-labelledby="changePasswordLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-lock text-muted"></i> Change Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="datafile.php" method="post">
              <div class="modal-body">
                <div class="form-group">
                  <input type="hidden" class="form-control" name="loginId" id="loginId" value="<?php echo $userDetails["login_id"]; ?>">          
                </div>   
                <div class="form-group">
                  <label for="currentPassword" class="form-label">Current Password</label>
                  <input type="password" name="currentPassword" id="currentPassword" class="form-control"></input>
                </div>
                <div class="form-group">
                  <label for="newPassword" class="form-label">New Password</label>
                  <input type="password" name="newPassword" id="newPassword" class="form-control"></input>
                </div>
                <div class="form-group">
                  <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                  <input type="password" name="confirmNewPassword" id="confirmNewPassword" class="form-control"></input>
                </div>
              </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-primary" name="updatePassword" value="Update">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
              </div>
          </form>
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