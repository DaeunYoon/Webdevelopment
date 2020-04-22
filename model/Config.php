<?php
   $DB_SERVER = 'localhost';
   $DB_USERNAME = 'kim';
   $DB_PASSWORD = '1234';
   $DB_DATABASE = 'roomshare';

   $conn = new mysqli($DB_SERVER,$DB_USERNAME,$DB_PASSWORD);

   if ($conn-> connect_error) {
      die("Coneection failed: " . $conn->connect_error);
   }

   $sql = "Use roomshare";
   if(mysqli_query($conn, $sql)) {
      //echo "Database changed successfully";
   }
   else {
      echo "Error changing database: " . mysqli_error($conn);
   }

?>