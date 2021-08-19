<?php
include APP_PATH.'/view/includes/auth.php';

if(isset($_GET['id'])){
$blog_id = $_GET['id'];
}else{
	header("Location:manage_blog");
}

$statement=$conn->prepare("SELECT * FROM category");
$statement->execute();
$select=[];
while($row=$statement->fetch(PDO::FETCH_BOTH)){
	$select[]=$row;
}

$stmt=$conn->prepare("SELECT * FROM blog WHERE blog_id=:bid");
$stmt->bindParam(":bid", $blog_id);
$stmt->execute();

$record = $stmt->fetch(PDO::FETCH_BOTH);
if($stmt->rowCount()<1){
 header("Location:manage_blog");
 exit();
}

if(isset($_POST['submit'])){
	$error=[];

if(empty($_POST['title'])){
	$error['title']="Please include a title";
	}
if(empty($_POST['author'])){
  $error['author']="Include the author";
  }
if(empty($_POST['category'])){
	$error['title']="Please select the blog category";
  }
if(empty($_POST['body'])){
  $error['body']="Please include text";
  }

if(empty($error)){
	if(isset($_FILES['image'])){
		$img_name = $_FILES['image']['name']; //getting user uploaded img name.
		$img_type = $_FILES['image']['type']; //getting user uploaded img type.
		$img_size = $_FILES['image']['size']; //getting user uploaded img size.
		$temp_name = $_FILES['image']['tmp_name']; //temporary name used to save/move file in our folder.
		$path="images/";
	 if($img_type=="image/jpg" || $img_type=='image/jpeg' || $img_type=='image/png' || $img_type=='image/gif'){ //check file extension
	 //if user uploads the valid extenstions stated.
			 if($img_size < 5000000){//check file size 5MB
				 $time = time(); //this will return current time
				 //move file into our folder.
				 $new_img_name = $time.$img_name;
				 if(move_uploaded_file($temp_name, $path.$new_img_name)){//if the image upload moves successfully
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
	$statement=$conn->prepare("UPDATE blog SET title=:tt, author=:au, category=:cat, body=:bd, img=:img WHERE blog_id =:bid");
	$statement->bindParam(":tt", $_POST['title']);
	$statement->bindParam(":au", $_POST['author']);
	$statement->bindParam(":cat", $_POST['category']);
	$statement->bindParam(":bd", $_POST['body']);
	$statement->bindParam(":img", $new_img_name);
	$statement->bindParam(":bid", $blog_id);

	$statement->execute();

	header("Location:manage_blog");
	exit();
	}
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brookey Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
		<script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
  </head>
  <body>
    <!--Navbar -->
    <nav class="navbar navbar-expand-lg bg-danger navbar-dark text-light">
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
          <a class="nav-link" href="create_category"><i class="bi bi-journals px-2 text-primary"></i>Create Category</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link active" aria-current="page" href="add_blog"><i class="bi bi-ladder px-2 text-success"></i>Create Blog</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="manage_blog"><i class="bi bi-book px-2 text-info"></i>Manage Blog</a>
        </li>
    </div>
  </div>
  <button class="btn btn-danger btn-md gx-4" id="logbtn" data-bs-toggle="modal" data-bs-target="#login">Login/Signup</button>
    </nav>
    <!--Boxes-->
      <section class="ps-2 pe-2 mt-4">
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
                  <h3>Edit Blog</h3>
                  <form class="" action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                      <input type="text" class="form-control" name="title" placeholder="Title" value="<?=$record['title']?>">
											<?php
						          if(isset($error['title'])){
						          	echo "<p style=color:red>".$error['title']."</p>";
						          	}
						          ?>
                    </div>
                    <div class="mb-3">
                      <input type="text" class="form-control" name="author" placeholder="Author" value="<?=$record['author']?>">
											<?php
						          if(isset($error['author'])){
						          	echo "<p style=color:red>".$error['author']."</p>";
						          	}
						          ?>
                    </div>
                    <div class="mb-3">
                      <select class="form-control" name="category">
                    <?php foreach($select as $value): ?>
                        <option value="<?= $value['category_id']?>">
                          <?=$value['category_name']?>
                        </option>
                    <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="mb-3">
                      <textarea id="editor" class="form-control" name="body" rows="8" cols="65" placeholder="Enter Text . . .">
                        <?= $record['body']?>
                      </textarea>
											<?php
						          if(isset($error['body'])){
						          	echo "<p style=color:red>".$error['body']."</p>";
						          	}
						          ?>
                      </div>
											<div class="mb-3">
												<label for="image">Select image to upload:</label>
												<input type="file" class="form-control" name="image" value="../images/<?=$record['img']?>">
											</div>
                      <div class="mb-3">
                        <input type="submit" class="btn btn-danger" name="submit" value="Publish"</button>
                      </div>
                  </form>
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
