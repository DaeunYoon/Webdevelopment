<%@page import="java.sql.*"%>
<%@page import="login.LoginManager"%>
<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
	<% LoginManager loginManager = LoginManager.getInstance(); %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
		String rid = request.getParameter("rnum");
		
		String sql = "update room_reserve_info set conform = '2' where reserveNum ='" +rid+"' ";
		PreparedStatement st = null;
		st = con.prepareStatement(sql);
		boolean ch = st.execute(sql);
		String rname = null;
		
	%>
	
	<script>
	<% if(!ch)
		out.println("alert('예약 거절이 정상적으로 진행되었습니다.');");
	else
		out.println("alert('다시 시도해 주세요');");
	%>

	location.href='Main.jsp'
		function expireSession()
	{
		alert("로그인 시간이 만료되었습니다. 다시 로그인해주세요");
		location.href = "logout.jsp";
		session.invalidate();
	}
	setTimeout('expireSession()', <%= request.getSession().getMaxInactiveInterval() * 1 %>);
	</script>
	

</body>

</html>
