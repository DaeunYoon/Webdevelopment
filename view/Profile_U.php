

	<!--center-->
	<div class="container">
		<form action="../controller/Profile_Update.php" method="post" name="userInsertForm" id="UserIn">
			<fieldset>
				<h3>UPDATE PROFILE</h3>
				<div>
					<p>
						<input type="hidden" id="ns" name="ns" value="0"> 
						<input type="text" id="ID" name="ID" value="<?php echo $id;?>" readonly>
						<button class="btn" type="button" id="emailch">Email check</button>
						<input type="password" id="PW" name="PW" placeholder="PW" maxlength="15" required> 
						<input type="password" id="PWch" name="PWch" maxlength="15" placeholder="PW CHECK" required>
					</p>
					<button class="btn" type="button" id = "pwch">PW check</button>
					<p>
						<input type="text" id="name" name="name" placeholder="<?php echo $name;?>" maxlength="15" required>
					</p>
					<p>
						<input type="tel" name="tel" id="tel" placeholder="<?php echo $phone;?>" required>
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
