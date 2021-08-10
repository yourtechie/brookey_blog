<?php
require '../includes/db.php';
if(isset($_GET['del'])){
  $id = $_GET['del'];
  $del = $conn->prepare("DELETE FROM blog WHERE blog_id=:bid");
  $del->bindParam(":bid",$id);
  $del->execute();
  header('location:index.php?message=Post Deleted Successfully');
  exit();
}

session_start();
if(isset($_GET['logout'])){
  $id = $_GET['logout'];
  unset($id);
  session_destroy();
  header("Location:index.php?message=You Have Logged Out Successfully");
}
?>
