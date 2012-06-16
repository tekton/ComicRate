<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='../admin_header.jsp'/>

			<c:forEach var="item" items="${folders}" varStatus="status">
				<div><a href="./${item.value}/">${item.value}</a> -- <a href="./${item.value}/process">process</a></div>
			</c:forEach>

<jsp:include page='../admin_footer.jsp'/>