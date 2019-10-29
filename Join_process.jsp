<%@page import="java.sql.*"%>

<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script src="jquery_function.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/style1.css" rel="stylesheet" type="text/css">
<title>RoomShare</title>
</head>
<body>

	<%
		/*db connection*/
		Class.forName("com.mysql.jdbc.Driver");
		Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/mydb?serverTimezone=UTC", "root",
				"daeun1234");

		String id = request.getParameter("ID");
		String pw = request.getParameter("PW");
		String name = request.getParameter("name");
		
		int stt = 0;//공급자
		String st = request.getParameter("type");

		
		if (st.equals("consumer"))
			stt = 1; //소비자

		String tel = request.getParameter("tel");
		String sql = "select * from Account where id =?";
		PreparedStatement pstmt = null;
		pstmt = con.prepareStatement(sql);
		pstmt.setString(1, id);
		ResultSet rs = null;
		rs = pstmt.executeQuery();

		if (!rs.next()) {
			sql = "INSERT INTO Account (ID, PW, Username, state, PhoneNumber) Values ('" + id + "', '" + pw
						+ "', '" + name + "', '" + stt + "', '" + tel + "')";

			//System.out.println(sql);

			pstmt = con.prepareStatement(sql);
			pstmt.execute();
		} 
		else {
	%>
			<script>
				alert("사용중인 아이디가 있습니다.");
				location.href = "Join.jsp";
			</script>
	<%
		}
					
		pstmt.close();
		con.close();
	%>

	<script>
		alert("회원가입이 완료되었습니다.");
		location.href = "Login.jsp";
	</script>

</body>

</html>