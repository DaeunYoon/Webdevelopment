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
        include '../model/session.php';

        //get reservation info
        $sql = "select RoomId, StartDate, EndDate, reserveNum, conform, room_title from room_reserve_info 
                join room_info using(RoomID) 
                where guestID = '$myusername' 
                order by StartDate";
		$stmt = mysqli_stmt_init($conn);
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $rid, $sdate, $edate, $resn, $stat, $rname);
	?>

	<!--header-->
    <?php include "menu_con.php"; ?>
	
	<script>
	$("#log").click(function(){logout();})
	</script>
	
	<!--center-->
	<div class="container">
		<div class="container">
		<table sytle = "margin: auto; text-align: center">
			<caption style="font-weight: bold; font-size: 160%; padding: 5px"><?php echo $myusername ?>'s Reservation</caption>
			<tbody>
				<tr>
					<th>Date</th>
					<th>Room</th>
					<th>State</th>
					<th>Cancel</th>
				</tr>
			<?php
            while(mysqli_stmt_fetch($stmt)) {		
			?>
				<td> <?php echo $sdate ?> ~ <?php echo $edate ?></td>
				<td> <a href = "RoomInfo.php?rid=<?php echo $rid?>" style = "font-decoration : none;" 
				onmouseover="this.style.color='gray'" onmouseout="this.style.color='black'"><?php echo $rname ?></a></td> 
                <td>
                <?php 
                    if($stat == 0) echo 'Registered';
                    else if ($stat == 2) echo 'Denied';
                ?>
                </td>
				<td>
				<a href = "../controller/AppCancleManager.php?rnum=<?php echo $resn ?>" style = "color : red">Cancel</a>
                </td>
				</tr>
				<?php
                }
            } 
			    ?>
				
			</tbody>
		</table>
		</div>
	</div>

</body>


</html>