<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>

<form method="post" action="<c:url value="/admin/comic/add" />">
	<table>
			<c:forEach var="item" items="${comics}" varStatus="status">
				<tr>
			 		<td>${item.value}</td>
				</tr>
			</c:forEach>
			<tr><td colspan="2"><input type="Submit" /></td></tr>
	</table>
</form>

<jsp:include page='footer.jsp'/>