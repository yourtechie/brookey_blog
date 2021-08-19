<?php
session_start();
define("APP_PATH",dirname(dirname(__FILE__)));
//Add database connection, controller and routes for the view
include APP_PATH."/model/model.php";
include APP_PATH."/controller/controller.php";
include APP_PATH."/routes/router.php";

?>
