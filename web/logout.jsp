<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%@ page language="java" import="java.text.*,java.sql.*"%>
<!DOCTYPE html>
<html>
<title>login_manager</title>


<body>

	<%
		Class.forName("com.mysql.jdbc.Driver");
		Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/mydb?serverTimezone=UTC", "root",
				"daeun1234");
		session.invalidate();
		out.println("<script>alert('로그아웃되었습니다');");
		response.sendRedirect("Login.jsp");
	%>

</body>
</html>
