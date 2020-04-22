<?php
   include("../model/Config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
	   
      // username and password sent from form 
      $myusername = mysqli_real_escape_string($conn,$_POST['id']);
      $mypassword = mysqli_real_escape_string($conn,$_POST['pw']); 

      $stmt = mysqli_stmt_init($conn);
      $sql = "SELECT state FROM account WHERE id = '$myusername' and pw = '$mypassword'";
      
      if ($stmt = mysqli_prepare($conn, $sql)) 
		{
			// initialise connection
			mysqli_stmt_execute($stmt);

			// bind the results to their own variables
			mysqli_stmt_bind_result($stmt, $result);                
         
         while ($st = mysqli_stmt_fetch($stmt))
         {
           if ($st == 1)
             break;
         }         
         // If result matched $myusername and $mypassword, table row must be 1 row
         if($st == 1) {
            $_SESSION['login_user'] = $myusername;
            $_SESSION['state'] = $result;
            header("location: /project/view/Main.php");
         }
         else {
            $error = "Your Login Name or Password is invalid";
            echo "<script type='text/javascript'>alert('$error');</script>";
            header("location: /project/view/Login.php");
         }
      }
   }

   mysqli_close($conn);
?>
