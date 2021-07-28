<?php
	include 'Config.php';

	class System_app extends Config
	{
		public function signup($fname,$lname,$dep,$username,$password)
		{
			$hash_password = password_hash($password,PASSWORD_DEFAULT);
			$sql = "INSERT INTO login(username,password) VALUES('$username','$hash_password')";
			$result = $this->conn->query($sql);

			if($result == TRUE)
			{
				$login_id = $this->conn->insert_id;
				$sql = "INSERT INTO users(first_name,last_name,department,login_id) VALUES('$fname','$lname','$dep',$login_id)";
				$result = $this->conn->query($sql);

				if($result == TRUE)
				{
					header('location:login.php');
				}
				else
				{
					header("location:register.php?success=0&message=An error ocured.");
				}
			}
			else
			{
				header("location:register.php?success=0&message=An error ocured.");
			}
		}
			
			
		public function login($username,$password)
		{
			$sql = "SELECT * FROM login INNER JOIN users on login.login_id = users.login_id WHERE username='$username'";
			$result = $this->conn->query($sql);

			if($result->num_rows == 1)
			{
				$row = $result->fetch_assoc();            

				if(password_verify($password,$row['password']))
				{
					$_SESSION['user_id'] = $row['user_id'];
					$_SESSION['firstname'] = $row['first_name'];
					$_SESSION['lastname'] = $row['last_name'];
					$_SESSION['department'] = $row['department'];
					$_SESSION['username'] = $row['username'];
					$_SESSION['status'] = $row['status'];
					$_SESSION['login_id'] = $row['login_id'];

					if($_SESSION['status'] == "A")
					{
						header("location:dashboard.php");    
					}
					else
					{
						header("location:dashboard.php"); 
					}
				}
				else
				{
					header("location:login.php?success=0&message=Password is incorrect.");
				}
			}
			else
			{
				header("location:login.php?success=0&message=The username is incorrect.");
			}
		}

		public function addUser($fname,$lname,$dep,$username,$password,$status)
		{
			$hash_password = password_hash($password,PASSWORD_DEFAULT);
			$sql = "INSERT INTO login(username,password,status) VALUES('$username','$hash_password','$status')";
			$result = $this->conn->query($sql);

			if($result == TRUE)
			{
				$login_id = $this->conn->insert_id;
				$sql = "INSERT INTO users(first_name,last_name,department,login_id) VALUES('$fname','$lname','$dep',$login_id)";
				$result = $this->conn->query($sql);

				if($result == TRUE)
				{
					header("location:users.php?success=1&message=The account is successfully added.");
				}
				else
				{
					header("location:users.php?success=0&message=An error ocured.");
				}
			}
			else
			{
				header("location:users.php?success=0&message=An error ocured.");
			}
		}


		public function updateUsers($login_id,$fname,$lname,$dep,$username,$password,$status)
		{
			$sql = "SELECT * FROM login WHERE login_id=$login_id";
			$result = $this->conn->query($sql);

			if($result->num_rows == 1)
			{
				$loginUser = $_SESSION['login_id'];
				$sql = "SELECT * FROM login WHERE login_id=$loginUser";
				$result = $this->conn->query($sql);

				if($result->num_rows == 1)
				{
					$row = $result->fetch_assoc();

					if(password_verify($password,$row['password']))
					{
						$this->updateLogin($login_id,$username,$status);
																				
						$sql = "UPDATE users SET first_name='$fname',last_name='$lname',department='$dep' WHERE login_id=$login_id";
						$result = $this->conn->query($sql);

						// Update session
						// $_SESSION['firstname'] = $fname;
						// $_SESSION['lastname'] = $lname;
						// $_SESSION['department'] = $dep;
						// $_SESSION['username'] = $username;
						// $_SESSION['login_id'] = $login_id;

						if($result)
						{
							header("location:profile.php?id=".$login_id."&success=1&message=The account is successfully updated.");
						}
						else
						{
							header("location:profile.php?id=".$login_id."&success=0&message=An error ocured.");
						}						
	
					}
					else
					{
						header("location:profile.php?id=".$login_id."&success=0&message=Update unsuccessful. Incorrect password. Kindly try again.");
					}
				}
				else
				{
					header("location:profile.php?id=".$login_id."&success=0&message=An error ocured.");
				}
			}		
		}


		public function updateLogin($login_id,$username,$status)
		{
			$sql = "UPDATE login SET username='$username',status='$status' WHERE login_id=$login_id";
			$result = $this->conn->query($sql);

			if($result)
			{
				header("location:profile.php?id=".$login_id."&success=1&message=The account is successfully updated.");
			}
			else
			{
				header("location:profile.php?id=".$login_id."&success=0&message=New username is used.");
				die();
			}
		}


		public function changePassword($login_id,$currentPassword,$newPassword,$confirmNewPassword)
		{
			$sql = "SELECT * FROM login WHERE login_id=$login_id";
			$result = $this->conn->query($sql);

			if($result->num_rows == 1)
			{
				$row = $result->fetch_assoc();

				if(password_verify($currentPassword,$row['password']))
				{
					if($newPassword == $confirmNewPassword)
					{
						$hash_password = password_hash($newPassword,PASSWORD_DEFAULT);
						$sql = "UPDATE login SET password='$hash_password' WHERE login_id=$login_id";
						$result = $this->conn->query($sql);

						if($result)
						{
							header("location:profile.php?id=".$login_id."&success=1&message=Password is successfully updated.");
						}
						else
						{
							header("location:profile.php?id=".$login_id."&success=0&message=Update unsuccessful. Incorrect password. Kindly try again.");
						}
					}
					else
					{
						header("location:profile.php?id=".$login_id."&success=0&message=The new password doesn't match.");
					}
				}
				else
				{
					header("location:profile.php?id=".$login_id."&success=0&message=Current password is incorrect.");					
				}
			}
			else
			{
				header("location:profile.php?id=".$login_id."&success=0&message=An error ocured.");
			}
		}


		public function getUser()
		{
			$sql = "SELECT * FROM login INNER JOIN users on login.login_id = users.login_id";
			$result = $this->conn->query($sql);

			if($result->num_rows>0)
			{
				$arr = array();
				while($row = $result->fetch_assoc())
				{
						$arr[] = $row;
				}
				return $arr;
			}
			else
			{
				return FALSE;
			}
		}

		
		public function getUserDetails($login_id)
		{
			$sql = "SELECT * FROM login INNER JOIN users on login.login_id = users.login_id WHERE users.login_id='$login_id'";
			$result = $this->conn->query($sql);

			if($result->num_rows==1)
			{
				return $result->fetch_assoc();
			}
			else
			{
				return FALSE;
			}
		}


		public function navbar($dashboard_active,$stocks_drop_active,$stocks_active,$stockDetails_active,$orders_drop_active,$orders_active,$orderDetails_active,$master_drop_active,$categories_active,$items_active,$users_active)
		{

			if($_SESSION['status'] == "A")
			{
				echo "<nav id='sidebar'>
				<div class='sidebar-header'>
					<h3><a href='#' class=''><i class='fas fa-dolly-flatbed'></i> Inventory</a></h3>
				</div>

				<ul class='list-unstyled components'>           
					<li class=''>
						<a href='dashboard.php' class='".$dashboard_active."'><i class='far fa-clipboard'></i> Home</a>
					</li>
					<li class=''>
						<a href='#stockSubmenu' data-toggle='collapse' aria-expanded='true' class='dropdown-toggle ".$stocks_drop_active."'><i class='fas fa-boxes'></i></i> Stock</a>
						<ul class='collapse list-unstyled' id='stockSubmenu'>
							<li>
								<a href='stocks.php' class='".$stocks_active."'><i class='fas fa-cart-arrow-down'></i> All Stocks</a>
							</li>
							<li>
								<a href='stock-details.php' class='".$stockDetails_active."'><i class='fas fa-shipping-fast'></i> Stock Details</a>
							</li>
						</ul>
					</li>
					
					<li>
						<a href='#orderSubmenu' data-toggle='collapse' aria-expanded='true' class='dropdown-toggle ".$orders_drop_active."'><i class='fas fa-shopping-cart'></i> Order</a>
							<ul class='collapse list-unstyled' id='orderSubmenu'>
								<li>
									<a href='orders.php' class='".$orders_active."'><i class='fas fa-cart-arrow-down'></i> Order</a>
								</li>
								<li>
									<a href='order-details.php' class='".$orderDetails_active."'><i class='fas fa-shipping-fast'></i> Order Details</a>
								</li>
							</ul>
					</li>
					<li>
						<a href='#masterSubmenu' data-toggle='collapse' aria-expanded='true' class='dropdown-toggle ".$master_drop_active."'><i class='fas fa-key'></i> Master</a>
							<ul class='collapse list-unstyled' id='masterSubmenu'>
								<li>
									<a href='categories.php' class='".$categories_active."'><i class='far fa-folder-open'></i> Categories</a>
								</li>
								<li>
									<a href='items.php' class='".$items_active."'><i class='fas fa-pencil-alt'></i> Items</a>
								</li>
								<li>
									<a href='users.php' class='".$users_active."'><i class='fas fa-users'></i> Users</a>
								</li>
							</ul>
					</li>         
				</ul>
			</nav>";
			}
			else
			{
				echo "<nav id='sidebar'>
				<div class='sidebar-header'>
					<h3><a href='#'><i class='fas fa-dolly-flatbed'></i> Inventory</a></h3>
				</div>

				<ul class='list-unstyled components'>           
					<li>
						<a href='dashboard.php' class='".$dashboard_active."'><i class='far fa-clipboard'></i> Home</a>
					</li>
					<li>
					<a href='#stockSubmenu' data-toggle='collapse' aria-expanded='true' class='dropdown-toggle ".$stocks_drop_active."'><i class='fas fa-boxes'></i></i> Stock</a>
					<ul class='collapse list-unstyled' id='stockSubmenu'>
						<li>
							<a href='stocks.php' class='".$stocks_active."'><i class='fas fa-cart-arrow-down'></i> All Stocks</a>
						</li>
						<li>
							<a href='stock-details.php' class='".$stockDetails_active."'><i class='fas fa-shipping-fast'></i> Stock Details</a>
						</li>
					</ul>
					</li>
					
					<li>
						<a href='#orderSubmenu' data-toggle='collapse' aria-expanded='true' class='dropdown-toggle ".$master_drop_active."'><i class='fas fa-shopping-cart'></i> Order</a>
							<ul class='collapse list-unstyled' id='orderSubmenu'>
								<li>
									<a href='orders.php' class='".$orders_active."'><i class='fas fa-cart-arrow-down'></i> Order</a>
								</li>
								<li>
									<a href='order-details.php' class='".$orderDetails_active."'><i class='fas fa-shipping-fast'></i> Order Details</a>
								</li>
							</ul>
					</li>
				</ul>
			</nav>";
			}
		}


		public function addCategory($categoryName,$categoryMemo)
		{
			$sql = "INSERT INTO categories(category_name,memo) VALUES('$categoryName','$categoryMemo')";
			$result = $this->conn->query($sql);

			if($result == TRUE)
			{
				header("location:categories.php?success=1&message=The category is successfully added.");
			}
			else
			{
				header("location:categories.php?success=0&message=An error ocured.");
			}
		}


		public function editCategory($categoryId,$categoryName,$categoryMemo)
		{
			$sql = "UPDATE categories SET category_name='$categoryName',memo='$categoryMemo' WHERE category_id=$categoryId";
			$result = $this->conn->query($sql);

			if($result == TRUE)
			{
				header("location:categories.php?success=1&message=The category is successfully updated.");
			}
			else
			{
				header("location:categories.php?success=0&message=An error ocured.");
			}
		}


		public function deleteCategory($categoryId)
		{
			$sql = "SELECT categories.category_id,categories.category_name,categories.memo,items.item_id,items.category_id FROM categories INNER JOIN items ON categories.category_id=items.category_id WHERE categories.category_id=$categoryId";
			$result = $this->conn->query($sql);

			if($result->num_rows==0)
			{
				$sql = "DELETE FROM categories WHERE category_id=$categoryId";
				$result = $this->conn->query($sql);

				if($result == TRUE)
				{
					header("location:categories.php?success=1&message=The category has been deleted successfully.");
				}
				else
				{
					header("location:categories.php?success=0&message=An error ocured.");
				}
			}
			else
			{
				header("Location:categories.php?success=0&message=This category cannot be deleted.");
			}
		}


		public function getCategoryList()
		{
			$sql = "SELECT * FROM categories";
			$result = $this->conn->query($sql);

			if($result->num_rows>0)
			{
				$arr = array();
				while($row = $result->fetch_assoc())
				{
						$arr[] = $row;
				}
				return $arr;
			}
			else
			{
				return FALSE;
			}
		}

		public function displayCategoriesAsOptions()
		{
			$sql = "SELECT * FROM categories";
			$result = $this->conn->query($sql);

			if($result->num_rows>0)
			{
				echo "<option selected disabled>Select Category</option>";

				while($row = $result->fetch_assoc())
				{
					echo "<option value=".$row["category_id"].">".$row["category_name"]."</option>";
				}
			}
			else
			{
				echo "<option>No categories</option>";
			}
		}

		public function displaySelectedCategoriesAsOptions($categoryId)
		{
			$sql = "SELECT * FROM categories";
			$result = $this->conn->query($sql);

			if($result->num_rows>0)
			{
				echo "<option disabled>Select Category</option>";

				while($row = $result->fetch_assoc())
				{
					if($row['category_id'] == $categoryId)
					{
						echo "<option selected value=".$row["category_id"].">".$row["category_name"]."</option>";
					}
					else
					{
						echo "<option value=".$row["category_id"].">".$row["category_name"]."</option>";
					}                   
				}
			}
			else
			{
				echo "<option>No categories</option>";
			}
		}


		public function addItem($categoryName,$itemName,$productNo,$purchasePrice,$salesPrice,$minQty,$maxQty)
		{
			$sql = "INSERT INTO items(category_id,item_name,product_number,purchase_price,sales_price,min_qty,max_qty) VALUES('$categoryName','$itemName','$productNo',$purchasePrice,$salesPrice,$minQty,$maxQty)";
			$result = $this->conn->query($sql);
			echo $sql;

			if($result == TRUE)
			{
				header("location:items.php?success=1&message=The item is successfully added.");
			}
			else
			{
				header("location:items.php?success=0&message=An error ocured.");
			}
		}


		public function editItem($itemId,$categoryName,$itemName,$productNo,$purchasePrice,$salesPrice,$minQty,$maxQty)
		{
			$sql = "UPDATE items SET category_id='$categoryName',item_name='$itemName', product_number='$productNo',purchase_price=$purchasePrice, sales_price=$salesPrice, min_qty=$minQty,max_qty=$maxQty WHERE item_id=$itemId";
			$result = $this->conn->query($sql);

			if($result == TRUE)
			{
				header("location:items.php?success=1&message=The item is successfully updated.");
			}
			else
			{
				header("location:items.php?success=0&message=An error ocured2.");
			}
		}


		public function deleteItem($itemId)
		{
			$sql = "SELECT items.item_id,items.category_id,items.item_name,items.product_number,items.purchase_price,items.sales_price,items.min_qty,items.max_qty,stocks.stock_id,stocks.item_id FROM items INNER JOIN stocks ON items.item_id=stocks.item_id WHERE items.item_id=$itemId";
			$result = $this->conn->query($sql);

			if($result->num_rows==0)
			{
				$sql = "DELETE FROM items WHERE item_id=$itemId";
				$result = $this->conn->query($sql);

				if($result == TRUE)
				{
					header("location:items.php?success=1&message=The item has been deleted successfully.");
				}
				else
				{
					header("location:items.php?success=0&message=An error ocured.");
				}
			}
			else
			{
				header("Location:items.php?success=0&message=This item cannot be deleted.");
			}
		}


		public function getItemList()
		{
			$sql = "SELECT items.item_id,items.category_id,items.item_name,items.product_number,items.purchase_price,items.sales_price,items.min_qty,items.max_qty,categories.category_id,categories.category_name,categories.memo FROM items INNER JOIN categories ON items.category_id=categories.category_id ORDER BY items.item_id";
			$result = $this->conn->query($sql);

			if($result->num_rows>0)
			{
				$arr = array();
				while($row = $result->fetch_assoc())
				{
						$arr[] = $row;
				}
				return $arr;
			}
			else
			{
				return FALSE;
			}
		}


		public function displayItemsAsOptions()
		{
			$sql = "SELECT * FROM items";
			$result = $this->conn->query($sql);

			if($result->num_rows>0)
			{
				echo "<option selected disabled>Select Item</option>";

				while($row = $result->fetch_assoc())
				{
					echo "<option value=".$row["item_id"].">".$row["item_id"].". ".$row["item_name"]." (".$row["product_number"].")</option>";
				}
			}
			else
			{
				echo "<option>No Item</option>";
			}
		}


		public function displaySelectedItemsAsOptions($item_id)
		{
			$sql = "SELECT * FROM items WHERE item_id=$item_id";
			$result = $this->conn->query($sql);

			if($result->num_rows>0)
			{
				echo "<option disabled>Select Item</option>";

				while($row = $result->fetch_assoc())
				{
					if($item_id == $row["item_id"])
					{
						echo "<option selected value=".$row["item_id"].">".$row["item_id"].". ".$row["item_name"]." (".$row["product_number"].")</option>";
					}
					else
					{
						echo "<option value=".$row["item_id"].">".$row["item_id"].". ".$row["item_name"]." (".$row["product_number"].")</option>";
					}                   
				}
			}
			else
			{
				echo "<option>No categories</option>";
			}
		}


		public function adjustStock($item_id,$details,$orderNo,$inQty,$outQty,$sumQty)
		{   
			if($orderNo!="")
			{
				if($orderNo == "-")
				{
					$sql = "INSERT INTO stocks(item_id,details,order_number,in_qty,out_qty,sum_qty) VALUES($item_id,'$details','$orderNo',$inQty,$outQty,$sumQty)";

					$result = $this->conn->query($sql);
					
					if($result)
					{
						header("location:stocks.php?success=1&message=The stock is successfully adjusted.");
					}
					else
					{
						header("location:stocks.php?success=0&message=An error ocured.(cannot add stocks1)");
					}					
				}
				else
				{
					$sql = "SELECT * FROM orders WHERE order_id=$orderNo";
					$result = $this->conn->query($sql);

					if($result->num_rows==1)
					{
						while($row = $result->fetch_assoc())
						{
							if($row['not_received_qty']>=$inQty)
							{
								$sql = "INSERT INTO stocks(item_id,details,order_number,in_qty,out_qty,sum_qty) VALUES($item_id,'$details','$orderNo',$inQty,$outQty,$sumQty)";

								$result = $this->conn->query($sql);
									
								if($result)
								{
									$newInQty = $row['in_qty'] + $inQty;
									$sql = "UPDATE orders SET in_qty=$newInQty WHERE order_id=$orderNo";
									$result = $this->conn->query($sql);

									if($result)
									{
										$sql = "SELECT * FROM orders WHERE order_id=$orderNo";
										$result = $this->conn->query($sql);

										if($result->num_rows==1)
										{
											while($row = $result->fetch_assoc())
											{
												$notReceived = $row['order_qty'] - $row['in_qty'];
												$sql = "UPDATE orders SET not_received_qty=$notReceived WHERE order_id=$orderNo";
												$result = $this->conn->query($sql);

												if($result)
												{
													$sql = "SELECT * FROM orders WHERE order_id=$orderNo";
													$result = $this->conn->query($sql);

													if($result->num_rows==1)
													{
														while($row = $result->fetch_assoc())
														{
															if($row['not_received_qty'] == 0)
															{
																$sql = "UPDATE orders SET status='Received' WHERE order_id=$orderNo";
																$result = $this->conn->query($sql);

																if($result)
																{
																	header("location:stocks.php?success=1&message=The stock is successfully adjusted.");  
																}
																else
																{
																	header("location:stocks.php?success=0&message=An error ocured.(cannot change status of order)");
																}
															}
															else
															{
																header("location:stocks.php?success=1&message=The stock is successfully adjusted."); 
															}                                      
														}
													}
													else
													{
														header("location:stocks.php?success=0&message=An error ocured.(No order)");
													}
												}
												else
												{
													header("location:stocks.php?success=0&message=An error ocured.(cannot update received qty)");
												}
											}
										}
										else
										{
											header("location:stocks.php?success=0&message=An error ocured.(No order)");
										}
									}
									else
									{
										header("location:stocks.php?success=0&message=An error ocured.(cannot update received qty)");
									}
								}
								else
								{
									header("location:stocks.php?success=1&message=The stock is successfully adjusted.");
								}
							}
							else
							{
								header("location:stocks.php?success=0&message=The qty of receiving is exceeded.");
							}
						}
					}
					else
					{
						header("location:stocks.php?success=0&message=Not Applicable.");
					}
				}			
			}
			else
			{
				header("location:stocks.php?success=0&message=An error ocured.(cannot add stocks2)");
			}
		}


		public function getStock()
		{
			$sql = "SELECT items.item_id,items.category_id,items.item_name,items.product_number,items.purchase_price,items.sales_price,items.min_qty,items.max_qty,categories.category_id,categories.category_name,categories.memo,stocks.stock_id,stocks.item_id,stocks.details,stocks.in_qty,stocks.out_qty,stocks.sum_qty,stocks.order_number,stocks.date,sum(sum_qty) FROM items INNER JOIN categories ON items.category_id=categories.category_id INNER JOIN stocks ON items.item_id=stocks.item_id GROUP BY stocks.item_id";
			$result = $this->conn->query($sql);

			if($result->num_rows>0)
			{
				$arr = array();
				while($row = $result->fetch_assoc())
				{
						$arr[] = $row;
				}
				return $arr;
			}
			else
			{
				return FALSE;
			}
		}
	
		// DELETE ??
		public function getStock_BU()
		{
			$sql = "SELECT * FROM orders";
			$result = $this->conn->query($sql);

			if($result->num_rows>0)
			{
				$sql = "SELECT orders.item_id,stocks.item_id FROM orders INNER JOIN stocks ON orders.item_id=stocks.item_id GROUP BY orders.item_id";
				$result = $this->conn->query($sql);

				if($result->num_rows>0)
				{

					$sql = "SELECT items.item_id,items.category_id,items.item_name,items.product_number,items.purchase_price,items.sales_price,items.min_qty,items.max_qty,categories.category_id,categories.category_name,categories.memo,stocks.stock_id,stocks.item_id,stocks.details,stocks.in_qty,stocks.out_qty,stocks.sum_qty,stocks.order_number,stocks.date,orders.order_id,orders.item_id,orders.not_received_qty,sum(sum_qty),sum(orders.not_received_qty) FROM items INNER JOIN categories ON items.category_id=categories.category_id INNER JOIN stocks ON items.item_id=stocks.item_id INNER JOIN orders ON stocks.item_id=orders.item_id GROUP BY stocks.item_id";
					$result = $this->conn->query($sql);

					if($result->num_rows>0)
					{
						$arr = array();
						while($row = $result->fetch_assoc())
						{
								$arr[] = $row;
						}
						return $arr;
					}
					else
					{
						return FALSE;
					}
				}
				else
				{
					$sql = "SELECT items.item_id,items.category_id,items.item_name,items.product_number,items.purchase_price,items.sales_price,items.min_qty,items.max_qty,categories.category_id,categories.category_name,categories.memo,stocks.stock_id,stocks.item_id,stocks.details,stocks.in_qty,stocks.out_qty,stocks.sum_qty,stocks.order_number,stocks.date,sum(sum_qty) FROM items INNER JOIN categories ON items.category_id=categories.category_id INNER JOIN stocks ON items.item_id=stocks.item_id GROUP BY stocks.item_id";
					$result = $this->conn->query($sql);

					if($result->num_rows>0)
					{
						$arr = array();
						while($row = $result->fetch_assoc())
						{
								$arr[] = $row;
						}
						return $arr;
					}
					else
					{
						return FALSE;
					}
				}
			}
		}

		public function getStockInfo($item_id)
		{
			$sql = "SELECT items.item_id,items.category_id,items.item_name,items.product_number,items.purchase_price,items.sales_price,items.min_qty,items.max_qty,categories.category_id,categories.category_name,categories.memo,stocks.stock_id,stocks.item_id,stocks.details,stocks.in_qty,stocks.out_qty,stocks.sum_qty,stocks.order_number,stocks.date,sum(sum_qty)FROM items INNER JOIN categories ON items.category_id=categories.category_id INNER JOIN stocks ON items.item_id=stocks.item_id WHERE stocks.item_id=$item_id GROUP BY stocks.item_id";
			$result = $this->conn->query($sql);
			
			if($result==FALSE)
			{
				echo "";
			}
			elseif($result->num_rows==1)
			{
				$arr = array();
				while($row = $result->fetch_assoc())
				{
					$arr[] = $row;
				}
				return $arr;
			}
			else
			{
				return FALSE;
			}
		}

	
		public function getStockDetails($item_id)
		{
			$sql = "SELECT items.item_id,items.category_id,items.item_name,items.product_number,items.purchase_price,items.sales_price,items.min_qty,items.max_qty,categories.category_id,categories.category_name,categories.memo,stocks.stock_id,stocks.item_id,stocks.details,stocks.in_qty,stocks.out_qty,stocks.sum_qty,stocks.order_number,stocks.date,SUM(stocks.sum_qty) OVER (PARTITION BY stocks.item_id ORDER BY stocks.item_id,stocks.stock_id ROWS UNBOUNDED PRECEDING) AS total FROM items INNER JOIN categories ON items.category_id=categories.category_id INNER JOIN stocks ON items.item_id=stocks.item_id WHERE stocks.item_id=$item_id";
			$result = $this->conn->query($sql);

			if($result==FALSE)
			{
				echo "";
			}
			elseif($result->num_rows>0)
			{
				$arr = array();
				while($row = $result->fetch_assoc())
				{
					$arr[] = $row;
				}
				return $arr;
			}
			else
			{
				return FALSE;
			}
		}

		// DELETE ??
		public function getStockDetails_BU($item_id)
		{
			$sql = "SELECT items.item_id,items.category_id,items.item_name,items.product_number,items.purchase_price,items.sales_price,items.min_qty,items.max_qty,categories.category_id,categories.category_name,categories.memo,stocks.stock_id,stocks.item_id,stocks.details,stocks.in_qty,stocks.out_qty,stocks.sum_qty,stocks.order_number,stocks.date,orders.order_id,orders.item_id,orders.not_received_qty,SUM(stocks.sum_qty) OVER (PARTITION BY stocks.item_id ORDER BY stocks.item_id,stocks.stock_id ROWS UNBOUNDED PRECEDING) AS total FROM items INNER JOIN categories ON items.category_id=categories.category_id INNER JOIN stocks ON items.item_id=stocks.item_id INNER JOIN orders ON stocks.item_id=orders.item_id WHERE stocks.item_id=$item_id";
			$result = $this->conn->query($sql);

			if($result==FALSE)
			{
				echo "";
			}
			elseif($result->num_rows>0)
			{
				$arr = array();
				while($row = $result->fetch_assoc())
				{
					$arr[] = $row;
				}
				return $arr;
			}
			else
			{
				return FALSE;
			}
		}


		public function totalAmountOfStock()
		{
			$sql="SELECT stocks.item_id,stocks.sum_qty,items.item_id,items.purchase_price,stocks.sum_qty*items.purchase_price as stock_amount,sum(stocks.sum_qty*items.purchase_price) as total_amount FROM stocks INNER JOIN items ON stocks.item_id=items.item_id";
			$result = $this->conn->query($sql);

			if($result->num_rows==1)
			{
				return $result->fetch_assoc();
			}
			else
			{
				return FALSE;
			}
		}


		public function alertOrderPoint($item_id)
		{
			$sql = "SELECT items.item_id,items.min_qty,items.max_qty,stocks.item_id,stocks.sum_qty,sum(sum_qty)FROM items INNER JOIN stocks ON items.item_id=stocks.item_id WHERE stocks.item_id=$item_id GROUP BY stocks.item_id";
			$result = $this->conn->query($sql);

			if($result->num_rows==1)
			{
				$row = $result->fetch_assoc();

				if($row['sum(sum_qty)'] > $row['max_qty'])
				{
					echo "<p class='text-success h3'><i class='fas fa-check-circle'></i></p>";
				}
				elseif($row['sum(sum_qty)'] < $row['min_qty'])
				{
					echo "<p class='text-danger h3'><i class='fas fa-times-circle'></i></p>";
				}
				else
				{
					echo "<p class='text-warning h3'><i class='far fa-circle'></i></p>";
				}
			}
			else
			{
				return FALSE;
			}
		}

			
		public function addOrder($item_id,$orderQty,$inQty)
		{
			$notReceived = $orderQty - $inQty;
			$sql = "INSERT INTO orders(item_id,order_qty,in_qty,not_received_qty) VALUES($item_id,$orderQty,$inQty,$notReceived)";
			$result = $this->conn->query($sql);

			if($result == TRUE)
			{
				header("location:order-details.php?success=1&message=The item is successfully orderd.");
			}
			else
			{
				header("location:orders.php?success=0&message=An error ocured.");
			}
		}


		public function getOrder()
		{
			$sql = "SELECT orders.order_id,orders.item_id,orders.order_qty,orders.in_qty,orders.not_received_qty,orders.order_date,orders.status,items.item_id,items.item_name,items.category_id,items.product_number,categories.category_id,categories.category_name FROM orders INNER JOIN items ON orders.item_id=items.item_id INNER JOIN categories ON items.category_id=categories.category_id ORDER BY orders.order_id";
			$result = $this->conn->query($sql);

			if($result->num_rows>0)
			{
				$arr = array();
				while($row = $result->fetch_assoc())
				{
					$arr[] = $row;
				}
				return $arr;
			}
			else
			{
				return FALSE;
			}
		}


		public function getNotReceivedQty($item_id)
		{
			$sql = "SELECT item_id,SUM(not_received_qty) FROM orders WHERE item_id=$item_id ORDER BY item_id";
			$result = $this->conn->query($sql);

			if($result->num_rows==1)
			{
				while($row = $result->fetch_assoc())
				{
					echo number_format($row['SUM(not_received_qty)'],0);
				}
			}
			else
			{
				echo "No order.";
			}
		}


		public function displayOrdersAsOptions()
		{
			$sql = "SELECT orders.order_id,orders.item_id,orders.order_qty,orders.not_received_qty,orders.status,items.item_id,items.item_name FROM orders INNER JOIN items ON orders.item_id=items.item_id WHERE orders.status='In Transit'";
			$result = $this->conn->query($sql);

			if($result->num_rows>0)
			{
				echo "<option selected disabled>Select Order Number</option>";
				echo "<option value='-'>No Order Number</option>";

				while($row = $result->fetch_assoc())
				{
					echo "<option value=".$row["order_id"].">".$row["order_id"]." (Item No.".$row['item_id']." - ".$row['item_name']." / Not received ".number_format($row['not_received_qty'],0)."qty)</option>";
				}
			}
			else
			{
				echo "<option value='-'>No Order Number</option>";
			}
		}


		public function displaySelectedOrdersAsOptions($item_id)
		{
			$sql = "SELECT orders.order_id,orders.item_id,orders.order_qty,orders.not_received_qty,orders.status,items.item_id,items.item_name FROM orders INNER JOIN items ON orders.item_id=items.item_id WHERE orders.status='In Transit' AND orders.item_id=$item_id";
			$result = $this->conn->query($sql);

			if($result->num_rows>0)
			{
				echo "<option selected disabled>Select Order Number</option>";
				
				while($row = $result->fetch_assoc())
				{
					echo "<option value=".$row["order_id"].">".$row["order_id"]." (Item No.".$row['item_id']." - ".$row['item_name']." / Not received ".number_format($row['not_received_qty'],0)."qty)</option>";             
				}
			}
			else
			{
				echo "<option>No Order Number</option>";
			}
		}


		public function countOrders()
		{
			$sql = "SELECT COUNT(*) as count FROM orders where status='In Transit'";
			$result = $this->conn->query($sql);

			if($result)
			{
				$count = $result->fetch_assoc();
				return $count['count'];

			}
			else
			{
				return FALSE;
			}
		}


	}

?>