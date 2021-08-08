<?php
 session_start();
 require_once '../includes/db.php';
 include '../includes/user_auth.php';
 include '../includes/functions.php';

 $user_data = fetchUserDetails($conn,$_SESSION['user_id']);
 $displayPic = fetchDp($conn,$_SESSION['user_id']);

 if(isset($_POST['btn_submit'])){
 	$error=array();

 if(empty($_POST['title'])){
 	$error['title']="Please include a title";
 	}
 if(empty($_POST['category'])){
 	$error['category']="Please select the blog category";
   }
 if(empty($_POST['body'])){
   $error['body']="Please include text";
   }

 if(empty($error)){
   //lets check the file upload
   try {
     if(isset($_FILES['image'])){
       $img_name = $_FILES['image']['name']; //getting user uploaded img name.
       $img_type = $_FILES['image']['type']; //getting user uploaded img type.
       $img_size = $_FILES['image']['size']; //getting user uploaded img size.
       $temp_name = $_FILES['image']['tmp_name']; //temporary name used to save/move file in our folder.
      //$path="../images/".$new_img_name;
      if($img_type=="image/jpg" || $img_type=='image/jpeg' || $img_type=='image/png' || $img_type=='image/gif'){ //check file extension
      //if user uploads the valid extenstions stated.
          if($img_size < 5000000){//check file size 5MB
            $time = time(); //this will return current time
            //move file into our folder.
            $new_img_name = $time.$img_name;
            if(move_uploaded_file($temp_name, "../images/".$new_img_name)){//if the image upload moves successfully
            }
          }else{
            $errorMsg="Your File Is Too large Please Upload 5MB Size"; //error message file size not large than 5MB
          }

      }else{
        $errorMsg = "Upload JPG, JPEG, PNG & GIF File Format.....Check File Extension";
      }

     }else{
       $errorMsg = "Please select an image file";
     }
     if(!isset($errorMsg)){
       $stmt = $conn->prepare("INSERT INTO blog VALUES(NULL, :tt, :au, :cat, :bd, :cb, :img, NOW(), NOW() )");
      	$data=array(
      		":tt"=>$_POST['title'],
      		":au"=>$user_data['first_name']." ".$user_data['last_name'],
      		":cat"=>$_POST['category'],
      		":bd"=>$_POST['body'],
      		":cb"=>$_SESSION['user_id'],
          ":img"=>$new_img_name
      		);
        if($stmt->execute($data)){
          $insertMsg="Blog Created Successfully........"; //execute query success message
  				header("refresh:3;index.php"); //refresh 3 second and redirect to index.php page
        }
      }
   } catch (\Exception $e) {
     echo $e->getMessage();
   }

   }
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogTrace | Stories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
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
        <?php if(isset($errorMsg)){?>
                <div class="alert alert-danger">
                	<strong>WRONG ! <?php echo $errorMsg; ?></strong>
                </div>
                <?php } if(isset($insertMsg)){ ?>
    			<div class="alert alert-success">
    				<strong>SUCCESS ! <?php echo $insertMsg; ?></strong>
    			</div>
            <?php } ?>
          <div class="row g-3">
            <div class="col-md-3 d-none d-sm-block">
              <div class="card bg-light text-dark">
                <div class="mb-2 p-1 d-flex text-light" style="background-color: #953553">
                  <?php if($displayPic['dp_name'] < 1){ ?>
                  <img src="../images/dummy.jpg" width="70px" height="70px" class="rounded-circle p-2 justify-content-start" alt="">
                  <?php }else{ ?>
                  <img src="../images/<?=$displayPic['dp_name']?>" width="70px" height="70px" class="rounded-circle p-2 justify-content-start" alt="">
                  <?php } ?>
                  <h3 class="align-self-center"><?= ucwords($_SESSION['name'])?></h3>
                </div>
                <div class="card-body">
									<h5><a href="profile.php?id=<?=$_SESSION['user_id']?>" class="text-decoration-none text_start"><i class="bi bi-person-lines-fill"></i>&nbsp;&nbsp; Profile</a></h5>
                </div>
              </div>
            </div>
						<div class="col-md-9">
              <div class="card bg-light text-dark">
                <div class="card-body text-center">
                  <div class="h1 mb-3">
                    <i class="bi bi-person-square"></i>
                  </div class="card-title mb-3">
                  <h3>Add Blog</h3>
                  <p class="text-start" name="author">Author: <?=$user_data['first_name']." ".$user_data['last_name']?></p>
                  <form class="" action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                      <input type="text" class="form-control" name="title" placeholder="Title">
											<?php
						          if(isset($error['title'])){
						          	echo "<p style=color:red>".$error['title']."</p>";
						          	}
						          ?>
                    </div>

                    <div class="mb-3">
                      <?php
                         $stmt=$conn->prepare("SELECT * FROM category");
                         $stmt->execute();

                         echo "<select name='category' id='category' class='form-control'>";
                         while($row=$stmt->fetch(PDO::FETCH_BOTH)){
                      	   echo "<option value='".$row['category_id']."'>".$row['category_name']."</option>";
                      	   }
                      	echo "<select>";
                       ?>
                    </div>
                    <div class="mb-3">
                      <textarea id="editor" class="form-control" name="body" rows="8" cols="65" placeholder="Enter Text . . ."></textarea>
											<?php
						          if(isset($error['body'])){
						          	echo "<p style=color:red>".$error['body']."</p>";
						          	}
						          ?>
                      </div>
											<div class="mb-3 text-start">
												<label for="image">Select image to upload:</label>
												<input type="file" class="form-control" name="image">
											</div>
                      <div class="mb-3">
                        <button type="submit" name="btn_submit" class="btn btn-transparent text-light" style="background-color: #953553">Publish</button>
                      </div>
                  </form>
                </div>
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
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="col-md-12">
                <div class="card bg-light text-dark">
                  <div class="card-body text-center">
                    <p class="card-text mb-3">
                      <?php
                      //check session and display info
                      if (isset($_SESSION['name'])) {
                        echo "Hi ".ucwords($_SESSION['name']);
                      }else {
                        echo "You are viewing this page as a guest. Login to gain more access to our features.";
                      }
                      ?>
                    </p>
                  </div>
                </div>
                <?php
            		if(isset($_SESSION['user_id'])){
            			?>
                        <div class="mb3 px-3">
                        	<strong><h5 class="py-3"><a href="profile.php?id=<?=$_SESSION['user_id']?>" class="text-decoration-none text_start"><i class="bi bi-person-lines-fill"></i>&nbsp;&nbsp; Profile</a></h5></strong>
                          <p class="lead"><a href="action.php?logout=<?=$_SESSION['user_id']?>">Logout</a></p>
                        </div>
                        <?php } else{ ?>
            			<div class="mb-3 px-3">
                    <p class="lead py-2"><a href="signup.php">Sign Up</a></p>
                    <p class="lead"><a href="login.php">Login</a></p>
            			</div>
                    <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        ClassicEditor
          .create(document.querySelector('#editor'))
          .then(editor => {
          console.log(editor);
          })
          .catch(error => {
          console.error(error);
          });
      </script>
 	</body>
</html>
