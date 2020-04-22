<?php
include("../model/Config.php");
include '../model/session.php';
$del_id = $_POST['del'];
//if usertype owener
if($_SESSION['state'] == 1){
    //find all room
    $stmt = $conn->prepare("select roomid from room_info where hostID=?");
    $stmt->bind_param("s", $del_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_object()){
        //delete all room reserve info
        $stmt2 = $conn->prepare("delete from room_reserve_info where RoomID=?");
        $stmt2->bind_param("i", $row->roomid);
        $stmt2->execute();

        //delete all room option
        $sql = "delete from room_option where roomid = ?";
        $stmt1 = $conn->prepare($sql);
        $stmt1->bind_param("i", $row->roomid);
        $stmt1->execute();
 
    }
    //delete all room
    $stmt = $conn->prepare("delete from room_info where hostID=?");
    $stmt->bind_param("s", $del_id);
    $stmt->execute();
    //delete account
    $stmt = $conn->prepare("delete from account where ID=?");
    $stmt->bind_param("s", $del_id);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        header("location: ../view/Login.php");
    }
    else{
        echo $stmt->affected_rows;
    }
}
else{
    //else if usertype user
    //delete all room reserve info
    $stmt2 = $conn->prepare("delete from room_reserve_info where guestID=?");
    $stmt2->bind_param("s", $del_id);
    $stmt2->execute();
    //delete account
    $stmt = $conn->prepare("delete from account where ID=?");
    $stmt->bind_param("s", $del_id);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        header("location: ../view/Login.php");
    }
    else{
        echo $stmt->affected_rows;
    }
}
