<%@page import="java.sql.*"%>
<%@page import="login.LoginManager"%>
<% LoginManager loginManager = LoginManager.getInstance(); %>
<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/style1.css" rel="stylesheet" type="text/css">
<link href="css/sup_style.css" rel="stylesheet" type="text/css">
<script src="jquery_function.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script>
	function expireSession()
	{
		alert("로그인 시간이 만료되었습니다. 다시 로그인해주세요");
		location.href = "Login.jsp";
		session.invalidate();
	}
	setTimeout('expireSession()', <%= request.getSession().getMaxInactiveInterval() * 60 %>);
</script>
<title>RoomShare</title>
</head>
<body>

	<%
	//get ID value
			if (!loginManager.isLogin(session.getId())) {
				throw new Exception("");
			} //세션 아이디가 로그인아니면
			String Id = null; //initializie to 0
			Id = (String) session.getAttribute("ID");
			/*db connection*/
			Class.forName("com.mysql.jdbc.Driver");
			Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/mydb?serverTimezone=UTC", "root",
					"daeun1234");

			String sql = "select PW,state from account where id = '" + Id + "'";
			Statement stmt = null;
			stmt = con.createStatement();
			ResultSet rs = null;
			rs = stmt.executeQuery(sql);

			String pw = null;

			int st = 0;

			if (rs.next()) {
				pw = rs.getString("PW");
				st = rs.getInt("state");
			}
			
			if(st == 1) {
	%>

	<!--header-->
	<div class="header">
		<a href="Main.jsp"><h1 style="color: black;">Room&nbsp;Share</h1></a>
		<div class="menu">
			<span id="log">Logout</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span><a href="Con_Appo.jsp">Registered Reservation</a></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span><a href="App_History.jsp">Completed Reservation</a></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span><a href="Info_Manage.jsp">Personal Information</a></span>
		</div>
	</div>
	<%
			}
			else {
	%>
	<div class="header">
		<a href="Main.jsp"><h1 style="color: black;">Room&nbsp;Share</h1></a>
		<div class="menu">
			<span id="log">Logout</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><a
				href="Sup_New_Posting.jsp">Posting</a></span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><a
				href="App_History.jsp">History</a></span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><a
				href="Info_Manage.jsp">Personal Information</a></span>
		</div>
	</div>
	<%
			}
	%>
	<script>
	$("#log").click(function(){logout();})
	</script>

<!--center-->
	<form action="Info_process.jsp" method="post">
		<fieldset>
			<h3>Information Management</h3>
			<div>			
				<p>
					New PW 
					<input type="password" id="PW" name="PW" required> 
					PW Check
					<input type="password" id="PWch" name="db_PWch" required>
				</p>
				<button class="btn" type="button" id ="pwch">Check PW</button>
				<button class="btn" type="submit" id = "sub">Submit</button>
				</p>
			</div>
		</fieldset>
	</form>
	<script>
	var ch = 0;
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
			if(ch == 0) {
				alert('Please Click PW check button'); 
				return false;
			}
		}
		catch(err){alert('err='+err)}
		
	});
	</script>
	
	
	<%
		rs.close();
		stmt.close();
		con.close();
	%>


</body>
