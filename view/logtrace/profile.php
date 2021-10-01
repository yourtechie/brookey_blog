<?php
include APP_PATH.'/view/includes/user_auth.php';
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
    <link rel="stylesheet" href="/styles.css">
  </head>
  <body>
    <!--Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark text-light fixed-top" style="background-color: #953553">
      <div class="container-fluid">
        <a class="navbar-brand" href="/">LOGtrace</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav px-4 ms-auto mb-3 mb-lg-2">
        <li class="nav-item px-4">
          <a class="nav-link active" aria-current="page" href="/"><i class="bi bi-house-door-fill px-2"></i>Home</a>
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
                  <a href="edit_profile?id=<?=$_SESSION['user_id']?>"><i class="bi bi-pencil-square"></i></a>
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
                  <p class="lead"><a  class="text-decoration-none" href="view_profile?id=<?=$user_data['user_id']?>"><i class="text-secondary">Click to view profile</i></a></p>
                </div>
                <div class="h4 p-3 mb-5 d-flex justify-content-evenly">
                  <a href="http://www.facebook.com/<?=$profile['fb_username']?>"><i class="bi bi-facebook"></i></a>
                  <a href="https://www.instagram.com/<?=$profile['in_username']?>"><i class="bi bi-instagram text-danger"></i></a>
                  <a href="https://www.linkedin.com/in/<?=$profile['li_username']?>"><i class="bi bi-linkedin text-info"></i></a>
                  <a href="https://wa.me/<?=$user_data['phone_number']?>"><i class="bi bi-whatsapp text-success"></i></a>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="container">
                <h3 class="text-center fw-bold pt-3" style="color: #953553">My Posts</h3>
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
                <div class="row-sm d-flex mb-3">
                  <div class="col-md-6">
                    <h3><a href="view_blog?id=<?=$showPost['blog_id']?>" class="fw-bold text-decoration-none text-secondary"><?=$showPost['title']?></a></h3>
                    <?php
                    //fetch category of blog
                    $cat = $conn->prepare("SELECT * FROM category WHERE category_id=:cid");
                    $cat->bindParam(":cid",$showPost['category']);
                    $cat->execute();
                    $cate = [];

                    while ($row = $cat->fetch(PDO::FETCH_BOTH)){
                      $cate = $row;
                    }
                     ?>
                     <h5><i class="text-warning">Section: </i><?=$cate['category_name']?></h5>
                    <p><?=$showPost['date_created']?></p>
                  </div>
                  <div class="col-4">
                    <img src="../images/<?=$showPost['img']?>" style="height:100px; width:100px;" class="d-flex d-sm-block order ms-auto p-2 bd-highlight image-fluid" alt="No Available Image">
                  </div>
                  <div class="col-2 d-flex justify-content-around py-5">
                    <a href="action?del=<?= $showPost['blog_id']?>" class="mx-4 text-danger" onclick="return confirm('Are you sure you want to delete this post?');" title="Delete"><i class="bi bi-trash"></i></a>
                    <a href="edit_post?<?=$showPost['title']?>%<?=$user_data['user_name']?>&uid=<?=$_SESSION['user_id']?>&id=<?= $showPost['blog_id']?>" class="text-success" title="Edit"><i class="bi bi-pencil-square"></i></a>
                  </div>
                  <hr>
                </div>
                <?php } ?>
              </div>
					</div>
          <div class="col-md-3">
            <div class="p-2 mb-1 card bg-light text-dark">
            <div class="p-3 mb-3 card bg-light text-center text-dark">
              <h5 style="color: #953553" class="fw-bold"><i class="bi bi-people"></i>&nbsp;&nbsp;Top Writers</h5>
              </div>
              <?php
              //fetch and display top writers
                $writer = $conn->prepare("SELECT created_by, COUNT(created_by) as c from blog GROUP BY created_by ORDER BY COUNT(created_by) DESC LIMIT 5");
                $writer->execute();
                $topWriters = [];

                while ($row = $writer->fetch(PDO::FETCH_BOTH)){
                    $topWriters = $row;
                    ?>
                  <div class="row card-body d-flex justify-content-around p-1">
                    <?php
                    $writer_data = fetchWriters($conn,$topWriters['created_by']);
                    $writer_img = fetchImg($conn,$topWriters['created_by']);
                    ?>
                    <div class="col-3">
                      <?php if($writer_img['dp_name'] > 0){ ?>
                        <img src="../images/<?=$writer_img['dp_name']?>" width="70px" height="70px" class="rounded-circle p-2 justify-content-start" alt="<?=$writer_data['user_name']?>">
  										<?php }else{ ?>
                        <img src="../images/dummy.jpg" width="70px" height="70px" class="rounded-circle p-2 justify-content-start" alt="">
                    <?php } ?>
                    </div>
                    <div class="col-9 pt-2">
                      <a href="view_profile?id=<?=$topWriters['created_by']?>" style="font-size:18px;font-weight:bold" class="text-secondary text-decoration-none"><?=$writer_data['first_name']?> <?=$writer_data['last_name']?></a>
                      <p><i>@<?=$writer_data['user_name']?></i></p>
                    </div>
                  </div>
              <?php } ?>
            </div>
            <div class="p-2 mb-1 card bg-light text-dark">
              <div class="p-3 card bg-light text-center text-dark">
                <h5 style="color: #953553" class="fw-bold"><i class="bi bi-people"></i>&nbsp;&nbsp;Recent Posts</h5>
              </div>
                <?php foreach(array_slice($blogs, 0, 5) as $value): ?>
                  <div class="card-body mb-1 p-3">
                    <h5 style="font-size:17px"><a href="view_blog?id=<?=$value['blog_id']?>" class="text-secondary"><?=$value['title']?></a></h5>
                  </div>
              <?php endforeach; ?>
            </div>
        </div>
				</div>
      </section>

      <!--Footer-->
      <?php include APP_PATH."/view/includes/footer.php" ?>


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
                      <strong><h5 class="py-3"><a href="profile?id=<?=$_SESSION['user_id']?>" class="text-decoration-none text_start"><i class="bi bi-person-lines-fill"></i>&nbsp;&nbsp; Profile</a></h5></strong>
                      <p class="lead"><a href="action?logout=<?=$_SESSION['user_id']?>">Logout</a></p>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>
