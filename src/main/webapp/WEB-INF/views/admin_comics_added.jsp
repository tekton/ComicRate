<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>
	<h2>Comics should be added now!</h2>
	
	<form method="post" action="./tabList">
	 
	    <table width="50%">
			<tr><td>List of items</td></tr>
			<tr><td><textarea name="theList"></textarea></td></tr>
			<tr><td><input type="Submit" /></td></tr>
		</table>
	</form>

<jsp:include page='footer.jsp'/>