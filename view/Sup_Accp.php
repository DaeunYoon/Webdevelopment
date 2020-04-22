<?php include "../model/session.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/sup_style.css" rel="stylesheet" type="text/css">
<script src="jquery_function.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<title>RoomShare</title>

<script>

	function expireSession()
	{
		alert("로그인 시간이 만료되었습니다. 다시 로그인해주세요");
		location.href = "logout.jsp";
		session.invalidate();
	}
	setTimeout('expireSession()', <%= request.getSession().getMaxInactiveInterval() * 60 %>);
</script>


</head>
<body>

	<?php
		$rid = $_POST["rid"];
		
		$rname = "";
		$sql = "select room_title from room_info where RoomID ='$rid'";
		if($stmt = $conn->prepare($sql)){
            //$stmt->bind_param("is", $rid, $_SESSION['login_user']);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if($row = $result->fetch_object()) {
                $rname = $row->room_title;
            }
        }
		//get reserve info
		$sql = "select guestID,StartDate,EndDate,reserveNum from room_reserve_info where RoomId = '$rid' and conform = '0'";
		
        include "menu_sup.php";
	?>

	<script>
	$("#log").click(function(){logout();})
	</script>

	<!--center-->
	<div class="container">
		<table>
			<caption style="font-weight: bold; font-size: 160%; padding: 5px"><?php echo $rname ?>
				Resigtered List</caption>
			<tbody>
				<tr>
					<th>Date</th>
					<th>Customer</th>
					<th>Accp/Deny</th>
				</tr>
				<?php
                if($stmt = $conn->prepare($sql)){
                    //$stmt->bind_param("is", $rid, $_SESSION['login_user']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();
                    while($row = $result->fetch_object()) {
                        $guestID = $row->guestID;
                        $sdate = $row->StartDate;
                        $edate = $row->EndDate;
                        $resn = $row->reserveNum;
				
				?>
				<td> <?php echo $sdate ?> ~ <?php echo $edate ?></td>
				<td> <?php echo $guestID ?></a>
						</td> 
						<td>
						
						<a href = "../controller/Res_yes.php?rnum=<?php echo $resn ?>" style = "font-decoration : none; background-color : blue; color:white;">Accept</a> 
						<a href = "../controller/Res_no.php?rnum=<?php echo $resn ?>" style = "font-decoration : none; background-color : red; color:white;">Deny</a>
				</td>
				</tr>
				<?php
				}
                }
				?>
				
			</tbody>
		</table>

	</div>

</body>

</html>