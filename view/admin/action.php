<?php

if(isset($_GET['logout'])){
  $id = $_GET['logout'];
  unset($id);
  session_destroy();
  header("Location:admin?message=You Have Logged Out Successfully");
}
?>
