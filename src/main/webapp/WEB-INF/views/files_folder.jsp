<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>

	<h2>Actions</h2>
	<div>Add to database...</div>
	<div><a href="./process">Scan for files...</a></div>
			<h3>Contents of Folder</h3>
			<c:forEach var="item" items="${folders}" varStatus="status">
				<div>${item.value}</div>
			</c:forEach>

<jsp:include page='footer.jsp'/>