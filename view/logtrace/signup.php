<?php

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
    //if email is valid
      if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $statement=$conn->prepare("SELECT * FROM user WHERE email =:em");
  			$statement->bindParam(":em",$_POST['email']);
  			$statement->execute();

  			if($statement->rowCount()>0){
  				$error['email'] = "Email already Exist";
  				}
      }else{
        $error['email']= "This is not a valid email";
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
    header("Location:login?message=Dear ".$_POST['firstname'].", your account has been created, you can now login.");
      }
    }
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogTrace | Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/styles.css">
  </head>
  <body>
    <!--Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark text-light" style="background-color: #953553">
      <div class="container-fluid">
        <a class="navbar-brand" href="/">LOGtrace</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav px-4 ms-auto mb-3 mb-lg-2">
        <li class="nav-item px-4">
          <a class="nav-link" href="/"><i class="bi bi-house-door-fill px-2"></i>Home</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="articles"><i class="bi bi-journals px-2 text-primary"></i>Articles</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="stories"><i class="bi bi-ladder px-2 text-success"></i>Stories</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="poems"><i class="bi bi-book px-2 text-info"></i>Poems</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="post"><i class="bi bi-plus-lg px-2 text-warning"></i>Create Post</a>
        </li>
      </ul>
      <li class="btn btn-white nav-link active text-light btn-md gx-4" aria-current="page" data-bs-toggle="modal" data-bs-target="#login">Account</li>
    </div>
  </div>
    </nav>
    <div class="container bg-light pt-3">
			<div class="container-fluid">
        <h3 class="fw-bold" style="color: #953553">Create LogTrace Account</h3>
        <hr>
        <form action="" method="post">
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
          <div class="text-center">
            <button type="submit" name="submit" class="btn btn-transparent text-light" style="background-color: #953553">Sign Up</button>
          </div>
      </form>
        <hr>
        <p class="lead">Already have an account? <a href="login">Login</a></p>
      </div>

      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
