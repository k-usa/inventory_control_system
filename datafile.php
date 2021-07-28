<?php
  include 'classes/System_app.php';
  $system_app = new System_app;


  // Sign up
  if(isset($_POST["register"]) && !empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["dep"]) && !empty($_POST["username"]) && !empty($_POST["password"]))
  {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $dep = $_POST["dep"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    $system_app->signup($fname,$lname,$dep,$username,$password);
  }
  elseif(isset($_POST["register"]))
  {
    header("location:register.php?success=0&message=Update unsuccessful. Kindly try again.");
  }


  // Login
  if(isset($_POST["login"]) && !empty($_POST["username"]) && !empty($_POST["password"]))
  {      
    $username = $_POST["username"];
    $password = $_POST["password"];

    $system_app->login($username,$password);
  }
  elseif(isset($_POST["login"]))
  {
    header("location:login.php?success=0&message=Login unsuccessful. Kindly try again.");
  }


  // Add user
  if(isset($_POST["addUser"]) && !empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["dep"]) && !empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["status"]))
  {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $dep = $_POST["dep"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $status = $_POST["status"];

    $system_app->addUser($fname,$lname,$dep,$username,$password,$status);
  }
  elseif(isset($_POST["addUser"]))
  {
    header("location:users.php?success=0&message=Update unsuccessful. Kindly try again.");
  }


  // Update Account
  if(isset($_POST["updateAccount"]) && !empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["dep"]) && !empty($_POST["username"]) && !empty($_POST["status"]))
  {
    $login_id = $_POST["loginId"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $dep = $_POST["dep"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $status = $_POST["status"];

    $system_app->updateUsers($login_id,$fname,$lname,$dep,$username,$password,$status);
  }
  elseif(isset($_POST["updateAccount"]))
  {
    $login_id = $_POST["loginId"];

    header("location:profile.php?id=".$login_id."&success=0&message=Update unsuccessful. Kindly try again.");
  }


  // Change Password
  if(isset($_POST["updatePassword"]) && !empty($_POST["currentPassword"]) && !empty($_POST["newPassword"]) && !empty($_POST["confirmNewPassword"]))
  {
    $login_id = $_POST["loginId"];
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $confirmNewPassword = $_POST["confirmNewPassword"];

    $system_app->changePassword($login_id,$currentPassword,$newPassword,$confirmNewPassword);
  }
  elseif(isset($_POST["updatePassword"]))
  {
    $login_id = $_POST["loginId"];

    header("location:profile.php?id=".$login_id."&success=0&message=Update unsuccessful. Incorrect password. Kindly try again.");
  }


  // Add category
  if(isset($_POST["addCategory"]) && !empty($_POST["categoryName"]))
  {
    $categoryName = $_POST["categoryName"];
    $categoryMemo = $_POST["categoryMemo"];

    $system_app->addCategory($categoryName,$categoryMemo);
  }
  elseif(isset($_POST["addCategory"]))
  {
    header("location:categories.php?success=0&message=An error ocured.");
  }


  // Edit category
  if(isset($_POST["editCategory"]) && !empty($_POST["categoryName"]))
  {
    $categoryId = $_POST["categoryId"];
    $categoryName = $_POST["categoryName"];
    $categoryMemo = $_POST["categoryMemo"];

    $system_app->editCategory($categoryId,$categoryName,$categoryMemo);
  }
  elseif(isset($_POST["editCategory"]))
  {
    header("location:categories.php?success=0&message=An error ocured.");
  }


  // Delete category
  if(isset($_POST["deleteCategory"]))
  {
    $categoryId = $_POST["categoryId"];

    $system_app->deleteCategory($categoryId);
      
  }  


  // Add item
  if(isset($_POST["addItem"]) && !empty($_POST["categoryName"]) && !empty($_POST["itemName"]) && !empty($_POST["productNo"]) && !empty($_POST["purchasePrice"]) && !empty($_POST["salesPrice"]) && !empty($_POST["minQty"]) && !empty($_POST["maxQty"])) 
  {
    $categoryName = $_POST["categoryName"];
    $itemName = $_POST["itemName"];
    $productNo = $_POST["productNo"];
    $purchasePrice = $_POST["purchasePrice"];
    $salesPrice = $_POST["salesPrice"];
    $minQty = $_POST["minQty"];
    $maxQty = $_POST["maxQty"];

    if($minQty<$maxQty)
    {
      $system_app->addItem($categoryName,$itemName,$productNo,$purchasePrice,$salesPrice,$minQty,$maxQty);
    }
    else
    {
      header("location:items.php?success=0&message=An error ocured.");
    }       
  }
  elseif(isset($_POST["addItem"]))
  {
    header("location:items.php?success=0&message=An error ocured.");
  }


  // Edit Item
  if(isset($_POST["editItem"]) && !empty($_POST["categoryName"]) && !empty($_POST["itemName"]) && !empty($_POST["productNo"]) && !empty($_POST["purchasePrice"]) && !empty($_POST["salesPrice"]) && !empty($_POST["minQty"]) && !empty($_POST["maxQty"])) 
  {
    $itemId = $_POST["itemId"];
    $categoryName = $_POST["categoryName"];
    $itemName = $_POST["itemName"];
    $productNo = $_POST["productNo"];
    $purchasePrice = $_POST["purchasePrice"];
    $salesPrice = $_POST["salesPrice"];
    $minQty = $_POST["minQty"];
    $maxQty = $_POST["maxQty"];

    if($minQty<$maxQty)
    {
      $system_app->editItem($itemId,$categoryName,$itemName,$productNo,$purchasePrice,$salesPrice,$minQty,$maxQty);
    }
    else
    {
      header("location:items.php?success=0&message=An error ocured1.");
    }       
  }
  elseif(isset($_POST["editItem"]))
  {
    header("location:items.php?success=0&message=An error ocured.");
  }


  // Delete item
  if(isset($_POST["deleteItem"]))
  {
    $itemId = $_POST["itemId"];

    $system_app->deleteItem($itemId);
      
  }


  // Adjust stock
  if(isset($_POST["adjustStock"]) && !empty($_POST["itemName"]) && !empty($_POST["details"]) && isset($_POST["inQty"]))
  {
    $item_id = $_POST["itemName"];
    $details = $_POST["details"];
    $orderNo = $_POST["orderNo"];
    $inQty = $_POST["inQty"];
    $outQty = $_POST["outQty"];
    $sumQty = $_POST["inQty"] - $_POST["outQty"];
            
    $system_app->adjustStock($item_id,$details,$orderNo,$inQty,$outQty,$sumQty);   
  }
  elseif(isset($_POST["adjustStock"]) && !empty($_POST["itemName"]) && !empty($_POST["details"]) && !empty($_POST["outQty"]))
  {
    $item_id = $_POST["itemName"];
    $details = $_POST["details"];
    $orderNo = $_POST["orderNo"];
    $inQty = $_POST["inQty"];
    $outQty = $_POST["outQty"];
    $sumQty = $_POST["inQty"] - $_POST["outQty"];

    $system_app->adjustStock($item_id,$details,$orderNo,$inQty,$outQty,$sumQty);
  }
  elseif(isset($_POST["adjustStock"]))
  {
    header("location:stocks.php?success=0&message=An error ocured 3.");
  }


  // Add order
  if(isset($_POST["order"]) && !empty($_POST["item_id"]) && !empty($_POST["orderQty"]))
  {
    $item_id = $_POST["item_id"];
    $orderQty = $_POST["orderQty"];
    $inQty = $_POST["inQty"];

    $system_app->addOrder($item_id,$orderQty,$inQty);
    
  }
  elseif(isset($_POST["order"]))
  {
    header("location:orders.php?success=0&message=An error ocured.");
  }




?>