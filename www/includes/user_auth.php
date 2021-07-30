<?php
if(!isset($_SESSION['user_id']) && !isset($_SESSION['user_name'])){
header("location:login.php?error=This activity requires you to login");
exit();
}

?>
