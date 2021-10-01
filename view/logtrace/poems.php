<?php
$displayPic = fetchDp($conn,$_SESSION['user_id']);
$fetch=$conn->prepare("SELECT * FROM blog WHERE category=3");
$fetch->execute();

$blogs=array();

while($row=$fetch->fetch(PDO::FETCH_BOTH)){
	$blogs[]=$row;
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogTrace | Poems</title>
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
          <a class="nav-link" href="/"><i class="bi bi-house-door-fill px-2"></i>Home</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="articles"><i class="bi bi-journals px-2 text-primary"></i>Articles</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link" href="stories"><i class="bi bi-ladder px-2 text-success"></i>Stories</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link active" aria-current="page" href="poems"><i class="bi bi-book px-2 text-info"></i>Poems</a>
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
          <div class="row g-3">
						<div class="col-md-3">
              <?php
              if(isset($_SESSION['user_id'])){
                ?>
                <div class="card bg-light text-dark">
									<div class="mb-2 p-1 d-flex text-light" style="background-color: #953553">
										<?php if($displayPic['dp_name'] < 1){ ?>
										<img src="../images/dummy.jpg" width="60px" height="60px" class="rounded-circle p-2 justify-content-start" alt="">
										<?php }else{ ?>
										<img src="../images/<?=$displayPic['dp_name']?>" width="70px" height="70px" class="rounded-circle p-2 justify-content-start" alt="">
										<?php } ?>
										<h3 class="align-self-center"><?= ucwords($_SESSION['name'])?></h3>
                  </div>
                  <div class="card-body">
                    <h5><a href="profile?id=<?=$_SESSION['user_id']?>" class="text-decoration-none text_start"><i class="bi bi-person-lines-fill"></i>&nbsp;&nbsp; Profile</a></h5>
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
                  <h5><a href="login" class="text-decoration-none text_start"><i class="bi bi-person-lines-fill"></i>&nbsp;&nbsp; Login</a></h5>
                </div>
              </div>
              <?php } ?>
            </div>
						<div class="col-md-6">
							<?php foreach($blogs as $value): ?>
              <div class="card text-dark">
                <div class="card-body mb-1">
									<div>
                    <h4><a href="view_blog?id=<?=$value['blog_id']?>" class="fw-bold text-decoration-none text-secondary"><?=$value['title']?></a></h4>
                    <h6 style="font-size:18px;color:grey;font-weight:bold"><i class="bi bi-person-circle text-warning me-2"></i><i><?=$value['author']?></i></h6>
                  </div>
                  <hr>
                  <div class="row-sm d-flex justify-content-between">
                    <div class="col-md-8">
                      <p class="card-text mb-3" style="font-size:20px"><?= substr($value['body'],0,100)." . . ."?></p>
                    </div>
                    <div class="col-sm-4 d-flex">
                      <?php if ($value['img'] >= 1){ ?>
                      <img src="../images/<?=$value['img']?>" style="height:100px; width:100px;" class="d-flex d-sm-block order ms-auto p-2 bd-highlight image-fluid" alt="No Available Image">
                    <?php }else{ ?>
                      <p></p>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
						<?php endforeach; ?>
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
                    <h5 style="font-size:17px"><a href="view_blog.php?id=<?=$value['blog_id']?>" class="text-secondary"><?=$value['title']?></a></h5>
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
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="col-md-12">
                <div class="card bg-light text-dark">
                  <div class="card-body text-center">
                    <p class="card-text mb-3">
                      <?php
                      //check session and display info
                      if(isset($_SESSION['name'])){
                        echo "Hi ".ucwords($_SESSION['name']);
                      }else{
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
                        	<strong><h5 class="py-3"><a href="profile?id=<?=$_SESSION['user_id']?>" class="text-decoration-none text_start"><i class="bi bi-person-lines-fill"></i>&nbsp;&nbsp; Profile</a></h5></strong>
                          <p class="lead"><a href="action?logout=<?=$_SESSION['user_id']?>">Logout</a></p>
                        </div>
                        <?php } else{ ?>
            			<div class="mb-3 px-3">
                    <p class="lead py-2"><a href="signup">Sign Up</a></p>
                    <p class="lead"><a href="login">Login</a></p>
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
