<?php
include '../includes/db.php';

if(isset($_POST['submit'])){
  $error = array();
  if(empty($_POST['firstname'])){
    $error['firstname']="Please enter your first name";
    }
  if(empty($_POST['lastname'])){
    $error['lastname']="Please enter your last name";
    }
  if(empty($_POST['email'])){
    $error['email']= "Enter Email";
    }else{
			$statement=$conn->prepare("SELECT * FROM user WHERE email =:em");
			$statement->bindParam(":em",$_POST['email']);
			$statement->execute();

			if($statement->rowCount()>0){
				$error['email'] = "Email already Exist";
				}

  if(empty($_POST['phone'])){
    $error['phone']= "Enter Your Phone Number";
    }
  if(empty($_POST['username'])){
    $error['username']= "Enter a nickname";
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
    $stmt = $conn->prepare("INSERT INTO user VALUES(NULL, :fn, :lm, :em, :ph, :un, :hsh, NOW(), NOW() )");
    $stmt->bindParam(":fn", $_POST['firstname']);
    $stmt->bindParam(":lm", $_POST['lastname']);
    $stmt->bindParam(":em", $_POST['email']);
    $stmt->bindParam(":ph", $_POST['phone']);
    $stmt->bindParam(":un", $_POST['username']);
    $stmt->bindParam(":hsh", $hash);
    $stmt->execute();
    header("Location:login.php?message=Dear ".$_POST['firstname'].", your account has been created, you can now login.");
      }
    }
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>User Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  </head>
  <body>
    <div class="container">
      <h1 class="text-center">Create New Account</h1>
      <form action="signup.php" method="post">
        <div class="mb-3">
          <label for="firstname" class="col-form-label">
            First Name:
          </label>
          <input type="text" class="form-control" name="firstname" validation="required">
          <?php
          if(isset($error['firstname'])){
          	echo "<p style=color:red>".$error['firstname']."</p>";
          	}
          ?>
        </div>
        <div class="mb-3">
          <label for="lastname" class="col-form-label">
            Last Name:
          </label>
          <input type="text" class="form-control" name="lastname" validation="required">
          <?php
          if(isset($error['lastname'])){
          	echo "<p style=color:red>".$error['lastname']."</p>";
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
            Phone Number:
          </label>
          <input type="text" class="form-control" name="phone" validation="required">
          <?php
          if(isset($error['phone'])){
          	echo "<p style=color:red>".$error['phone']."</p>";
          	}
          ?>
        </div>
        <div class="mb-3">
          <label for="lastname" class="col-form-label">
            User Name:
          </label>
          <input type="text" class="form-control" name="username" validation="required">
          <?php
          if(isset($error['username'])){
          	echo "<p style=color:red>".$error['username']."</p>";
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
      <button type="submit" name="submit" class="btn btn-transparent text-light" style="background-color: #953553">Sign Up</button>
    </form>
      <hr>
      <p class="lead">Already have an account? <a href="login.php">Login</a></p>
    </div>

    <script type="text/javascript"></script>
  </body>
</html>
