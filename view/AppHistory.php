<?php include "../model/session.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
	td {margin: auto; text-align: center}
</style>
<script src="jquery_function.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/style1.css" rel="stylesheet" type="text/css">
<link href="css/sup_style.css" rel="stylesheet" type="text/css">

<title>RoomShare</title>
</head>
<body>

	<?php
		if($_SESSION['state'] === 1) {
        //get not replied reserve info 
        $sql = "select RoomId,StartDate,EndDate,reserveNum,conform,room_title, hostID from room_reserve_info 
                join room_info using(roomid)
                where guestID = '$myusername' and conform = '1'";
        include "menu_con.php";
    ?>

	<script>
	$("#log").click(function(){logout();});
	</script>

	<!--center-->
	<div class="container">
		<div class="container">
		<table sytle = "margin: auto; text-align: center">
			<caption style="font-weight: bold; font-size: 160%; padding: 5px"><?php echo $myusername?>'s Completed Reservation</caption>
			<tbody>
				<tr>
					<th>Date</th>
					<th>Name</th>
					<th>Owner</th>
				</tr>
				<?php
                $stmt = mysqli_stmt_init($conn);
                if($stmt = mysqli_prepare($conn, $sql)){
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $rid, $sdate, $edate, $resn, $stat, $rname, $host);
        
                    while (mysqli_stmt_fetch($stmt)) {
				?>
				<form>
				<td> <?php $sdate ?> ~ <?php $edate ?></td><td> 
				<a href = "RoomInfo.php?rid=<?php $rid?>" style = "font-decoration : none;" 
				onmouseover="this.style.color='gray'" onmouseout="this.style.color='black'"><?php $rname ?></a></td> 
				<td> <?php $host?></td>
				</tr>
				</form>
				<?php
				}
    }
}
		else {
            include "menu_sup.php";
			//get not replied reserve info 
			$sql = "select a.RoomId,b.StartDate,b.EndDate,b.reserveNum, a.room_title, b.guestID from room_info a, room_reserve_info b where a.hostID = '$myusername' AND a.RoomID = b.RoomID AND b.conform = '1'";
		?>
	<script>
	$("#log").click(function(){logout();});
	</script>

	<!--center-->
	<form>
		<div class="container">
			<table>
				<caption style="font-weight: bold; font-size: 160%; padding: 5px"><?php echo $myusername?>'s History</caption>
				<tread>
				<tr>
					<th>Date</th>
					<th>Room Title</th>
					<th>Consumer</th>
				</tr>
				</tread>
				<tbody>
					<tr>
					<?php
                    
                    $stmt = mysqli_stmt_init($conn);
                    if($stmt = mysqli_prepare($conn, $sql)){
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $rid, $sdate, $edate, $resn, $title, $cid);
            
                        while (mysqli_stmt_fetch($stmt)) {
				    ?>
				
				<td> <?php echo $sdate ?> ~ <?php echo $edate ?></td><td> 
				<a href = "RoomInfo.php?rid=<?php echo $rid; ?>" style = "font-decoration : none;" 
				onmouseover="this.style.color='gray'" onmouseout="this.style.color='black'"><?php echo $title; ?></a></td> 
				<td><?php echo $cid; ?></td> 
				</tr>
				<?php
			        	}
                    }
                }
					?>
			

				</tbody>
			</table>
		</div>
	</form>
</body>

</html>