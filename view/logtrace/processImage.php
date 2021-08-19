<?php
//https://codewithawa.com/posts/image-preview-and-upload-using-php-and-mysql-database
if (isset($_POST['img_upload'])){
  //lets check the file upload
  try {
    if(isset($_FILES['image'])){
      $img_name = $_FILES['image']['name']; //getting user uploaded img name.
      $img_type = $_FILES['image']['type']; //getting user uploaded img type.
      $img_size = $_FILES['image']['size']; //getting user uploaded img size.
      $temp_name = $_FILES['image']['tmp_name']; //temporary name used to save/move file in our folder.
     //$path="../images/".$new_img_name;
     if($img_type=="image/jpg" || $img_type=='image/jpeg' || $img_type=='image/png' || $img_type=='image/gif'){ //check file extension
     //if user uploads the valid extenstions stated.
         if($img_size < 5000000){//check file size 5MB
           $time = time(); //this will return current time
           //move file into our folder.
           $new_img_name = $time.$img_name;
           if(move_uploaded_file($temp_name, "images/".$new_img_name)){//if the image upload moves successfully
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
    if(!isset($errorMsg)){
      //check if user has set up a db, for insert or update dp.
      $statement=$conn->prepare("SELECT * FROM dp_image WHERE dp_userId =:du");
      $statement->bindParam(":du",$_SESSION['user_id']);
      $statement->execute();

      if($statement->rowCount()<1){
      $stmt = $conn->prepare("INSERT INTO dp_image VALUES(NULL, :dn, :du, NOW(), NOW() )");
      $data=array(
        ":dn"=>$new_img_name,
        ":du"=>$_SESSION['user_id']
        );
       if($stmt->execute($data)){
         $insertMsg="DP Uploaded Successfully........"; //execute query success message
       }
     }else{
     $stmt = $conn->prepare("UPDATE dp_image SET dp_name=:dn WHERE dp_userId =:du");
     $data=array(
       ":dn"=>$new_img_name,
       ":du"=>$_SESSION['user_id']
       );
      if($stmt->execute($data)){
        $insertMsg="DP Changed Successfully........"; //execute query success message
      }
   }
   }
  } catch (\Exception $e) {
    echo $e->getMessage();
  }

}
?>
