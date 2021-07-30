<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

$fetch=$conn->prepare("SELECT * FROM blog ORDER BY blog_id DESC");
$fetch->execute();

$records=array();

while($row=$fetch->fetch(PDO::FETCH_BOTH)){
	$records[]=$row;
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
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
          <a class="nav-link" href="index.php"><i class="bi bi-house-door-fill px-2"></i>Home</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="create_category.php"><i class="bi bi-journals px-2 text-primary"></i>Create Category</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="add_blog.php"><i class="bi bi-ladder px-2 text-success"></i>Create Blog</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link active" aria-current="page" href="manage_blog.php"><i class="bi bi-book px-2 text-info"></i>Manage Blog</a>
        </li>
				<button class="btn btn-danger btn-md gx-4" id="logbtn" data-bs-toggle="modal" data-bs-target="#login">Login/Signup</button>
			</ul>
    </div>
  </div>
    </nav>
    <!--Boxes-->
      <section class="m-0 pt-5">
          <div class="row text-center g-3">
            <?php
            if(isset($_GET['message'])){
            	echo "<p style=color:green>".$_GET['message']."</p>";
            	}
            ?>
            <div class="col-sm-12">
              <div class="card bg-light text-dark">
                <div class="card-body">
                  <div class="h3 mb-3 bg-warning text-center text-light p-3">
                    <i class="bi bi-person-square"></i>
                    <?= ucwords($_SESSION['admin_name'])?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo "Your Id is ".$_SESSION['admin_id']?>

                  </div class="card-title mb-3">
                  <h3>Manage Blog</h3>
                  <div class="table-responsive-md">
                  <table class="table caption-top">
                    <caption>Blog List</caption>
                    <thead>
                      <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Category Id</th>
                        <th scope="col">Body</th>
												<th scope="col">Image</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Time Published</th>
                      </tr>
                    </thead>
                  <?php foreach($records as $value): ?>
                    <tr>
                      <td><?=$value['title']?></td>
                      <td><?=$value['author']?></td>
                      <td><?=$value['category']?></td>
                      <td><?=$value['body']?></td>
											<td><?=$value['img']?></td>
                      <td><a href="edit_blog.php?id=<?=$value['blog_id']?>">Edit</a></td>
                      <td><a href="delete_blog.php?id=<?=$value['blog_id']?>">Delete</a></td>
                      <td><?=$value['date_created']?></td>
                      <td><?=$value['time_created']?></td>
                    </tr>
                  <?php endforeach; ?>
                  </table>
                  </div>
                </div>
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
