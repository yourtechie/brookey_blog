<?php
session_start();
include '../includes/db.php';
include '../includes/user_auth.php';
include '../includes/functions.php';

$blogs = fetchBlogs($conn);
$user_data = fetchUserDetails($conn,$_GET['id']);
$profile = fetchProfile($conn,$_GET['id']);

if(isset($_POST['update'])){
  //check original user with session
  if($_GET['id'] !== $_SESSION['user_id']){
    header("Location:index.php?error=Error 199!");
    exit();
  }

  //check if user has set up a profile, for insert or update info.
  $statement=$conn->prepare("SELECT * FROM profile WHERE profile_owner =:po");
  $statement->bindParam(":po",$_SESSION['user_id']);
  $statement->execute();

  if($statement->rowCount()<1){
    $stmt = $conn->prepare("INSERT INTO profile VALUES(NULL, :bio, :lt, :fbu, :inu, :liu, :po, NOW(), NOW() )");
    $data=array(
   ":bio"=>$_POST['bio'],
   ":lt"=>$_POST['location'],
   ":fbu"=>$_POST['fb-username'],
   ":inu"=>$_POST['in-username'],
   ":liu"=>$_POST['li-username'],
   ":po"=>$_SESSION['user_id']
   );
   $stmt->execute($data);
   header("Location:index.php?message=Profile Set Successfully");
 }else{
   $stmt = $conn->prepare("UPDATE profile SET bio=:bio, location=:lt, fb_username=:fbu, in_username=:inu, li_username=:liu WHERE profile_owner =:po");
   $data=array(
  ":bio"=>$_POST['bio'],
  ":lt"=>$_POST['location'],
  ":fbu"=>$_POST['fb-username'],
  ":inu"=>$_POST['in-username'],
  ":liu"=>$_POST['li-username'],
  ":po"=>$_SESSION['user_id']
  );
  $stmt->execute($data);
  header("Location:index.php?message=Profile Updated Successfully");
}
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogTrace | Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  </head>
  <body>
    <!--Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark text-light fixed-top" style="background-color: #953553">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">LOGtrace</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav px-4 ms-auto mb-3 mb-lg-2">
        <li class="nav-item px-4">
          <a class="nav-link active" aria-current="page" href="index.php"><i class="bi bi-house-door-fill px-2"></i>Home</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="articles.php"><i class="bi bi-journals px-2 text-primary"></i>Articles</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="stories.php"><i class="bi bi-ladder px-2 text-success"></i>Stories</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="poems.php"><i class="bi bi-book px-2 text-info"></i>Poems</a>
        </li>
        <li class="nav-item dropdown px-4">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-plus-lg px-2 text-warning"></i>
          Create</a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="post.php">Post</a></li>
            <li><a class="dropdown-item" href="#">Challenge</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">New Idea</a></li>
          </ul>
        </li>
      </ul>
      <li class="btn btn-white text-light btn-md gx-4" data-bs-toggle="modal" data-bs-target="#login">Account</li>
    </div>
  </div>
    </nav>
    <!--Boxes-->
      <section class="ps-2 pe-2 mt-4 pt-5">
          <div class="row g-3 d-flex justify-content-center">
            <div class="col-md-6">
              <div class="container">
                <h3>Update Profile Information</h3>
                <hr>
                <div class="mb-4">
                  <h4>First Name</h4>
                  <p class="lead"><?=$user_data['first_name']?></p>
                </div>
                <div class="mb-4">
                  <h4>Last Name</h4>
                  <p class="lead"><?=$user_data['last_name']?></p>
                </div>
                <div class="mb-4">
                  <h4>Phone Number</h4>
                  <p class="lead"><?=$user_data['phone_number']?></p>
                </div>
                <div class="mb-3">
                  <h4>User Name</h4>
                  <p class="lead"><?=$user_data['user_name']?></p>
                  </div>
                <form class="" action="" method="post">
                  <div class="mb-3">
                    <h4>Bio</h4>
                    <textarea name="bio" class="form-control" rows="8" cols="80"><?=$profile['bio']?></textarea>
                  </div>
                  <div class="mb-4">
                    <h4>Location</h4>
                    <input type="text" class="form-control" name="location" value="<?=$profile['location']?>">
                  </div>
                  <div class="mb-3">
                    <h6>Enter your Social Media Details. Leave Blank Where You Do Not have an Account with the Platforms Listed</h6>
                  </div>
                  <div class="mb-4">
                    <h4>Facebook Username</h4>
                    <input type="text" class="form-control" name="fb-username" value="<?=$profile['fb_username']?>">
                  </div>
                  <div class="mb-4">
                    <h4>Instagram Username</h4>
                    <input type="text" class="form-control" name="in-username" value="<?=$profile['in_username']?>">
                  </div>
                  <div class="mb-4">
                    <h4>LinkedIn Username</h4>
                    <input type="text" class="form-control" name="li-username" value="<?=$profile['li_username']?>">
                  </div>
                  <button type="submit" class="btn btn-transparent text-light" style="background-color: #953553" name="update">Update</button>
                </form>
              </div>
					</div>
				</div>
      </section>

      <!--Footer-->
      <?php include "../includes/footer.php"; ?>


      <!-- Modal -->
      <div class="modal fade" id="login" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <div class="text-center p-0 text-dark">
                <h3 style="color: #953553">Hi <?=$_SESSION['name']?></h3>
              </div class="card-title mb-3">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="col-md-12">
                <div class="card bg-light text-dark">
                  <div class="card-body">
                    <div class="mb3 px-3">
                      <strong><h5 class="py-3"><a href="profile.php?id=<?=$_SESSION['user_id']?>" class="text-decoration-none text_start"><i class="bi bi-person-lines-fill"></i>&nbsp;&nbsp; Profile</a></h5></strong>
                      <p class="lead"><a href="action.php?logout=<?=$_SESSION['user_id']?>">Logout</a></p>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
