<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>

			<c:forEach var="item" items="${folders}" varStatus="status">
				<div><a href="./${item.value}/">${item.value}</a> -- <a href="./${item.value}/process">process</a></div>
			</c:forEach>

<jsp:include page='footer.jsp'/>