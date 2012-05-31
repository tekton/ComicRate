<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<%@ taglib prefix="s" uri="http://www.springframework.org/security/tags" %>
<jsp:include page='../header.jsp'/>

<div id="main_form">
<table>
	<tr>
		<th>Series</th>
	</tr>
	<c:forEach var="series" items="${pulllist}" varStatus="status">
		<tr>
			<td>${series}</td>
		</tr>
	</c:forEach>
</table>
</div>

<div id="right-nav">
	Show some options, like copy unread?
</div>

<div style="clear: both;">&nbsp;</div>

<jsp:include page='../footer.jsp'/>