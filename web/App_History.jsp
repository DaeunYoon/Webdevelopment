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
		

		String sql = "select state from account where id = '" + Id + "'";
		Statement stmt = null;
		stmt = con.createStatement();
		ResultSet rs = null;
		rs = stmt.executeQuery(sql);
		String name = null;
		String tel = null;
		String pw = null;
		String eval = null;
		int state = 0;

		if (rs.next()) {
			state = rs.getInt(1);
		}
		System.out.println(state);
		System.out.println(sql);
		
		if(state == 1) {
		//get not replied reserve info 
		sql = "select RoomId,StartDate,EndDate,reserveNum,conform from room_reserve_info where guestID = '" + Id +"' and conform = '1'";
		Statement st = null;
		st = con.createStatement();
		rs = st.executeQuery(sql);
	
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
	$("#log").click(function(){logout();});
	</script>

	<!--center-->
	<div class="container">
		<div class="container">
		<table sytle = "margin: auto; text-align: center">
			<caption style="font-weight: bold; font-size: 160%; padding: 5px"><%=Id %> 님의 완료내역</caption>
			<tbody>
				<tr>
					<th>날짜</th>
					<th>방이름</th>
					<th>방주인</th>
					<th>별점</th>
					<th>신고하기</th>
				</tr>
				<%
				while(rs.next()) {
				String rid = rs.getString(1);
				String sdate = rs.getString(2);
				String edate = rs.getString(3);
				String resn = rs.getString(4);
				int stat = rs.getInt(5); //reserve state
				
				String sql2 = "select room_title, hostID from room_info where RoomID ='" +rid+"'";
				Statement st2 = con.createStatement();
				ResultSet rs2 = st2.executeQuery(sql2);

				String rname = null;
				String host = null;
				//get room title
				if(rs2.next()) {
					rname = rs2.getString("room_title");
					host = rs2.getString("hostID");
				}
				rs2.close();
				st2.close();
				
				%>
				<form action = 'Eval_Update.jsp' metho = "post">
				<td> <%=sdate %> ~ <%=edate %></td><td> 
				<a href = "Room_Info.jsp?rid=<%=rid%>" style = "font-decoration : none;" 
				onmouseover="this.style.color='gray'" onmouseout="this.style.color='black'"><%=rname%></a></td> 
				<td> <a href = "Look_Acco.jsp?uid=<%=host%>" style = "font-decoration : none;" 
				onmouseover="this.style.color='gray'" onmouseout="this.style.color='black'"><%=host%></a></td>
				
				<td>
				<select name = "eval" style = "position:absolute; y-index:1; margin:1%">
								<option value = "1">1</option>
								<option value = "2">2</option>
								<option value = "3">3</option>
								<option value = "4">4</option>
								<option value = "5" selected>5</option>
				</select>
				<input type = "hidden" value = <%=host %> name = "eid">
				<button type="submit" value="별점" style ="width:50%;">별점주기</button>
				</td>
			
				<td><button type="button" value="예약자" name="reser"
										onclick="location.href = 'notifi.jsp?reser=daeun'">신고하기</button></td>
				</tr>
				</form>
				<%
				}
	}
		else {
			//get not replied reserve info 
			sql = "select a.RoomId,b.StartDate,b.EndDate,b.reserveNum, a.room_title, b.guestID from room_info a, room_reserve_info b where a.hostID = '" + Id +"' AND a.RoomID = b.RoomID AND b.conform = '1'";
			Statement st = null;
			st = con.createStatement();
			rs = st.executeQuery(sql);
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
	<br>

	<!--center-->
	<form action="Eval_Update.jsp" method="POST">
		<div class="container">
			<table>
				<caption style="font-weight: bold; font-size: 160%; padding: 5px">이용내역</caption>
				<tread>
				<tr>
					<th>날짜</th>
					<th>방 이름</th>
					<th>소비자</th>
					<th>별점주기</th>
				</tr>
				</tread>
				<tbody>
					<tr>
					<%
				while(rs.next()) {
				int rid = rs.getInt(1);
				String sdate = rs.getString(2);
				String edate = rs.getString(3);
				int resn = rs.getInt(4);				
				String title = rs.getString(5);
				String cid = rs.getString(6);
				%>
				
				<td> <%=sdate %> ~ <%=edate %></td><td> 
				<a href = "Room_Info.jsp?rid=<%=rid%>" style = "font-decoration : none;" 
				onmouseover="this.style.color='gray'" onmouseout="this.style.color='black'"><%=title%></a></td> 
				<td> <a href = "Look_Acco.jsp?uid=<%=cid%>" style = "font-decoration : none;" 
				onmouseover="this.style.color='gray'" onmouseout="this.style.color='black'"><%=cid%></a></td> 
				<td>
				<select name = "eval" style = "position:absolute; y-index:1; margin:1%">
								<option value = "1">1</option>
								<option value = "2">2</option>
								<option value = "3">3</option>
								<option value = "4">4</option>
								<option value = "5" selected>5</option>
				</select>
				<input type = "hidden" value = <%=cid %> name = "eid">
				<button type="submit" value="별점" style ="width:50%;">별점주기</button>
				</td>
				</tr>
				
				<%
				}
		}
					%>
			

				</tbody>

			</table>
		</div>
	</form>

</body>


</html>
