<?php
   include("../model/Config.php");
   include '../model/session.php';
   $target_dir = "../uploads/";
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    //Check if file already exists
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
 
    if(file_exists($target_file)){
        echo "Sorry, file already exists...";
        $uploadOk = 0;
    }
    //Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType!="jpeg" && $imageFileType != "gif"){
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
        $uploadOk = 0;
    }

    if($uploadOk == 0){
        echo "Sorry, your file was not uploaded";
    }
    else{
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $filename = $_FILES["fileToUpload"]["name"];
            $size = $_FILES["fileToUpload"]["size"];            
            $sql = "insert into images(filename, imgurl, size) values(?, ?, ?)";
            if($stmt0 = $conn->prepare($sql)){
                $stmt0->bind_param("ssi", $filename, $target_file, $size);
                $stmt0->execute();
                $stmt0->close();
            }
            else{
                var_dump($conn->error);
            }
    
        }
    }
    // username and password sent from form
   
    $rid = $_POST['rid'];
    try {
        $conn->autocommit(FALSE); //turn on transactions
        $sql = 'update room_info set cost =?, s_date=?, e_date=?, add1=?, add2=?, add3=?, add4=?, hostID=?, room_title=?, max_p=? where roomid=?';
        if($stmt2 = $conn->prepare($sql)){
            $stmt2->bind_param("issssssssii",  $_POST['price'], $_POST['start_date'], $_POST['end_date'], $_POST['adr1'], $_POST['adr2'], $_POST['adr3'], $_POST['adr4'], $_SESSION['login_user'], $_POST['title'], $_POST['max'], $rid);
            $stmt2->execute();


            $stmt3 = $conn->prepare('update room_option set BedNumber=?, Kitchen=?, internet=?, parking=?, content=?, imgurl=? where roomid = ?');
            $stmt3->bind_param("iiiissi", $_POST['bedroom'], $_POST['kitchen'], $_POST['internet'], $_POST['parking'], $_POST['cont'], $target_file, $rid);
            $stmt3->execute();

            $stmt2->close();
            $stmt3->close();
            $conn->autocommit(TRUE);
            header("location: ../view/Main.php");
        }
        else{
            var_dump($conn->error);
        }

    } catch(Exception $e) {
        $conn->rollback(); //remove all queries from queue if error (undo)
        throw $e;
    }  
    
}
