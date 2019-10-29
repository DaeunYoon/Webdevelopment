<%@page import="java.sql.*"%>
<%@page import="java.math.BigDecimal"%> 
<%@page import="login.LoginManager"%>
<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
	<% LoginManager loginManager = LoginManager.getInstance(); %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/style1.css" rel="stylesheet" type="text/css">
<link href="css/sup_style.css" rel="stylesheet" type="text/css">
<script src="jquery_function.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script>
	function date_mask(formd, textid) {

		/*
		 input onkeyup에서
		 formd == this.form.name
		 textid == this.name
		 */

		var form = eval("document." + formd);
		var text = eval("form." + textid);

		var textlength = text.value.length;

		if (textlength == 4) {
			text.value = text.value + "-";
		} else if (textlength == 7) {
			text.value = text.value + "-";
		} else if (textlength > 9) {
			//날짜 수동 입력 Validation 체크
			var chk_date = checkdate(text);

			if (chk_date == false) {
				return;
			}
		}
	}

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

		request.setCharacterEncoding("utf-8");
		
		String sql = "select max(Rnum) from review";
		Statement stmt = null;
		stmt = con.prepareStatement(sql);
		
		ResultSet rs = null;
		rs = stmt.executeQuery(sql);

		int num = 0;
		if(rs.next())
			num = rs.getInt(1);
		num++;
		String eid = request.getParameter("eid");
		String eval = request.getParameter("eval");
		
		sql = "insert into review(SendID, evaluation, Rnum, recieverID) values ('" + Id + "', '"
				+ eval +"', '" + num +"', '" + eid +"')";
		
		PreparedStatement pstmt = null;
		pstmt = con.prepareStatement(sql);
		pstmt.execute();
		
		
		sql = "select count(sendid), sum(evaluation) from review where recieverID ='"+eid+"'";
		rs = stmt.executeQuery(sql);

		double avg = 0;
		if(rs.next())
		{
			int count = rs.getInt(1);
			int sum = rs.getInt(2);
			avg = (double)sum/(double)count;
			System.out.println(sum +" " +count);
		}
		BigDecimal decim = new BigDecimal(avg).setScale( 2 , java.math.BigDecimal.ROUND_HALF_UP );

		System.out.println(avg);
		sql = "update account set evaluation = '" + decim + "' where id = '" + eid + "'";
		
		pstmt = con.prepareStatement(sql);
		pstmt.execute();

		stmt.close();
		pstmt.close();
		con.close();
	%>

	<script>
	alert("정상적으로 등록되었습니다.");
	location.href = "Main.jsp";
	</script>
	
</body>

</html>