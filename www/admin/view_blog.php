<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

$blog = fetchSingleBlog($conn,$_GET['id']);
$blogs = fetchBlogs($conn);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$row['title']?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  </head>
  <body>
    <!--Navbar -->
    <nav class="navbar navbar-expand-lg bg-danger navbar-dark text-light fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Brookey Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav px-4 ms-auto mb-3 mb-lg-2">
        <li class="nav-item px-4">
          <a class="nav-link active" aria-current="page" href="index.php"><i class="bi bi-house-door-fill px-2"></i>Home</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="create_category.php"><i class="bi bi-journals px-2 text-primary"></i>Create Category</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="add_blog.php"><i class="bi bi-ladder px-2 text-success"></i>Create Blog</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="manage_blog.php"><i class="bi bi-book px-2 text-info"></i>Manage Blog</a>
        </li>
        <button class="btn btn-danger btn-md gx-4" id="logbtn" data-bs-toggle="modal" data-bs-target="#login">Login/Signup</button>
			</ul>
    </div>
  </div>
    </nav>
    <!--Boxes-->
      <section class="ps-2 pe-2 mt-4 pt-5">
          <div class="row g-3">
            <div class="col-md-3">
              <div class="card bg-light text-dark">
                <div class="mb-3 p-3 d-flex text-light" style="background-color: #953553">
                  <img src="../images/dummy.jpg" width="60px" height="60px" class="rounded-circle p-2 justify-content-start" alt="">
                  <h3 class="align-self-center"><?=ucwords($_SESSION['admin_name'])?></h3>
                </div>
                <div class="card-body">
                  <p class="lead card-text"><?php echo "Your Id is ".$_SESSION['admin_id']?></p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card-body card bg-light text-dark mb-3">
                    <div class="mb-3">
                      <img src="../images/<?=$blog['img']?>" style="height:auto; max-width:100%; border:none; display:block;" class="d-block image-fluid" alt="">
                    </div>
                    <div class="h1 text-center card-title mb-3">
                    <h3><?=$blog['title']?></h3>
                    <h6><i class="bi bi-person-square"></i>&nbsp;&nbsp;<?=ucwords($blog['author'])?></h6>
  									<h4><?= $blog['category_name']?></h4>
                    <p class="lead"><?=$blog['date_created']?></p>
                    </div>
                    <div class="mb-3">
                      <hr>
                      <p class="card-text mb-3"><?=$blog['body']?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
							<div class="p-3 mb-3 card bg-light text-dark">
								<h5><i class="bi bi-people"></i>&nbsp;&nbsp;Recent Writers</h5>
                  <?php foreach(array_slice($blogs, 0, 3) as $value): ?>
                    <div class="card-body d-flex bd-highlight h4 mb-3">
                      <img src="../images/dummy.jpg" width="60px" height="60px" class="rounded-circle p-2 bd-highlight" alt="">
                      <h5 class="p-2 bd-highlight"><?=$value['author']?></h5>
                    </div>
    						<?php endforeach; ?>
							</div>
              <div class="p-3 mb-3 card bg-light text-dark">
								<h5><i class="bi bi-people"></i>&nbsp;&nbsp;Recent Posts</h5>
                  <?php foreach(array_slice($blogs, 0, 3) as $value): ?>
                    <div class="card-body d-flex bd-highlight h4 mb-3">
                      <h5 class="p-2 bd-highlight"><a href="view_blog.php?id=<?=$value['blog_id']?>" class="text-decoration-none text-secondary"><?=$value['title']?></a></h5>
                    </div>
    						<?php endforeach; ?>
							</div>
          </div>
          </div>
      </section>


      <!--Footer-->
      <footer class="p-5 bg-dark text-light text-center position-relative">
        <div class="container">
          <p class="lead">Copyright &copy; 2021 Brookey Blog</p>
          <a href="#" class="position-absolute bottom-0 end-0 p-5">
            <i class="bi bi-arrow-up-circle h1"></i>
          </a>
        </div>
      </footer>

      <!-- Modal -->
      <div class="modal fade" id="login" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <div class="col-12 text-center h1 p-0 mb-3 bg-danger text-light">
                <i class="bi bi-person"></i>
                <h3 id="admin_info">Guest</h3>
              </div class="card-title mb-3">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="col-md-12">
                <div class="card bg-light text-dark">
                  <div class="card-body text-center">
                    <p class="card-text" id="admin_dash">You are not signed in. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <p class="lead"><a href="signup.php" class="">Sign Up</a></p>
                    <hr>
                    <p class="lead"><a href="login.php" class="">Login</a></p>
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
