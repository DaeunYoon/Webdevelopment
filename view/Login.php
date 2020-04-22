<?php
	//session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="css/style1.css" rel="stylesheet" type="text/css">
		<script src="jquery_function.js"></script>
		<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
		<title>RoomShare</title>
	</head>

<body>
	<!--header-->
	<div class="header">
		<h1>Room&nbsp;Share</h1>
		<h2 style="align-content: center;">MEMBERSHIP</h2>
	</div>

	<div class="container">
		<form action="/project/controller/LoginManager.php" method="post" id="loginInfo">
			<fieldset>
				<h3>login</h3>

				<div>
					<input type="text" placeholder="ID" name="id" id="id"> 
					<input type="password" placeholder="PW" name="pw" id="pw" maxlength = "15">
					<button type="submit" class="btn" id = "login">login</button>
					<button onclick="location.href='Registration.php'" type="button" class="btn" name = "login_user">join us</button>
				</div>
				
				<script>
					$('#login').click(function() {
				
						try{
							if($('#id').val() == '' || $('#pw').val() == ''){
								alert('Input ID and PW');
								return false;
							}
							else{
								$( "#loginInfo" ).submit();
							}
						}
						catch(err){alert('err='+err)}
						
					});
				</script>
				
			</fieldset>
		</form>
	</div>
		
</body>

</html>