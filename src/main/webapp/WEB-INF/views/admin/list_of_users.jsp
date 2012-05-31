<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='../admin_header.jsp'/>

<div class="ui-state-highlight ui-corner-all" style="padding: 5px;">
Below you will find the users that you asked for. Please note the following:
<ul>
	<li>Directions go here...</li>
	<li>...and here!</li>
</ul>
</div>

<c:forEach var="user" items="${users.users}" varStatus="status">
	<div>
		<div>${user.getName()}</div>
		<div id="${user.getName()}_rl"><ul>
			<c:forEach var="rl" items="${user.getUpl().getBooks()}" varStatus="status">
				<li>${rl}</li>
			</c:forEach>
		</ul></div>
	</div>
</c:forEach>

<jsp:include page='../admin_footer.jsp'/>