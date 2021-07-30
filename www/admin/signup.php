<?php
include '../includes/db.php';

if(isset($_POST['submit'])){
  $error = array();
  if(empty($_POST['fullname'])){
    $error['fullname']="Please Enter Full Name";
    }
if(empty($_POST['email'])){
  $error['email']= "Enter Email";
  }else{
			$statement=$conn->prepare("SELECT * FROM admin WHERE email =:em");
			$statement->bindParam(":em",$_POST['email']);
			$statement->execute();

			if($statement->rowCount()>0){
				$error['email'] = "Email already Exist";
				}

if(empty($_POST['phone'])){
  $error['phone']= "Enter Your Phone Number";
  }
if(empty($_POST['hash'])){
  $error['hash']= "Enter Password";
  }
if(empty($_POST['confirm_hash'])){
  $error['confirm_hash']= "Please Confirm Password";
}elseif($_POST['confirm_hash']!== $_POST['hash']){
    $error['confirm_hash']="Password Mismatch";
    }
if(empty($error)){
    $hash = password_hash($_POST['hash'], PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO admin VALUES(NULL, :fn, :em, :ph, :hsh, NOW(), NOW() )");
    $stmt->bindParam(":fn", $_POST['fullname']);
    $stmt->bindParam(":em", $_POST['email']);
    $stmt->bindParam(":ph", $_POST['phone']);
    $stmt->bindParam(":hsh", $hash);
    $stmt->execute();
    header("Location:login.php?message=Dear ".$_POST['fullname'].", your account has been created, you can now login.");
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="container">
      <h1 class="text-center">Signup as an Admin</h1>
      <form role="form" action="" method="post">
        <div class="mb-3">
          <label for="fullname" class="col-form-label">
            Full Name:
          </label>
          <input type="text" class="form-control" name="fullname">
          <?php
          if(isset($error['fullname'])){
          	echo "<p style=color:red>".$error['fullname']."</p>";
          	}
          ?>
        </div>
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
          <label for="phone" class="col-form-label">
            Phone No:
          </label>
          <input type="number" class="form-control" name="phone">
          <?php
          if(isset($error['phone'])){
          	echo "<p style=color:red>".$error['phone']."</p>";
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
        <div class="mb-3">
          <label for="confirm_hash" class="col-form-label">
            Confirm Password:
          </label>
          <input type="password" class="form-control" name="confirm_hash">
          <?php
          if(isset($error['confirm_hash'])){
          	echo "<p style=color:red>".$error['confirm_hash']."</p>";
          	}
          ?>
        </div>
      <input type="submit" name="submit" class="btn btn-danger" value="Sign Up"/>
      <hr>
      <p class="lead">Already have an account? <a href="login.php">Login</a></p>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript"></script>
  </body>
</html>
