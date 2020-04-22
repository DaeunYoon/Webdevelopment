<?php
  include '../model/session.php';
  
  if(isset($_POST['rid']))
    $rid = $_POST['rid'];
  else
    $rid = $_GET['rid'];
  $sql = "select r.RoomID, r.room_title, r.hostID, r.cost, r.add1, r.add2, r.add3, r.add4, r.max_p from room_info r, account a where r.roomid = '$rid' AND a.ID = r.hostID order by room_title";	

  if($stmt = $conn->prepare($sql)){
    //$stmt->bind_param("is", $rid, $_SESSION['login_user']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    while($row = $result->fetch_object()) {
        $title = $row->room_title;
        $host = $row->hostID;
        $addr = $row->add1 .$row->add2 . $row->add3 . $row->add4;
        $price = $row->cost;
        $max = $row->max_p;
    }
}
else{
    var_dump($conn->error);
}

$sql = "select * from room_option where roomid = '$rid'";
if($stmt = $conn->prepare($sql)){
    //$stmt->bind_param("is", $rid, $_SESSION['login_user']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    while($row = $result->fetch_object()) {
        $broom = $row->BedNumber;
        $kit = $row->Kitchen;
        $inter = $row->internet;
        $park = $row->parking;
        $imgurl = $row->imgurl;
    }
}
else{
    var_dump($conn->error);
}

    