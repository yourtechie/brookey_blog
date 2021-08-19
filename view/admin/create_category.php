<?php
include APP_PATH.'/view/includes/auth.php';

if(isset($_POST['submit'])){
	$error=array();

if(empty($_POST['category_name'])){
	$error['category_name']="Field cannot be empty";
	}

if(empty($error)){
	$statement = $conn->prepare("INSERT INTO category VALUES(NULL, :cnm, :cb, NOW(), NOW())");
	$statement->bindParam(":cnm",$_POST['category_name']);
	$statement->bindParam(":cb",$_SESSION['admin_id']);
	$statement->execute();

	header("Location:create_category.php");
	exit();
	}
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brookey Blog|Create Category</title>
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
          <a class="nav-link" href="admin"><i class="bi bi-house-door-fill px-2"></i>Home</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link active" aria-current="page" href="create_category"><i class="bi bi-journals px-2 text-primary"></i>Create Category</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="add_blog"><i class="bi bi-ladder px-2 text-success"></i>Create Blog</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="manage_blog"><i class="bi bi-book px-2 text-info"></i>Manage Blog</a>
        </li>
				<button class="btn btn-danger btn-md gx-4" id="logbtn" data-bs-toggle="modal" data-bs-target="#login">Login/Signup</button>
			</ul>
    </div>
  </div>
    </nav>
    <!--Boxes-->
      <section class="ps-2 pe-2 mt-4 pt-5">
          <div class="row text-center g-3">
            <div class="col-md-3">
              <div class="card bg-light text-dark">
                <div class="card-body text-center">
                  <div class="h1 p-0 mb-3 bg-danger text-light">
                    <i class="bi bi-person"></i>
                    <h3 id="admin_name"><?= ucwords($_SESSION['admin_name'])?></h3>
                  </div class="card-title mb-3">
                  <p class="card-text" id="admin_board"><?php echo "Your Id is ".$_SESSION['admin_id']?></p>
                </div>
              </div>
            </div>
            <div class="col-md-9">
              <div class="card bg-light text-dark">
                <div class="card-body text-center">
                  <div class="h1 mb-3">
                    <i class="bi bi-person-square"></i>
                  </div class="card-title mb-3">
                  <h3>Create Blog Category</h3>
                  <form class="" action="" method="post">
                    <div class="mb-3">
                      <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Category Name">
											<?php
						          if(isset($error['category_name'])){
						          	echo "<p style=color:red>".$error['category_name']."</p>";
						          	}
						          ?>
										</div>
                      <div class="mb-3">
                        <input type="submit" class="btn btn-danger" name="submit" value="Publish"/>
                      </div>
                  </form>

                  <table class="table caption-top">
                    <caption>List of Categories</caption>
                    <thead>
                      <tr>
                        <th scope="col">Category Name</th>
                        <th scope="col">Created By</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Time Created</th>
                      </tr>
                    </thead>

                    <?php
                    $select = $conn->prepare("SELECT * FROM category");
                    $select->execute();

                    while($row=$select->fetch(PDO::FETCH_BOTH)){
                    	echo "<tr>";
                    	echo "<td>".$row['category_name']."</td>";
                    	echo "<td>".$row['created_by']."</td>";
                    	echo "<td>".$row['date_created']."</td>";
                    	echo "<td>".$row['time_created']."</td>";
                    	echo "</tr>";
                    	}


                    ?>
                  </table>
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
                <h3 id="admin_info"><?= ucwords($_SESSION['admin_name'])?></h3>
              </div class="card-title mb-3">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="col-md-12">
                <div class="card bg-light text-dark">
                  <div class="card-body text-center">
                    <p class="lead"><a href="adaction?logout=<?=$_SESSION['admin_id']?>">Logout</a></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript"></script>
  </body>
</html>
