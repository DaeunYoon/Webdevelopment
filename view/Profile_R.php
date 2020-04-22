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
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>

</head>
<body>
<?php
 if($_SESSION['state'] === 1) {
    include 'menu_con.php';
 }
 else{
    include 'menu_sup.php';
 }
?>

<script>
        $("#log").click(function(){logout();})
</script>

<script>
  function createUser(str){
        if(str==""){
            document.getElementById("create").innerHTML = "";
            return;
        }
        else{
            editUser("");
            showUser("");
            delUser("");
        }
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                document.getElementById("create").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "../view/Registration.php");
        xmlhttp.send();
    }
    function showUser(str){
        if(str==""){
            document.getElementById("show").innerHTML = "";
            return;
        }
        else{
            createUser("");
            editUser("");
        }
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                document.getElementById("show").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "../controller/Profile_ajax.php?type=0");
        xmlhttp.send();
    }
    function editUser(str){
        if(str==""){
            document.getElementById("edit").innerHTML = "";
            return;
        }
        else{
            createUser("");
            showUser("");
            delUser("");
        }
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                document.getElementById("edit").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "../controller/Profile_Update.php");
        xmlhttp.send();
    }
    function delUser(str){

        if(str==""){
            document.getElementById("dele").innerHTML = "";
            return;
        }
        else{
            createUser("");
            editUser("");
        }

        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                document.getElementById("dele").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "../view/Profile_D.php");
        xmlhttp.send();

    }
</script>
<div class="row">
<?php if($_SESSION['login_user'] == "admin@admin.com") {?>
<button class="btn btn-outline-primary" onclick="createUser('hello')">create User</button>
<?php }?>
<button class="btn btn-outline-secondary" onclick="showUser('hello')">show User</button>
<button class="btn btn-outline-secondary" onclick="editUser('hello')">edit User</button>
<button class="btn btn-outline-danger" onclick="delUser('hello')">delete User</button>
</div>

<div id="create"></div>
<div id="show" style="padding:2rem;"></div>
<div id="edit"></div>
<div id="dele"></div>

</body>