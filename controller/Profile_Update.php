<?php
error_reporting(E_ALL);
ini_set("display_errors", '1');

   include("../model/Config.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form

    try {
        $conn->autocommit(FALSE); //turn on transactions
        $stmt = $conn->prepare("update Account set PW=?, Username=?, state=?, PhoneNumber=? where ID=?");
        $stmt->bind_param("ssiss", $_POST['PW'], $_POST['name'], $_POST['type'], $_POST['tel'], $_POST['ID']);
        $stmt->execute();
        $stmt->close();
        $conn->autocommit(TRUE);
        header("location: /project/view/Profile_R.php");
    } catch(Exception $e) {
        $conn->rollback(); //remove all queries from queue if error (undo)
        throw $e;
    }  
  
}
else if($_SERVER["REQUEST_METHOD"] == "GET") {
    include("../model/Config.php");
    include '../model/session.php';
}

    //update 
    $sql = "select * from account where ID=?";

  if($stmt = $conn->prepare($sql)){
    $stmt->bind_param("s", $_SESSION['login_user']);

    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    while($row = $result->fetch_object()) {
        $id = $row->ID;
        $name = $row->Username;
        $phone = $row->PhoneNumber;
    }

    include "../view/Profile_U.php";
  }
  else{
      var_dump($conn->error);
  }


