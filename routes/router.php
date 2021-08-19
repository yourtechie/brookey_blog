<?php
$uri = explode("/",$_SERVER['REQUEST_URI']);
$str = explode("?",$_SERVER['REQUEST_URI']);


$bid = NULL;
if(isset($_GET['id'])){
  $bid = $_GET['id'];
}

switch ($uri[1]){
  case '':
  include APP_PATH."/view/logtrace/home.php";
    break;

  case "home?$str[1]":
  include APP_PATH."/view/logtrace/home.php";
    break;

  case 'articles':
  include APP_PATH."/view/logtrace/articles.php";
    break;

  case 'stories':
  include APP_PATH."/view/logtrace/stories.php";
    break;

  case 'poems':
  include APP_PATH."/view/logtrace/poems.php";
    break;

  case "login":
  include APP_PATH."/view/logtrace/login.php";
    break;

  case "login?$str[1]":
  include APP_PATH."/view/logtrace/login.php";
    break;

  case 'signup':
  include APP_PATH."/view/logtrace/signup.php";
    break;

  case 'post':
  include APP_PATH."/view/logtrace/post.php";
    break;

  case "view_blog?id=$bid":
  include APP_PATH."/view/logtrace/view_blog.php";
    break;

  case "profile?$str[1]":
  include APP_PATH."/view/logtrace/profile.php";
    break;

  case 'edit_profile':
  include APP_PATH."/view/logtrace/edit_profile.php";
    break;

  case "edit_profile?$str[1]":
  include APP_PATH."/view/logtrace/edit_profile.php";
    break;

  case "view_profile?$str[1]":
  include APP_PATH."/view/logtrace/view_profile.php";
    break;

  case "edit_post?$str[1]":
  include APP_PATH."/view/logtrace/edit_post.php";
    break;

  case "action?$str[1]":
  include APP_PATH."/view/logtrace/action.php";
    break;

  default:
    // code...
    break;
}

//Admin panel
switch ($uri[2]) {

    case "admin":
    include APP_PATH."/view/admin/home.php";
      break;

    case "admin?$str[1]":
    include APP_PATH."/view/admin/home.php";
      break;

      case "adlogin":
      include APP_PATH."/view/admin/login.php";
        break;

      case "adlogin?$str[1]":
      include APP_PATH."/view/admin/login.php";
        break;

      case "create_category":
      include APP_PATH."/view/admin/create_category.php";
        break;

      case "add_blog":
      include APP_PATH."/view/admin/add_blog.php";
        break;

      case "view_blog?id=$bid":
      include APP_PATH."/view/admin/view_blog.php";
        break;

    case "manage_blog":
    include APP_PATH."/view/admin/manage_blog.php";
      break;

    case "manage_blog?$str[1]":
    include APP_PATH."/view/admin/manage_blog.php";
      break;

    case "edit_blog?id=$bid":
    include APP_PATH."/view/admin/edit_blog.php";
      break;

    case "delete_blog":
    include APP_PATH."/view/admin/delete_blog.php";
      break;

    case "adaction?$str[1]":
    include APP_PATH."/view/admin/action.php";
      break;

  default:
    // code...
    break;
}
?>
