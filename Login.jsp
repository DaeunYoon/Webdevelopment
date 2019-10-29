<%@page import="java.sql.Connection"%>
<%@page import="java.sql.DriverManager"%>
<%@page import="login.LoginManager"%>
<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>

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

	<%
	LoginManager loginManager = LoginManager.getInstance();
	//다른 탭에서 로그인 되어있는지 확인
	if(session.getAttribute("ID") != null)
	{
		%>
		<script>location.href = "Main.jsp";</script>
		<% 
	}
		//get ID value
		if (loginManager.isLogin(session.getId())) {
		
		} //세션 아이디가 로그인아니면
		/*db connection*/
		Class.forName("com.mysql.jdbc.Driver");
		Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/mydb?serverTimezone=UTC", "root",
				"daeun1234");
	%>

	<!--header-->
	<div class="header">
		<h1>Room&nbsp;Share</h1>
		<h2 style="align-content: center;">MEMBERSHIP</h2>
	</div>

	<!--center-->
	<div class="container">
		<form action="Login_manage.jsp" method="post" id="loginInfo">
			<fieldset>
				<h3>login</h3>

				<div>
					<input type="text" placeholder="ID" name="id" id="id"> 
					<input type="password" placeholder="PW" name="pw" id="pw" maxlength = "15">
					<button type="submit" class="btn" id = "login">login</button>
					<button onclick="location.href='Join.jsp'" type="button" class="btn">join us</button>
				</div>
				
				<!-- check the input value -->
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
</html>