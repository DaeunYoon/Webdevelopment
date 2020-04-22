<?php
  include("../model/Config.php");
  include '../model/session.php';

  if($_SESSION['login_user'] == 'admin@admin.com'){
    //show all users(admin version)
    $stmt = $conn->prepare("select * from account");
    $stmt->execute();
    $result = $stmt->get_result();
    echo "<table class='table'>
    <tr>
    <th scope='col'>ID</th>
    <th scope='col'>Username</th>
    <th scope='col'>UserType</th>
    <th scope='col'>PhoneNumber</th>
    </tr>";
    while($row = $result->fetch_object()){
        echo "<tr>";
        echo "<th scope='row'>" . $row->ID . "</td>";
        echo "<td>" . $row->Username . "</td>";
        if($row->state == 0){
            echo "<td>Owner</td>";
        }
        else{
            echo "<td>User</td>";
        }
        echo "<td>" . $row->PhoneNumber . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    $stmt->close();
  }
  else{
    //show one user
    $stmt = $conn->prepare("select * from account where id=?");
    $stmt->bind_param("s", $_SESSION['login_user']);
    $stmt->execute();
    $result = $stmt->get_result();
    echo "<table class='table'>
    <tr>
    <th scope='col'>ID</th>
    <th scope='col'>Username</th>
    <th scope='col'>UserType</th>
    <th scope='col'>PhoneNumber</th>
    </tr>";
    while($row = $result->fetch_object()){
        echo "<tr>";
        echo "<th scope='row'>" . $row->ID . "</td>";
        echo "<td>" . $row->Username . "</td>";
        if($row->state == 0){
            echo "<td>Owner</td>";
        }
        else{
            echo "<td>User</td>";
        }
        echo "<td>" . $row->PhoneNumber . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    $stmt->close();
  }