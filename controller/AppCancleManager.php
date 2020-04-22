<?php 
    include "../model/Config.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script src="jquery_function.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/sup_style.css" rel="stylesheet" type="text/css">
<title>RoomShare</title>

</head>
<body>

	<?php
		$rid = $_GET['rnum'];
		
        $sql = "delete from room_reserve_info where reserveNum ='$rid'";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("i", $num);
            $stmt->execute();
            $stmt->close();
            echo "<script>alert('예약이 삭제되었습니다.');</script>";
        }
        else{
            echo "<script>alert('다시 시도해 주세요.');</script>";
            var_dump($conn->error);
        }

        header("location: ../view/ConRegApp.php");
		
	?>

</body>

</html>