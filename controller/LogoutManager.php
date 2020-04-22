<?php
    include '../model/session.php';
    session_unset();
    session_destroy();

    mysqli_close($conn);

    $msg = "We hope see you soon !";
    echo "<script type='text/javascript'>alert('$msg');</script>";
    header("location: /../project/view/Login.php");
?>