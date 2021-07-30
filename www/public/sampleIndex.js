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
