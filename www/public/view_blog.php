<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

$blog = fetchSingleBlog($conn,$_GET['id']);
$blogs = fetchBlogs($conn);
$topWriters = fetchTopWriters($conn);
$displayPic = fetchDp($conn,$blog['created_by']);
$user_data = fetchUserDetails($conn,$blog['created_by']);
$profile = fetchProfile($conn,$blog['created_by']);

if(isset($_POST['send'])){
  //check if user is logged in
  if(!isset($_SESSION['user_id']) && !isset($_SESSION['name'])){
  header("location:login.php?error=This activity requires you to login");
  exit();
}else{
  //check comment validity
  $error = [];
  if(empty($_POST['comment'])){
    $error['comment'] = "Please enter your comment";
    }
  if(empty($error)){
    $stmt = $conn->prepare("INSERT INTO comment VALUES(NULL, :cm, :bid, :po, NOW(), NOW() )");
    $stmt->bindParam(":cm", $_POST['comment']);
    $stmt->bindParam(":bid", $_GET['id']);
    $stmt->bindParam(":po", $_SESSION['user_name']);
    $stmt->execute();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$blog['title']?> | LogTrace</title>
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
        <li class="btn btn-white text-light btn-md gx-4" data-bs-toggle="modal" data-bs-target="#login">Account</li>
      </ul>
    </div>
  </div>
    </nav>
    <!--Boxes-->
      <section class="ps-2 pe-2 mt-4 pt-5">
          <div class="row g-3">
            <div class="col-md-3 d-none d-sm-block">
              <?php
              if(isset($_SESSION['user_id'])){
                ?>
                <div class="card bg-light text-dark">
                  <div class="mb-3 p-3 d-flex text-light" style="background-color: #953553">
                    <img src="../images/dummy.jpg" width="60px" height="60px" class="rounded-circle p-2 justify-content-start" alt="">
                    <h3 id="user_name" class="align-self-center"><?= ucwords($_SESSION['name'])?></h3>
                  </div>
                  <div class="card-body">
                    <p class="lead card-text"><?php echo "Your Id is ".$_SESSION['user_id']?></p>
                    <h5><a href="profile.php?id=<?=$_SESSION['user_id']?>" class="text-decoration-none text_start"><i class="bi bi-person-lines-fill"></i>&nbsp;&nbsp; Profile</a></h5>
                  </div>
                </div>
              <?php } else{ ?>
              <div class="card bg-light text-dark">
                <div class="mb-3 p-3 d-flex text-light" style="background-color: #953553">
                  <img src="../images/dummy.jpg" width="60px" height="60px" class="rounded-circle p-2 justify-content-start" alt="">
                  <h3 id="user_name" class="align-self-center">Guest</h3>
                </div>
                <div class="card-body">
                  <p class="lead card-text">You are viewing this page as a guest. Login to get more access to features.</p>
                  <h5><a href="login.php" class="text-decoration-none text_start"><i class="bi bi-person-lines-fill"></i>&nbsp;&nbsp; Login</a></h5>
                </div>
              </div>
              <?php } ?>
            </div>
            <div class="col-md-6">
                <div class="card-body card bg-light text-dark">
                    <div class="mb-3 d-flex justify-content-center">
                      <img src="../images/<?=$blog['img']?>" style="height:auto; max-width:100%; border:none;" class="d-block image-fluid" alt="">
                    </div>
                    <div class="h1 text-center card-title">
                    <h3 class="mb-2 fw-bold"><?=$blog['title']?></h3>
                    <h5 class="mb-2"><i>Written by: </i><?=ucwords($blog['author'])?></h5>
                    <?php
                    //fetch category of blog
                    $cat = $conn->prepare("SELECT * FROM category WHERE category_id=:cid");
                    $cat->bindParam(":cid",$blog['category']);
                    $cat->execute();
                    $cate = [];

                    while ($row = $cat->fetch(PDO::FETCH_BOTH)) {
                      $cate = $row;
                    }
                     ?>
                     <h5 class="mb-2"><i>Section: </i><?=$cate['category_name']?></h5>
                    <p class="lead"><?=$blog['date_created']?></p>
                    </div>
                    <hr>
                    <div class="mb-5">
                      <p class="card-text py-2 mb-1"><?=$blog['body']?></p>
                    </div>
                    <div class="row mt-3">
                      <div class="col-md-3"></div>
                      <div class="col-md-3"></div>
                      <div class="col-md-4 mb-3 text-center d-block w-50">
                        <h4 class="mb-3 fw-bold">About Author</h4>
                        <img src="../images/<?=$displayPic['dp_name']?>" width="100px" height="100px" class="border border-white border-3" alt="">
                        <h5><?=ucwords($blog['author'])?></h5>
                        <p class="lead"><?=$profile['bio']?></p>
                        <div class="h4 p-3 mb-5 d-flex justify-content-evenly">
                          <a href="<?=$profile['fb_username']?>"><i class="bi bi-facebook"></i></a>
                          <a href="<?=$profile['in_username']?>"><i class="bi bi-instagram text-danger"></i></a>
                          <a href="<?=$profile['li_username']?>"><i class="bi bi-linkedin text-info"></i></a>
                          <a href="whatsappme/<?=$user_data['phone_number']?>"><i class="bi bi-whatsapp text-success"></i></a>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="mb-3">
                  <h3 class="mb-3">Comments (100)</h3>
                  <div class="alert alert-danger">
                    <h5>Disclaimer</h5>
                    <p>Comments expressed here do not reflect the opinions of logtrace.com or any employee thereof.</p>
                  </div>
                </div>
                <!--Fetch all Comments Here-->
                  <?php
                  $comm = $conn->prepare("SELECT * FROM comment WHERE blog_id=:bid");
                  $comm->bindParam(":bid",$_GET['id']);
                  $comm->execute();
                  $comment = [];
                  while ($row = $comm->fetch(PDO::FETCH_BOTH)) {
                    $comment = $row;

                  ?>
                <div class="mb-2 bg-light">
                  <div class="alert alert-success">
                    <p><?=$comment['comment']?></p>
                  </div>
                  <div class="d-flex justify-content-end">
                    <h6 class="px-3"><i>posted by </i>@<?=$comment['poster']?></h6>
                    <p class="px-3"><?=$comment['date_created']?></p>
                    <p class="px-3"><?=$comment['time_created']?></p>
                  </div>
                </div>
                <?php   } ?>
                <div class="mb-3">
                  <h3 class="mb-3">Add your comment</h3>
                  <form class="mb-3 text-center" action="" method="post">
                    <div class="mb-3">
                      <textarea name="comment" rows="4" cols="60" class="form-control" placeholder="Enter your comment"></textarea>
                      <?php
                      if(isset($error['comment'])){
                        echo "<p style=color:red>".$error['comment']."</p>";
                        }
                      ?>
                    </div>
                    <button type="submit" name="send" class="btn btn-transparent text-light" style="background-color: #953553">Send Comment</button>
                  </form>
                </div>
            </div>
            <div class="col-md-3">
							<div class="p-3 mb-3 card bg-light text-dark">
								<h5><i class="bi bi-people"></i>&nbsp;&nbsp;Top Writers</h5>
                <?php
                //fetch and display top three writers
                  $writer = $conn->prepare("SELECT author, COUNT(author) as c from blog GROUP BY author ORDER BY COUNT(author) DESC LIMIT 3");
                  $writer->execute();
                  $topWriters = [];

                  while ($row = $writer->fetch(PDO::FETCH_BOTH)){
                      $topWriters = $row;
                      ?>
                    <div class="card-body d-flex h4 mb-1">
                      <img src="../images/dummy.jpg" width="60px" height="60px" class="rounded-circle p-2" alt="">
                      <div class="">
                        <h5 class=""><?=$topWriters['author']?></h5>
                    <?php
                    //fetch username of d top three writers
                    $writers = $conn->prepare("SELECT created_by, COUNT(created_by) as c from blog GROUP BY created_by ORDER BY COUNT(created_by) DESC LIMIT 3");
                    $writers->execute();
                    $writersId = [];

                    while ($row = $writers->fetch(PDO::FETCH_BOTH)){
                        $writersId = $row;

                      $user = $conn->prepare("SELECT * FROM user WHERE user_id=:uid");
                      $user->bindParam(":uid",$writersId['created_by']);
                      $user->execute();
                      $username = [];

                      while ($row = $user->fetch(PDO::FETCH_ASSOC)) {
                        $username = $row;
                      ?>
                        <p style="font-size:15px">@<?=$username['user_name']?></p>
                        <?php } ?>
                      <?php } ?>
                      </div>
                    </div>
    						<?php  } ?>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
