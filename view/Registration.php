<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script src="jquery_function.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/style1.css" rel="stylesheet" type="text/css">
<script src="../public/jquery_function.js"></script>
<title>RoomShare</title>
</head>
<body>

	<!--header-->
	<div class="header">
		<h1>Room&nbsp;Share</h1>
		<h2 style="align-content: center;">JOIN US</h2>
	</div>

	<!--center-->
	<div class="container">
		<form action="../controller/AuthManager.php" method="post" name="userInsertForm" id="UserIn">
			<fieldset>
				<h3>Join</h3>
				<div>
					<p>
						<input type="hidden" id="ns" name="ns" value="0"> 
						<input type="text" id="ID" name="ID" placeholder="ID (email)" required>
						<button class="btn" type="button" id="emailch">Email check</button>
						<input type="password" id="PW" name="PW" placeholder="PW" maxlength="15" required> 
						<input type="password" id="PWch" name="PWch" maxlength="15" placeholder="PW CHECK" required>
					</p>
					<button class="btn" type="button" id = "pwch">PW check</button>
					<p>
						<input type="text" id="name" name="name" placeholder="NAME" maxlength="15" required>
					</p>
					<p>
						<input type="text" name="addr1" id="addr1" placeholder="ADDR1" required>
					</p>
					<p>
						<input type="text" name="addr2" id="addr2" placeholder="ADDR2" required>
					</p>
					<p>
						<input type="text" name="city" id="city" placeholder="CITY" required>
					</p>
					<p>
						<input type="tel" name="tel" id="tel" placeholder="TELEPHONE NUM" required>
					</p>
					
					<br>
					<p>
						<input type="radio" name="type" id="con" value="1">consumer<br>
						<input type="radio" name="type" id="sup" value="0">supplier<br>
					</p>
					<br>
					<p>
						<button class="btn" type="submit" id="sub">Input</button>
					</p>
				</div>
			</fieldset>

			<script>
			var ch = 0;
			$('#emailch').click(function() {
		
				try{
					if($('#ID').val()){
						ch_email();
					}
					else{
						alert('Input Email');
					}

					
				}
				catch(err){alert('err='+err)}
				
			});
			
			$('#pwch').click(function() {
				
				try{
					if($('#PW').val() && $('#PWch').val()){
						if(checkpw()){
							ch = 1;
						}
						else {
							ch = 0;
						}
					}
					else{
						ch = 0;
						alert('Input PW and PW check');
					}
					
				}
				catch(err){alert('err='+err)}
				
			});
			
			$('#sub').click(function() {
				
				try{
					if(ch == 0){
						alert('Please click PW check button');
						return false;
					}
					if(!validateForm()){
						return false;
					}
					else{
						$('#UserIn').submit();
					}
					
				}
				catch(err){alert('err='+err)}
				
			});
			</script>
		</form>
	</div>
</html>
