<%@page import="java.sql.*"%>
<%@page import="login.LoginManager"%>
<%
	LoginManager loginManager = LoginManager.getInstance();
%>
<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="jquery_function.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
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
	
	function searchCheck(frm){
        //검색
       
        if(frm.keyWord.value ==""){
            alert("검색 단어를 입력하세요.");
            frm.keyWord.focus();
            return;
        }
        frm.submit();      
    }

</script>
<title>RoomShare</title>
</head>
<body>

<!-- Connect with DB -->
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
		
		/*Check the User State*/
		int st = 0;
		if(rs.next())
			st = rs.getInt("state");
		
		/*If User is Consumer*/
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

			
	<script>
	$("#log").click(function(){logout();})
	</script>
	<!--center-->
	<div class="container">
		<div class="contents">
			<div class="search">
				<form name='frm' method='post' action='./Main.jsp'>
					<select name='sel'>
						<option value="search_date">날짜</option>
						<option value="search_person">인원</option>
						<option value="search_location">위치</option>
					</select> 
					<input type='text' name='word' value='' placeholder="">
					<button type='submit'>검색</button>
				</form>
			</div>
		</div>
	</div>

	<form action="Room_Info.jsp" method="post">
		<div class="room_grid">

			<div class="room_all">

				<table>
				<caption style="font-weight: bold; font-size: 160%; padding: 5px">Room Information</caption>
				<tread>
				<tr>
					<th>title</th>
					<th>price</th>
					<th>supplier</th>
					<th>rating</th>
					<th>Detail</th>
				</tr>
				</tread>
				<tbody>
				<%
					request.setCharacterEncoding("utf-8");
					String title = null, host = null, addr = null, rid = null;
					int price = 0;
					double score = 0;
					String sel = request.getParameter("sel");
					String word = request.getParameter("word");
					
					sql = "select r.RoomID, r.room_title, r.hostID, r.cost, r.add1, r.add2, r.add3, r.add4, a.evaluation from room_info r, account a where a.ID = r.hostID order by room_title";	
					if(sel == null || word == null || word == "")
					{
						sql = "select r.RoomID, r.room_title, r.hostID, r.cost, r.add1, r.add2, r.add3, r.add4, a.evaluation from room_info r, account a where a.ID = r.hostID order by room_title";
					}
					
					else if(sel.equals("search_date"))
					{
						out.println(sel + word);
						if(word.length() != 21)
						{
							out.println("<script>alert('Wrong input'); location.href='Main.jsp';</script>");
						}
						
						else
							{
								for(int i = 0; i < word.length(); i++)
								{
									if((word.charAt(i) < '0' || word.charAt(i) > '9') && (word.charAt(i) != '-' && word.charAt(i) != ','))
									{
										out.println("<script>alert('Wrong input'); location.href='Main.jsp';</script>");
									}
								}
								String s_date = word.substring(0,10);
								String e_date = word.substring(11,21);
								out.println(s_date + " " + e_date);
								sql = "select r.RoomID, r.room_title, r.hostID, r.cost, r.add1, r.add2, r.add3, r.add4, a.evaluation from room_info r, account a where a.ID = r.hostID order AND (s_date >= '" + s_date +"' AND e_date <= '" +e_date+"') by room_title";
							}
						
					}
						
					else if(sel.equals("search_person"))
					{
						for(int i = 0; i < word.length(); i++)
						{
							if(word.charAt(i) < '0' || word.charAt(i) > '9')
							{
								out.println("<script>alert('Wrong input'); location.href='Main.jsp';</script>");
							}
						}
						sql = "select r.RoomID, r.room_title, r.hostID, r.cost, r.add1, r.add2, r.add3, r.add4, a.evaluation from room_info r, account a where a.ID = r.hostID AND (max_p >= '" + word +"') order by room_title";

						
					}
						
					else if(sel.equals("search_location"))
					{
						sql = "select r.RoomID, r.room_title, r.hostID, r.cost, r.add1, r.add2, r.add3, r.add4, a.evaluation from room_info r, account a where a.ID = r.hostID AND (r.add1 like '%" + word + "%' or r.add2 like '%" + word + "%' or r.add3 like '%" + word + "%' or r.add4 like '%" + word + "%') order by room_title";
					}	
		
					
					stmt = con.createStatement();
					rs = null;
					rs = stmt.executeQuery(sql);
					System.out.println(sql);

					while (rs.next()) {
						rid = rs.getString("RoomID");
						title = rs.getString("room_title");
						host = rs.getString("hostID");
						for (int i = 1; i < 5; i++)
							addr += rs.getString("add" + i);
						price = rs.getInt("cost");
						score = rs.getDouble("evaluation");
						
						out.println("<tr><td><class='room_tit'><strong>" + title + "</strong></td> <td><span class='roomprice'>" + price
								+ "</span></td> <td><span class='room_host'>" + host + "</span></td> <td><span class='room_score'>" + score
								+ "</span></td><td><button type = 'submit' name = 'rid' value = '"+rid+"'<td>detail</tr>");
					}

					
				%>
					</tbody>
					</table>
			</div>


		</div>
	</form>
	<%}
		/*If User is Supplier*/
		else {
			sql = "select roomID from room_info where hostID = '" + Id + "'" ;
			stmt = con.createStatement();
			rs = stmt.executeQuery(sql);
			System.out.println(sql);
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
	<div class="container">
		<form action = "Sup_Accp.jsp" method = "post">
			<table>
				<caption style="font-weight: bold; font-size: 160%; padding: 5px">예약신청내역</caption>
				<tbody>
					<tr>
						<th>Room Information</th>
						<th>Registers</th>
					</tr>
					
					<%
					while(rs.next())
					{
						int rid = 0;
						rid = rs.getInt(1);
						
						
						String sql2 = "select room_title from room_info where RoomID = '" + rid +"'";
						Statement st2 = null;
						st2 = con.createStatement();
						ResultSet rs2 = st2.executeQuery(sql2);
						String title = null;
						if(rs2.next())
							title = rs2.getString(1);
						out.print("<tr><td><a href = 'Room_Info.jsp?rid="+ rid +"' style='text-decoration:none' onmouseover=\"'this.style.color='gray'\" onmouseout=\"this.style.color='black'\">" + title +"</a></td>" );
						
						sql2 = "select Count(guestID) from room_reserve_info where RoomID = '" + rid +"' and conform = '0'";

						rs2 = st2.executeQuery(sql2);
						System.out.println(sql2);
						int n = 0;
						if(rs2.next())
							n = rs2.getInt(1);
						if(n!=0)
							out.println("<td><button type='submit' name='rid' value='"
								+ rid +"' style='border: 0px; width: 30px;'>"+ n +"</button></td></tr>");
						else
							out.println("<td>0</td></tr>");
						st2.close();
						rs2.close();
						
					}
					%>
				</tbody>
			</table>
		</form>
			
	<script>
	$("#log").click(function(){logout();})
	</script>
		
		<%
		} 
		stmt.close();
		rs.close();
		con.close();
		%>

</body>
