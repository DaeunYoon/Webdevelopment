<?php
error_reporting(E_ALL);
ini_set("display_errors", '1');

   include("../model/Config.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form
    try {
    $stmt = $conn->prepare("select * from account where id = ?");
    $stmt->bind_param("s", $_POST['ID']);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows !== 0 ) exit('Already registered!');

    try {
        $conn->autocommit(FALSE); //turn on transactions
        $stmt = $conn->prepare("INSERT INTO Account (ID, PW, Username, state, PhoneNumber) Values (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $_POST['ID'], $_POST['PW'], $_POST['name'], $_POST['type'], $_POST['tel']);
        $stmt->execute();
        $stmt->close();
        $conn->autocommit(TRUE);
        header("location: /project/view/Login.php");
    } catch(Exception $e) {
        $conn->rollback(); //remove all queries from queue if error (undo)
        throw $e;
    }  
    } catch (Exception $e) {
        error_log($e);
        exit('Error message for user to understand');
      }
}
