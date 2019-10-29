<%@page import="java.sql.*"%>
<%@page import="login.LoginManager"%>
<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%
	LoginManager loginManager = LoginManager.getInstance();
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
	td {margin: auto; text-align: center}
</style>
<script src="jquery_function.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/style1.css" rel="stylesheet" type="text/css">
<link href="css/sup_style.css" rel="stylesheet" type="text/css">

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
		
		//get not replied reserve info 
		String sql = "select RoomId,StartDate,EndDate,reserveNum,conform from room_reserve_info where guestID = '" + Id +"' and conform = '0' order by StartDate";
		Statement st = null;
		st = con.createStatement();
		ResultSet rs = st.executeQuery(sql);
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
	
	<script>
	$("#log").click(function(){logout();})
	</script>
	
	<!--center-->
	<div class="container">
		<div class="container">
		<table sytle = "margin: auto; text-align: center">
			<caption style="font-weight: bold; font-size: 160%; padding: 5px"><%=Id %> 님의 신청내역</caption>
			<tbody>
				<tr>
					<th>날짜</th>
					<th>방이름</th>
					<th>예약상태</th>
					<th>취소</th>
				</tr>
			<%
				while(rs.next()) {
					String rid = rs.getString(1);
					String sdate = rs.getString(2);
					String edate = rs.getString(3);
					String resn = rs.getString(4);
					int stat = rs.getInt(5); //reserve state
					
					String sql2 = "select room_title from room_info where RoomID ='" +rid+"'";
					Statement st2 = con.createStatement();
					ResultSet rs2 = st2.executeQuery(sql2);
					rs2 = st2.executeQuery(sql2);
					
					String rname = null;
				//get room title
				if(rs2.next())
					rname = rs2.getString(1);
				rs2.close();
				st2.close();
				%>
				<td> <%=sdate %> ~ <%=edate %></td>
				<td> <a href = "Room_Info.jsp?rid=<%=rid%>" style = "font-decoration : none;" 
				onmouseover="this.style.color='gray'" onmouseout="this.style.color='black'"><%=rname%></a></td> 
				<td>예약 대기중	</td>
				<td>
				<a href = "App_Cancle.jsp?rnum=<%=resn%>" style = "color : red">예약취소</a>
				</tr>
				<%
				}
				
				//get denied reserve info 
				sql = "select RoomId,StartDate,EndDate,reserveNum,conform from room_reserve_info where guestID = '" + Id +"' and conform = '2'";
				st = null;
				st = con.createStatement();
				rs = st.executeQuery(sql);
				
				while(rs.next()) {
					String rid = rs.getString(1);
					String sdate = rs.getString(2);
					String edate = rs.getString(3);
					String resn = rs.getString(4);
					int stat = rs.getInt(5); //reserve state
					
					String sql2 = "select room_title from room_info where RoomID ='" +rid+"'";
					Statement st2 = con.createStatement();
					ResultSet rs2 = st2.executeQuery(sql2);
					rs2 = st2.executeQuery(sql);

					String rname = null;
					
					//get room title
					if(rs2.next())
						rname = rs2.getString(1);
					rs2.close();
					st2.close();
					
					%>
					<td> <%=sdate %> ~ <%=edate %></td><td> <a href = "Room_Info.jsp?uid=<%=rid%>" style = "font-decoration : none;" 
					onmouseover="this.style.color='gray'" onmouseout="this.style.color='black'"><%=rname%></a></td> 
					<td>거절</td>
					<td>
					<a href = "App_Cancle.jsp?rnum=<%=resn%>" style = "color : red">예약취소</a>
					</tr>
				<%
				} 
				%>
				
			</tbody>
		</table>
		</div>
	</div>

</body>


</html>