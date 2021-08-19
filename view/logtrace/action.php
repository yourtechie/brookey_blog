<?php
if(isset($_GET['del'])){
  $id = $_GET['del'];
  $del = $conn->prepare("DELETE FROM blog WHERE blog_id=:bid");
  $del->bindParam(":bid",$id);
  $del->execute();
  header('location:home?message=Post Deleted Successfully');
  exit();
}

if(isset($_GET['logout'])){
  $id = $_GET['logout'];
  unset($id);
  session_destroy();
  header("Location:home?message=You Have Logged Out Successfully");
}
?>
