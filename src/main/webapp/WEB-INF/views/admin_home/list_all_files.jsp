<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<%@ taglib prefix="s" uri="http://www.springframework.org/security/tags" %>
<jsp:include page='../admin_header.jsp'/>

<div class="ui-state-highlight ui-corner-all" style="margin-left: 200px; padding: 5px;">
Below you will find the files that you asked for. Please note the following:
<ul>
	<li>Click on the ID of the file will allow you to edit the entry</li>
	<li>Clicking on the name of the comic will open a dialog to add that series</li>
	<li>Clicking on the number of the comic will increment the series to that number, it will not create the series to that number as a fail-safe</li>
</ul>
</div>

<table>
	<tr>
		<th>ID</th>
		<th>Comic</th>
		<th>#</th>
		<th>Year</th>
		<th>Path</th>
	</tr>
	<c:forEach var="file" items="${files}" varStatus="status">
		<tr>
			<td>${file.value.getId()}</td>
			<td>${file.value.getComic()}</td>
			<td><a href="<c:url value="/admin/increment/${file.value.getComic()}/${file.value.getNumber()}" />">${file.value.getNumber()}</a></td>
			<td>${file.value.getYear()}</td>
			<td>${file.value.getPath()}</td>
		</tr>
	</c:forEach>
</table>
<jsp:include page='../admin_footer.jsp'/>