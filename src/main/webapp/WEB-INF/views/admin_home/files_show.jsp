<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='../admin_header.jsp'/>

			<h3>Contents of File(s)</h3>
			<c:forEach var="item" items="${files}" varStatus="status">
				<div>${item.value.comic}</div>
				<table>
					<c:forEach var="row" items="${item.value.rows}" varStatus="status">
						<tr>
							<td>${row.value.name}</td>
							<td>${row.value.value}</td>
						</tr>
					</c:forEach>
				</table>
			</c:forEach>

<jsp:include page='../admin_footer.jsp'/>