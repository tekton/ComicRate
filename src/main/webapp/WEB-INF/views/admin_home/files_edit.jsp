<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<%@ taglib prefix="s" uri="http://www.springframework.org/security/tags" %>
<jsp:include page='../admin_header.jsp'/>
	<div id="comic-file-edit" class="ui-widget ui-widget-content">
		<form method="post" action="<c:url value="/home/edit/${file.id}"/>">
			<h3>Contents of File(s)</h3>
				<table>
					<c:forEach var="row" items="${file.rows}" varStatus="status">
						<tr>
							<td>${row.value.label}</td>
							<td style="width: 600px;"><input type="${row.value.type}" name="${row.value.name}" value="${row.value.value}" style="width: 100%;"/></td>
						</tr>
					</c:forEach>
				</table>
			<input type="submit" />
		</form>
		
		<div>Increase the series to this comic number: <a href="<c:url value="/admin/increment/${file.getComic()}/${file.getNumber()}" />">${file.getNumber()}</a></div>
		
		<c:if test="${not empty x}">
			<div>Possible parent ID: ${x} :: Clicking submit will link this file to the comic in question!</div>
		</c:if>
		
		<c:if test="${not empty comic}">
			<div>[<a href="<c:url value="/user/comic/${comic.id}" />">The Comic</a>]</div>
		</c:if>
	</div>
<jsp:include page='../admin_footer.jsp'/>