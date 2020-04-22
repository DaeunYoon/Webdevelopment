<?php
    include '../controller/RoomInfoManager.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/style1.css" rel="stylesheet" type="text/css">
<link href="css/sup_style.css" rel="stylesheet" type="text/css">
<script src="jquery_function.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<title>RoomShare</title>
</head>
<body>
<?php
        if($_SESSION['state'] === 1) {
            include 'menu_con.php';
        }else{
            include 'menu_sup.php';
        }
?>
<script>
   $("#log").click(function(){logout();});
   $(document).ready(function(){
    $("#roomimg").delay(1000).animate({width:'70%', height:'100%'}, 3000);
   })
</script>
<!--center-->
<div class="container">
      <div class="contents">
         <div class="room_info_contents"
            style="margin-top: 24px; box-sizing: border-box; overflow: hidden;">
            <div class="roon_info_contents_left"
               style="margin: auto; text-align: center">
               <div style="font-size: 24px">
                  <strong><?php echo $title; ?></strong>
               </div>

               <div
                  style="font-size: 12px; border-bottom: 1px solid #c2c2c2; padding-bottom: 4px;">
                  <a href="Look_Acco.php?uid=<%=host%>"
                     style="font-decoration: none;"
                     onmouseover="this.style.color='gray'"
                     onmouseout="this.style.color='black'"><?php echo $host; ?></a>
               </div>

                <div style="width: 100%; height:300px; overflow: scroll;">
                    <img id="roomimg" style="width: 100%; height:auto;" src="../uploads/<?php echo $imgurl;?>" alt="roomImg">
                </div>

               <div style="margin-top: 24px;">
                  max people
                  <?php echo $max; ?>
                  
               </div>

               <div style="margin-top: 24px;"><?php echo $addr; ?></div>

               <div style="margin-top: 24px">
                  amenities <br>
                  <div>
                     contents :
                     <?php $cont ?></div>
                  <span>bedroom : <?php echo $broom; ?></span> <span>kitchen</span>
                  <?php
                     if ($kit == 1)
                        echo "O";
                     else
                        echo "X";
                  ?>
                  <span>internet</span>
                  <?php
                     if ($inter == 1)
                        echo "O";
                     else
                        echo "X";
                  ?>
                  <span>parking</span>
                  <?php
                     if ($park == 1)
                        echo "O";
                     else
                        echo "X";
                  ?>

               </div>
            </div>

            <div style="width: 100%; box-sizing: border-box; padding: 16px;">
               <div style="margin: auto; text-align: center">
                  <span style="font-size: 24px;"><strong>€<?php echo $price ?></strong></span>
                  <span>/day</span>
               </div>
               
            </div>

            <?php
               if ($_SESSION['state'] === 1) {
            ?>
            <form action="../controller/ReservUpdateManager.php" method="post" onsubmit="checkdate()">
               <fieldset class="roon_info_contents_right" style="">
                  <div>
                     <input type="hidden" value="<?php echo $rid; ?>" name="rid">guest 
                     <select name="people">
                        <?php
                           for ($i = 1; $i <= $max; $i++)
                              echo("<option value = '".$i ."'>".$i."</option>");
                        ?>
                     </select> 
                     <br> <br>
                  </div>

                  <div>
                  <input type="text" name="in" id="in" maxlength="10" size="10" readonly required>
                        ~
                  <input type="text" name="out" id="out" maxlength="10" size="10" readonly required>
                  
                  <script>
						$(function(){
					        $("#out").datepicker({ dateFormat: 'yy-mm-dd' });
					        
					        $("#in").datepicker({ dateFormat: 'yy-mm-dd', minDate: +0 }).bind("change",function(){
					            var minValue = $(this).val();
					            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
					            minValue.setDate(minValue.getDate()+1);
					            $("#out").datepicker( "option", "minDate", minValue );
					        });
					        
					        $("#out").click(function(){
								try{
									if($( "#in" ).datepicker("getDate")){
									}
									else{
										alert("Select check-in date first");
										$( "#in" ).datepicker("option", "showAnim", "slideDown")
									}
								}
								catch(err){alert('err='+err)}
							});
					        
					    });
						</script>
						
                  </div>
                  <div style="margin: auto; text-align: center">
                     <button style="width: 50%; margin: auto;" type="submit" name ="submit">reservation request</button>
                  </div>
               </fieldset>
            </form>
            <?php
               }
               else{
                  ?>
                  <a href="../controller/RoomUpdateManager.php?type=0&rid=<?php echo $rid;?>">Edit</a>&nbsp;/
                  <a href="../controller/RoomUpdateManager.php?type=1&rid=<?php echo $rid;?>">Delete</a>
                  <?php
               }
            ?>

</body>
</html>
