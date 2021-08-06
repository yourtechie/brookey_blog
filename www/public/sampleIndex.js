window.addEventListener("load",function(e){
  var method = "POST";
  var url = "backend/session.php";

  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function(){
    if(xhr.readyState == 4 && xhr.status == 200){
      console.log(xhr.responseText);
      var res = JSON.parse(xhr.responseText);
      if(res.message){
      document.getElementById("dashboard").innerHTML = "<a href='login.php'>Login</a>";
      }
      if(res.success){
        document.getElementById("logbtn").innerHTML = "Account";
      }
    }
  }
  xhr.open(method,url,true);
  xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  xhr.send();
});

function login(){
  var a = document.createElement('a');
  var link = document.createTextNode("This is link");
  a.appendChild(link);
  a.title = "Click here to login";
  a.href = "login.php";
  document.body.appendChild(a);
}


<?php
//fetch and display top 5 writers
  $writer = $conn->prepare("SELECT created_by, COUNT(created_by) as c from blog GROUP BY created_by ORDER BY COUNT(created_by) DESC LIMIT 3");
  $writer->execute();
  $topWriters = $writer->fetch(PDO::FETCH_BOTH);

  $user = $conn->prepare("SELECT * FROM user WHERE user_id=:uid");
  $user->bindParam(":uid",$topWriters['created_by']);
  $user->execute();
  $username = [];

  while ($row = $user->fetch(PDO::FETCH_ASSOC)) {
    $username = $row;
  }
      ?>


      <?php
      //fetch username of d top three writers
      $writers = $conn->prepare("SELECT created_by, COUNT(created_by) as c from blog GROUP BY created_by ORDER BY COUNT(created_by) DESC LIMIT 3");
      $writers->execute();
      $writersId = [];

      while ($row = $writers->fetch(PDO::FETCH_BOTH)){
          $writersId = $row;

        $user = $conn->prepare("SELECT * FROM user WHERE user_id=:uid");
        $user->bindParam(":uid",$writersId['created_by']);
        $user->execute();
        $username = [];

        while ($row = $user->fetch(PDO::FETCH_ASSOC)) {
          $username = $row;
        ?>
      <?php } ?>
