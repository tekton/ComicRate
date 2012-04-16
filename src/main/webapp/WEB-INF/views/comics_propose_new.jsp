<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>

<form method="post" action="<c:url value="/admin/comics/add" />">
	<table>
			<c:forEach var="item" items="${rows}" varStatus="status">
				<tr>
			 		<td>${item.value.getLabel()}</td>
					<td><input type="${item.value.getType()}" name="${item.value.getName()}" /></td>
				</tr>
			</c:forEach>
			<tr><td colspan="2"><input type="Submit" /></td></tr>
	</table>
</form>

<jsp:include page='footer.jsp'/>