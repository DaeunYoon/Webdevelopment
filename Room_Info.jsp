<%@page import="java.sql.*"%>
<%@page import="java.util.ArrayList"%>
<%@page import="login.LoginManager"%>
<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%
	LoginManager loginManager = LoginManager.getInstance();
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
	setTimeout('expireSession()', <%=request.getSession().getMaxInactiveInterval() * 60%>);
</script>

<title>RoomShare</title>
</head>

<body onload="setdate()">

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

		String title = null, host = null, addr = null, cont = null;
		int price = 0, broom = 0, kit = 0, inter = 0, park = 0, max = 0;
		double score = 0;

		String rid = request.getParameter("rid");

		String sql = "select state from account where id = '" + Id + "'";
		Statement stmt = null;
		stmt = con.createStatement();
		ResultSet rs = null;
		rs = stmt.executeQuery(sql);

		int st = 0;
		if (rs.next())
			st = rs.getInt("state");
		sql = "select r.RoomID, r.room_title, r.hostID, r.cost, r.add1, r.add2, r.add3, r.add4, r.max_p, a.evaluation from room_info r, account a where r.roomid = '"+rid+"' AND a.ID = r.hostID order by room_title";	
		stmt = con.createStatement();
		rs = stmt.executeQuery(sql);

		System.out.println(sql);
		if (rs.next()) {
			title = rs.getString("room_title");
			host = rs.getString("hostID");
			for (int i = 1; i < 5; i++)
				if (i == 1)
					addr = rs.getString("add" + i) + " ";
				else
					addr += rs.getString("add" + i) + " ";
			price = rs.getInt("cost");
			score = rs.getDouble("evaluation");
			max = rs.getInt("max_p");

		}

		sql = "select * from room_option where roomid = '" + rid + "'";
		stmt = con.createStatement();
		rs = stmt.executeQuery(sql);

		if (rs.next()) {
			broom = rs.getInt("BedNumber");
			kit = rs.getInt("Kitchen");
			inter = rs.getInt("internet");
			park = rs.getInt("parking");
			cont = rs.getString("content");
		}
		if (rs.next()) {
			title = rs.getString("room_title");
			host = rs.getString("hostID");
			for (int i = 1; i < 5; i++)
				if (i == 1)
					addr = rs.getString("add" + i) + " ";
				else
					addr += rs.getString("add" + i) + " ";
			price = rs.getInt("cost");
			score = rs.getDouble("roomscore");

		}
		
				
		if (st == 1) {
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
	<div class="container">
		<div class="contents">

			<div class="room_info_contents"
				style="margin-top: 24px; box-sizing: border-box; overflow: hidden;">
				<div class="roon_info_contents_left"
					style="margin: auto; text-align: center">
					<div style="font-size: 24px">
						<strong><%=title%></strong>
					</div>

					<div
						style="font-size: 12px; border-bottom: 1px solid #c2c2c2; padding-bottom: 4px;">
						<a href="Look_Acco.jsp?uid=<%=host%>"
							style="font-decoration: none;"
							onmouseover="this.style.color='gray'"
							onmouseout="this.style.color='black'"><%=host%></a>
					</div>

					<div style="margin-top: 24px;">
						최대 인원
						<%=max%>
						명
					</div>

					<div style="margin-top: 24px;"><%=addr%></div>

					<div style="margin-top: 24px">
						기타정보 <br>
						<div>
							내용 :
							<%=cont%></div>
						<span>침실수 : <%=broom%></span> <span>부엌</span>
						<%
							if (kit == 1)
								out.println("O");
							else
								out.println("X");
						%>
						<span>인터넷</span>
						<%
							if (inter == 1)
								out.println("O");
							else
								out.println("X");
						%>
						<span>주차장</span>
						<%
							if (park == 1)
								out.println("O");
							else
								out.println("X");
						%>

					</div>
				</div>

				<div style="width: 100%; box-sizing: border-box; padding: 16px;">
					<div style="margin: auto; text-align: center">
						<span style="font-size: 24px;"><strong><%=price%>원</strong></span>
						<span>/박</span>
					</div>
					<div style="margin: auto; text-align: center;">
						<%=score%>
						/ 10
					</div>
				</div>

				<%
					if (st == 1) {
				%>
				<form action="Res_Update.jsp" method="post" onsubmit="checkdate()">
					
					
					<fieldset class="roon_info_contents_right" style="">
						<div>
							<input type="hidden" value="<%=rid%>" name="rid"> 게스트 
							<select name="people">
								<%
									for (int i = 1; i <= max; i++)
											out.println("<option value = '" + i + "'>" + i + "</option>");
								%>
							</select> 
							<br> <br>
						</div>

						<div>
						<input type="text" name="in" id="in" maxlength="10" size="10" readonly required>
								~
						<input type="text" name="out" id="out" maxlength="10" size="10" readonly required>
						
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
						
						
						</div>

						<div style="margin: auto; text-align: center">
							<button style="width: 50%; margin: auto;" type="submit">예약요청</button>
						</div>

					</fieldset>
				</form>
				<%
					}
				%>

</body>


</html>