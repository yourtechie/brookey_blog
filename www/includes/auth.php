<?php
if(!isset($_SESSION['admin_id']) && !isset($_SESSION['admin_name'])){
header("location:login.php?error=The page you visited requires login");
exit();
}

?>
