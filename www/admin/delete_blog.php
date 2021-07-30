<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

if(!isset($_GET['id'])){
	header("Location:manage_blog.php");
	exit();
}

$statement = $conn->prepare("DELETE FROM blog WHERE blog_id=:bid");
$statement->bindParam(":bid", $_GET['id']);
$statement->execute();

header("Location:manage_blog.php");
exit();
