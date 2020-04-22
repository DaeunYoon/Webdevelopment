<?php     
include '../model/session.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/style1.css" rel="stylesheet" type="text/css">
<link href="css/sup_style.css" rel="stylesheet" type="text/css">
<script src="jquery_function.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<title>RoomShare</title>
</head>
<body>

	<?php
        $stmt = mysqli_stmt_init($conn);
        $rid = $_POST["rid"];
		$ind = $_POST["in"];
		$outd = $_POST["out"];
        
		$sql = "Select StartDate,EndDate from room_reserve_info where RoomID = '$rid'";
        
        if ($stmt = mysqli_prepare($conn, $sql)) 
        {
            // initialise connection
            mysqli_stmt_execute($stmt);
            // bind the results to their own variables
            mysqli_stmt_bind_result($stmt, $chin, $chout);
        		/*예약된 날짜 추가*/

            while (mysqli_stmt_fetch($stmt))
            {
                /*예약된 날짜*/
                $cin = preg_split("/[- ]+/", chin);
                $cout = preg_split("/[- ]+/", chout);
                /*예약할날짜*/
                $rin = preg_split("/[- ]+/", ind);
                $rout = preg_split("/[- ]+/", outd);

                echo $chin;
                /*날짜 검사*/
                /*check out 날짜검사*/
                $ch = 0;
                if (intval(cin[0]) < intval(rout[0])) {
                    $ch = 1; //예약된 날짜가 더 큼
                }
                else if(intval(cin[0]) == intval(rout[0])) {
                    if (intval(cin[1]) < intval(rout[1])) {
                        $ch = 1;
                    } 
                    else if (intval(cin[1]) == intval(rout[1])) {
                        if (intval(cin[2]) < intval(rout[2])) {
                            $ch = 1;
                        } 
                        else if (intval(cin[2]) == intval(rout[2])) {
                            $ch = 0;
                        }
                        else {
                            $ch = 2;
                        }
                    } 
                    else {
                            $ch = 2; //예약할 날짜가 더 큼
                    }
                } 
                else {
                    $ch = 2; //예약할 날짜가 더 큼
                }
                

                if (intval(cin[0]) < intval(rin[0])) {
                    //ok
                } 
                else {
                    if (intval(cin[0]) == intval(rin[0])) {
                        if (intval(cin[1]) < intval(rin[1])) {
                            //ok
                        } 
                        else {
                            if (intval(cin[1]) == intval(rin[1])) {
                                if (intval(cin[2]) > intval(rin[2])) {
                                    //ok
                                } else if (intval(cin[2]) == intval(rin[2])) {
                                    //체크인 날짜가 같은 경우
                                    echo "<script>alert('Already Booked in the day.'); location.href ='../view/RoomInfo.php?rid=$rid'; </script>";
                                    return;
                                } else {
                                    //체크아웃 검사해야함 (예약된 체크인 일 < 예약할 체크인 일)
                                    if($ch == 2 || $ch == 0){
                                    //ok	
                                    }
                                    else{
                                        echo "<script>alert('Already Booked in the day.'); location.href ='../view/RoomInfo.php?rid=$rid'; </script>";
                                        return;
                                    }
                                }
                            } 
                            else {
                                //체크아웃 검사해야함 (예약된 체크인 월 < 예약할 체크인 월 )
                                if($ch == 2 || $ch == 0){
                                //ok	
                                }
                                else{
                                    echo "<script>alert('Already Booked in the day.'); location.href ='../view/RoomInfo.php?rid=$rid'; </script>";
                                    return;
                                }
                            }
                        }
                    }

                }

            }
        }

        $sql = "SELECT MAX(reserveNum) from room_reserve_info";

        $stmt = mysqli_stmt_init($conn);
        if($stmt = mysqli_prepare($conn, $sql)){
            
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $result);

            echo $result;
            if(mysqli_stmt_fetch($stmt)) {
                $rn = $result + 1;
            }
            else{
                $rn = 1;
            }
        }

        $stmt = mysqli_stmt_init($conn);
        $sql = "INSERT INTO room_reserve_info (`reserveNum`, `RoomID`,`StartDate`, `EndDate`, `guestID`) values ($rn,$rid,'$ind','$outd','$myusername')";
        echo $sql;
        if ($stmt = mysqli_prepare($conn, $sql)) 
        {
            mysqli_stmt_execute($stmt);
        }		
	?>

	<script>
		alert("Reservation Completed.");
        location.href = "../view/ConRegApp.php";
	</script>

</body>

</html>