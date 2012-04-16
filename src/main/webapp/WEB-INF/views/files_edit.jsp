<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>
		<form method="post" action="<c:url value="/home/edit/${file.id}"/>">
			<h3>Contents of File(s)</h3>
				<table>
					<c:forEach var="row" items="${file.rows}" varStatus="status">
						<tr>
							<td>${row.value.label}</td>
							<td><input type="${row.value.type}" name="${row.value.name}" value="${row.value.value}" size="50"/></td>
						</tr>
					</c:forEach>
				</table>
			<input type="submit" />
		</form>
		<c:if test="${not empty x}">
			<div>Possible parent ID: ${x} :: Clicking submit will link this file to the comic in question!</div>
		</c:if>

		<c:if test="${not empty comic}">
			<div>[<a href="<c:url value="/user/comic/${comic.id}" />">The Comic</a>]</div>
		</c:if>

<jsp:include page='footer.jsp'/>