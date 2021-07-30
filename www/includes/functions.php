<?php
function fetchSingleBlog($dbconn,$id){
  $single_blog=$dbconn->prepare("SELECT * FROM blog WHERE blog_id=:bid");
  $single_blog->bindParam(":bid", $id);
  $single_blog->execute();
  $blog = [];

  while ($row = $single_blog->fetch(PDO::FETCH_BOTH)) {
    $blog = $row;
  }
  return $blog;
}

function fetchBlogs($dbconn){
  $fetch = $dbconn->prepare("SELECT * FROM blog ORDER BY blog_id DESC");
  $fetch->execute();

  $blog = [];

  while($row = $fetch->fetch(PDO::FETCH_BOTH)){
  	$blog[]=$row;
  }
  return $blog;
}

function fetchUserDetails($dbconn,$id){
  $user_details = $dbconn->prepare("SELECT * FROM user WHERE user_id=:uid");
  $user_details->bindParam(":uid",$id);
  $user_details->execute();
  $user_data = [];

  while ($row = $user_details->fetch(PDO::FETCH_BOTH)) {
    $user_data = $row;
  }
  return $user_data;
}

function fetchProfile($dbconn,$id){
  $prof = $dbconn->prepare("SELECT * FROM profile WHERE profile_owner=:po");
  $prof->bindParam(":po",$id);
  $prof->execute();
  $profile = [];

  while ($row = $prof->fetch(PDO::FETCH_BOTH)) {
    $profile = $row;
  }
  return $profile;
}

function fetchDp($dbconn,$id){
  $dpImage = $dbconn->prepare("SELECT * FROM dp_image WHERE dp_userId=:du");
  $dpImage->bindParam(":du",$id);
  $dpImage->execute();
  $displayPic = [];

  while ($row = $dpImage->fetch(PDO::FETCH_BOTH)) {
    $displayPic = $row;
  }
  return $displayPic;
}

/*function fetchCategory($dbconn,$id){
  $cat = $dbconn->prepare("SELECT * FROM category WHERE category_id=:cid");
  $cat->bindParam(":cid",$id);
  $cat->execute();
  $cate = [];

  while ($row = $cat->fetch(PDO::FETCH_BOTH)) {
    $cate = $row;
  }
  return $cate;
}*/

function fetchTopWriters($dbconn){
  $writer = $dbconn->prepare("SELECT author, COUNT(author) as c from blog GROUP BY author ORDER BY COUNT(author) DESC LIMIT 1 ");
  $writer->execute();
  $topWriters = [];

  while ($row = $writer->fetch(PDO::FETCH_BOTH)){
      $topWriters = $row;
  }
  return $topWriters;
}
