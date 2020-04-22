<?php include "../model/Config.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/sup_style.css" rel="stylesheet" type="text/css">
<title>RoomShare</title>

</head>
<body>

	<?php
		$rid = $_GET['rnum'];
		
		$sql = "update room_reserve_info set conform = '2' where reserveNum ='$rid' ";
		if($stmt = $conn->prepare($sql)){
            //$stmt->bind_param("is", $rid, $_SESSION['login_user']);
            $stmt->execute();
            $stmt->close();
        
		
	?>
	
	<script>
    <?php
        echo("alert('Reservation successfully denied.');");
        }
        else{
            echo("alert('Sorry! Error occurred, Please Try again.);");
            var_dump($conn->error);
        }
        
	?>

	location.href='../view/Main.php'
	</script>
	

</body>

</html>