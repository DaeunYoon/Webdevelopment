<%@page import="java.sql.Connection"%>
<%@page import="java.sql.DriverManager"%>
<%@page import="login.LoginManager"%>
<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
	<% LoginManager loginManager = LoginManager.getInstance(); %>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/style1.css" rel="stylesheet" type="text/css">
<link href="css/sup_style.css" rel="stylesheet" type="text/css">
<script src="jquery_function.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
<script>
	function expireSession()
	{
		alert("로그인 시간이 만료되었습니다. 다시 로그인해주세요");
		location.href = "logout.jsp";
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
	%>

	<!--header-->
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

	<script>
	$("#log").click(function(){logout();})
	</script>
	
	<!--center-->
	<form action = "Update.jsp" method = "post" id ="posting">
		<div class="container">
			<table>
				<thead>
				<caption>Posting</caption>
				</thead>
				<tbody>
					<tr>
						<th>title :</th>
						<td><input type="text" placeholder="Input the title "
							name="title" required /></td>
					</tr>
						<tr>
						<th>Contents :</th>
						<td><textarea class="noresize" cols=70 rows=20
								placeholder="Input the contents. " name="cont" require></textarea></td>
					</tr>
					<tr>
						<th>Address :</th>
						<td>
							addr1 <input type="text" placeholder="Input Street addr1 " name="adr1" id = "addr1" required />
							addr2 <input type="text" placeholder="Input Street addr2 " name="adr2" id = "addr2" required />
							city <input type="text" placeholder="Input City Name " name="adr3" id = "city" required />
							zip <input type="text" placeholder="Input ZipCode " name="adr4" id = "zip" required />
						</td>
					</tr>
					<tr>
						<th>People :</th>
						<td>
							<input type="text" placeholder="최대 수용인원을 입력하세요. " name="max" id = "max" required />
						</td>
					</tr>
					<tr>
						<th>Bedrooms :</th>
						<td>
							<input type="text" placeholder="침실수를 입력하세요. " name="bedroom" id="bedroom" required />
						</td>
					</tr>
					<tr>
						<th>Kitchen :</th>
						<td>YES<input type="radio" name="kitchen" value = "1" required />
						NO<input type="radio" name="kitchen" value = "0" required /></td>
						
					</tr>
					<tr>
						<th>Internet :</th>
						<td>YES<input type="radio" name="internet" value = "1" required />
						NO<input type="radio" name="internet" value = "0" required /></td>
					</tr>
					<tr>
						<th>Parking area :</th>
						<td>YES<input type="radio" name="parking" value = "1" required />
						NO<input type="radio" name="parking" value = "0" required /></td>
					</tr>
					<tr>
						<th>Rent Duration :</th>
						<td class = "date">
						<input type="text" name="start_date" id="in" maxlength="10" size="10" 
							 readonly required>
								~
						<input type="text" name="end_date" id="out" maxlength="10" size="10"
							 readonly required>
						
						<script>
						
						$(function(){
					        $("#out").datepicker({ dateFormat: 'yy-mm-dd' });
					        
					        $("#in").datepicker({ dateFormat: 'yy-mm-dd', minDate: +0 }).bind("change",function(){
					            var minValue = $(this).val();
					            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
					            minValue.setDate(minValue.getDate()+1);
					            $("#out").datepicker( "option", "minDate", minValue );
					        });
					        
					        $("#out").click(function(){
								try{
									if($( "#in" ).datepicker("getDate")){
									}
									else{
										alert("Select check-in date first");
										$( "#in" ).datepicker("option", "showAnim", "slideDown")
									}
								}
								catch(err){alert('err='+err)}
							});
					        
					    });
						
							
						</script>
						
						</td>
					</tr>
					<tr>
						<th>일박요금 :</th>
						<td ><input type="text" placeholder="Input the price for one night " name="price" id="price" /></td>
					</tr>
					<tr style="margin:auto; text-align:center;">
						<td colspan="2">
						<button type="submit" id ="sub"> Submit </button></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	
<script>
	$("#sub").click(function(){
		try{
			if(isValidPost()) {
				$("#posting").submit();
				return true;
			}
			else {
				return false;
			}
		}
		catch(err){alert('err='+err)}
	})
</script>
</body>

</html>