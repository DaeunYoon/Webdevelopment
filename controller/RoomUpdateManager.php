<?php
include("../model/Config.php");
include '../model/session.php';
$rid = $_GET['rid'];
$type = $_GET['type'];
if($type == 0){
    //update 
    $sql = "select * from room_info join room_option using (RoomID) where room_info.roomid = ? order by room_title";
 
    $title = NULL;
    $host = NULL;
    $addr = NULL;
    $price = NULL;
    $max = NULL;

    $broom = NULL;
    $kit = NULL;
    $inter = NULL;
    $park = NULL;
    $cont = NULL;
    $imgurl = NULL;

  if($stmt = $conn->prepare($sql)){
    $stmt->bind_param("i", $rid);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    while($row = $result->fetch_object()) {
        $title = $row->room_title;
        $host = $row->hostID;
        $addr = $row->add1 .$row->add2 . $row->add3 . $row->add4;
        $price = $row->cost;
        $max = $row->max_p;
        $add1 = $row->add1;
        $add2 = $row->add2;
        $add3 = $row->add3;
        $add4 = $row->add4;


        $broom = $row->BedNumber;
        $kit = $row->Kitchen;
        $inter = $row->internet;
        $park = $row->parking;
        $cont = $row->content;

        $imgurl = $row->imgurl;
    }
  }
  else{
      var_dump($conn->error);
  }
  include "../view/Sup_Update_Posting.php";
}
else if($type == 1){
    //delete
    $sql = "delete from room_option where roomid = ?";
    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("i", $rid);
        $stmt->execute();

        if($stmt->affected_rows === 0) echo('No rows deleted 1');
        else if($stmt->affected_rows < 0) echo('error occured during delete the row');
        else{
            $stmt->close();

            $sql1 = "delete from room_info where roomid = ?";
            if($stmt1 = $conn->prepare($sql1)){
                $stmt1->bind_param("i", $rid);
                $stmt1->execute();

                if($stmt1->affected_rows === 0) echo('No rows deleted 2');
    
                $stmt1->close();
                header("location: ../view/Main.php");
            }
            else{
                var_dump($conn->error);
            }
        }
    }
    else{
        var_dump($conn->error);
    }


}