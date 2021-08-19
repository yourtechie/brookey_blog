<?php
include APP_PATH.'/view/includes/auth.php';

if(!isset($_GET['id'])){
	header("Location:manage_blog");
	exit();
}

$statement = $conn->prepare("DELETE FROM blog WHERE blog_id=:bid");
$statement->bindParam(":bid", $_GET['id']);
$statement->execute();

header("Location:manage_blog");
exit();
