<?php
session_start();
include '../includes/db.php';
include '../includes/user_auth.php';
include '../includes/functions.php';
include_once('processImage.php');

$blogs = fetchBlogs($conn);
$user_data = fetchUserDetails($conn,$_GET['id']);
$profile = fetchProfile($conn,$_GET['id']);
$displayPic = fetchDp($conn,$_GET['id']);
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
            <li><a class="dropdown-item" href="#">Group Challenge</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">New Workspace</a></li>
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
            <div class="col-md-3">
              <div class="card bg-light text-dark">
                <div class="h2 p-3 mb-5 d-flex justify-content-between">
                  <a href="#" onClick="triggerClick()"><i class="bi bi-camera"></i></a>
                  <a href="edit_profile.php?id=<?=$_SESSION['user_id']?>"><i class="bi bi-pencil-square"></i></a>
                </div>
                <div class="h1 mb-4 text-center">
                  <?php if($displayPic['dp_name'] < 1){ ?>
                  <img src="../images/dummy.jpg" width="120px" height="120px" onClick="triggerClick()" class="border border-white border-3" id="profileDisplay" alt="">
                  <?php }else{ ?>
                  <img src="../images/<?=$displayPic['dp_name']?>" width="120px" height="120px" onClick="triggerClick()" class="border border-white border-3" id="profileDisplay" alt="">
                  <?php } ?>
                  <form class="" action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="image" onChange="displayImage(this)" id="profileImage" class="form-control d-none">
                    <button type="submit" name="img_upload" class="btn btn-transparent text-light" style="background-color: #953553">Upload Image</button>
                  </form>
                </div>
                <div class="mb-3 text-center">
                  <h3><?=$user_data['first_name']?> <?=$user_data['last_name']?></h3>
                </div>
                <div class="mb-3 text-center">
                  <p class="lead">@<?=$user_data['user_name']?></p>
                </div>
                <div class="mb-3 text-center">
                  <p class="lead"><?=$profile['bio']?></p>
                </div>
                <div class="mb-3 text-center">
                  <h6>Share your profile:</h6>
                  <p class="lead"><a  class="text-decoration-none" href="https://logtrace.com/profile/<?=$user_data['user_name']?>"><i class="text-secondary">https://logtrace.com/profile/<?=$user_data['user_name']?></i></a></p>
                </div>
                <div class="h4 p-3 mb-5 d-flex justify-content-evenly">
                  <a href="<?=$profile['fb_username']?>"><i class="bi bi-facebook"></i></a>
                  <a href="<?=$profile['in_username']?>"><i class="bi bi-instagram text-danger"></i></a>
                  <a href="<?=$profile['li_username']?>"><i class="bi bi-linkedin text-info"></i></a>
                  <a href="whatsappme/<?=$user_data['phone_number']?>"><i class="bi bi-whatsapp text-success"></i></a>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="container">
                <h3 class="text-center fw-bold">My Posts</h3>
                <hr>
                <?php
                //fetch all the posts made by user
                $post = $conn->prepare("SELECT * FROM blog WHERE created_by=:cb ORDER BY blog_id DESC");
                $post->bindParam(":cb",$_SESSION['user_id']);
                $post->execute();
                $showPost = [];

                while ($row = $post->fetch(PDO::FETCH_BOTH)) {
                  $showPost = $row;
                ?>
                <div>
                  <h3><a href="view_blog.php?id=<?=$showPost['blog_id']?>" class="fw-bold text-decoration-none text-secondary"><?=$showPost['title']?></a></h3>
                  <?php
                  //fetch category of blog
                  $cat = $conn->prepare("SELECT * FROM category WHERE category_id=:cid");
                  $cat->bindParam(":cid",$showPost['category']);
                  $cat->execute();
                  $cate = [];

                  while ($row = $cat->fetch(PDO::FETCH_BOTH)) {
                    $cate = $row;
                  }
                   ?>
                   <h5><i>Section: </i><?=$cate['category_name']?></h5>
                  <p><?=$showPost['date_created']?></p>
                  <div class="col-sm-4 d-flex">
                    <img src="../images/<?=$showPost['img']?>" style="height:100px; width:100px;" class="d-flex d-sm-block order ms-auto p-2 bd-highlight image-fluid" alt="No Available Image">
                  </div>
                  <div class="d-flex justify-content-end">
                    <a href="action.php?del=<?= $showPost['blog_id']?>" class="mx-4 text-danger" onclick="return confirm('Are you sure you want to delete this post?');" title="Delete"><i class="bi bi-trash"></i></a>
                    <a href="edit_post.php?<?=$showPost['title']?>%<?=$user_data['user_name']?>&uid=<?=$_SESSION['user_id']?>&id=<?= $showPost['blog_id']?>" class="text-success" title="Edit"><i class="bi bi-pencil-square"></i></a>
                  </div>
                  <hr>
                </div>
                <?php } ?>
              </div>
					</div>
            <div class="col-md-3">
							<div class="p-3 mb-3 card bg-light text-dark">
								<h5><i class="bi bi-people"></i>&nbsp;&nbsp;Top Writers</h5>
                <?php
                //fetch and display top five writers
                  $writer = $conn->prepare("SELECT author, COUNT(author) as c from blog GROUP BY author ORDER BY COUNT(author) DESC LIMIT 3");
                  $writer->execute();
                  $topWriters = [];

                  while ($row = $writer->fetch(PDO::FETCH_BOTH)){
                      $topWriters = $row;
                      ?>
                    <div class="card-body d-flex bd-highlight h4 mb-3">
                      <img src="../images/dummy.jpg" width="60px" height="60px" class="rounded-circle p-2 bd-highlight" alt="">
                      <h5 class="p-2 bd-highlight"><?=$topWriters['author']?></h5>
                    </div>
    						<?php } ?>
							</div>
              <div class="p-3 mb-1 card bg-light text-dark">
								<h5><i class="bi bi-people"></i>&nbsp;&nbsp;Recent Posts</h5>
                  <?php foreach(array_slice($blogs, 0, 3) as $value): ?>
                    <div class="card-body d-flex bd-highlight mb-1">
                      <h5 style="font-size:17px" class="p-2 bd-highlight"><a href="view_blog.php?id=<?=$value['blog_id']?>" class="text-secondary"><?=$value['title']?></a></h5>
                    </div>
    						<?php endforeach; ?>
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


    <script src="script.js"></script>
    <script type="text/javascript">

    </script>
</body>
</html>
