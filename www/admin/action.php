<?php
session_start();
if(isset($_GET['logout'])){
  $id = $_GET['logout'];
  unset($id);
  session_destroy();
  header("Location:index.php?message=You Have Logged Out Successfully");
}
?>
