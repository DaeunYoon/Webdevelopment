<?php
   include('Config.php');
   session_start();
   
   $myusername = $_SESSION['login_user'];

   if(!isset($_SESSION['login_user'])){
      header("location: /Applications/XAMPP/xamppfiles/htdocs/project/view/Login.php");
   }
?>