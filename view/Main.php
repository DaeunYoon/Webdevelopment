<?php
    include '../model/session.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="jquery_function.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<link href="css/style1.css" rel="stylesheet" type="text/css">
<link href="css/sup_style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script>	
	function searchCheck(frm){
        //검색
        if(frm.keyWord.value ==""){
            alert("검색 단어를 입력하세요.");
            frm.keyWord.focus();
            return;
        }
        frm.submit();      
    }
</script>
<title>RoomShare</title>
</head>
<body>

<!-- Connect with DB -->
    <?php
        if($_SESSION['state'] === 1) {
            include 'menu_con.php';
    ?>
<!--center-->
    <div class="container">
            <div class="contents">
                <div class="search">
                    <form name="frm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <select name="sel">
                            <option value="search_date">Date</option>
                            <option value="search_person">People</option>
                            <option value="search_location">Location</option>
                        </select> 
                        <input type="text" name="word" id="word" value="" placeholder="">
                        <button type="submit" class="btn btn-outline-primary" name ="submit">Searching</button>
                    </form>
                </div>
            </div>
        </div>

        <form action="RoomInfo.php" method="post">
            <div class="room_grid">

                <div class="room_all">

                    <table>
                    <caption style="font-weight: bold; font-size: 160%; padding: 5px">Room Information</caption>
                    <tread>
                    <tr>
                        <th>title</th>
                        <th>price</th>
                        <th>supplier</th>
                        <th>Detail</th>
                    </tr>
                    </tread>
                    <tbody>
                    <?php                 
                        include '../controller/SearchManager.php';
                        while (mysqli_stmt_fetch($stmt))
                        {
                            echo "<tr><td><class='room_tit'><strong> $title </strong></td> <td><span class='roomprice'> $price
                             </span></td> <td><span class='room_host'> $host </span></td>
                             <td><button class='btn btn-secondary' type = 'submit' name = 'rid' value = $rid >detail</button></td></tr>";
                        }         
                    }  
                    ?>
                        </tbody>
                        </table>
                </div>


            </div>
        </form>

        <?php
            if($_SESSION['state'] === 0) {
                include 'menu_sup.php';

                $stmt = $conn->prepare( "select roomID from room_info where hostID=?");
                $stmt->bind_param("s", $_SESSION['login_user']);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>



   <!--center-->
   <div class="container">
      <form action = "Sup_Accp.php" method = "post">
         <table>
            <caption style="font-weight: bold; font-size: 160%; padding: 5px">Reservation Registered List</caption>
            <tbody>
               <tr>
                  <th>Room Information</th>
                  <th>Registers</th>
               </tr>
        <?php
            $arr = NULL;
            while($row = $result->fetch_object()) {
                $rid = $row->roomID;
                
                $stmt2 = $conn->prepare( "select room_title from room_info where RoomID = ?");
                $stmt2->bind_param("s", $rid);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $title = null;
                if($row2 = $result2->fetch_object()){
                    $title = $row2->room_title;
                    echo("<tr><td><a href = 'RoomInfo.php?rid=$rid' style='text-decoration:none' onmouseover=\"'this.style.color='gray'\" onmouseout=\"this.style.color='black'\">$title</a></td>");
                }
                $stmt3 = $conn->prepare( "select Count(guestID) as count from room_reserve_info where RoomID = ? and conform = '0'");
                $stmt3->bind_param("s", $rid);
                $stmt3->execute();
                $result3 = $stmt3->get_result();
                $numb = 0;
                if($row3 = $result3->fetch_object())
                    $numb = $row3->count;
                
                if($numb != 0)
                    echo("<td><button type='submit' name='rid' value='$rid' style='border: 0px; width: 30px;'>$numb</button></td></tr>");
                else
                    echo("<td>0</td></tr>");
              
            }}
            mysqli_close($conn);
        ?>   
   
            </tbody>
         </table>
      </form>       


    <script>
        $("#log").click(function(){logout();})
    </script>
        
</body>
