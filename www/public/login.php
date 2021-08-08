<?php
session_start();
include '../includes/db.php';

if(isset($_POST['submit'])){
	$error=array();

if(empty($_POST['email'])){
	$error['email']="Please Input Your Email Address";
	}

if(empty($_POST['hash'])){
	$error['hash']="Please Input Password";
	}

if(empty($error)){
	$stmt=$conn->prepare("SELECT * FROM user WHERE email= :em");
	$stmt->bindParam(":em",$_POST['email']);
	$stmt->execute();
	$record = $stmt->fetch(PDO::FETCH_BOTH);

	if($stmt->rowCount()>0 &&password_verify($_POST['hash'],$record['hash'])){

		$_SESSION['user_id']= $record['user_id'];
		$_SESSION['name']= $record['first_name']." ".$record['last_name'];
		$_SESSION['user_name']= $record['user_name'];

		header("Location:index.php");
		}else{
		header("Location:login.php?error=Either email or password is incorrect");
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brookey Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  </head>
  <body>
		<div class="container bg-light pt-3">
			<div class="container-fluid p-3">
				<h3 class="fw-bold" style="color: #953553">LogTrace Login</h3>
				<hr>
	      <?php
	      if(isset($_GET['message'])){
	        echo "<p style=color:green>".$_GET['message']."</p>";
	        }
	      ?>
	      <form action="" method="post">
	        <?php
	        if(isset($_GET['error'])){
	        	echo "<p style=color:red>".$_GET['error']."</p>";
	        	}
	        ?>
	        <div class="mb-3">
	          <label for="email" class="col-form-label">
	            Email:
	          </label>
	          <input type="email" class="form-control" name="email">
	          <?php
	          if(isset($error['email'])){
	          	echo "<p style=color:red>".$error['email']."</p>";
	          	}
	          ?>
	        </div>
	        <div class="mb-3">
	          <label for="hash" class="col-form-label">
	            Password:
	          </label>
	          <input type="password" class="form-control" name="hash">
	          <?php
	          if(isset($error['hash'])){
	          	echo "<p style=color:red>".$error['hash']."</p>";
	          	}
	          ?>
	        </div>
					<div class="text-center">
						<button type="submit" name="submit" class="btn btn-transparent text-light" style="background-color: #953553">Login</button>
					</div>
	    </form>
	      <hr>
	      <p class="lead">Don't have an account yet? <a href="signup.php">Sign Up</a></p>
			</div>
    </div>
  </body>
</html>
