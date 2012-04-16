<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>
		<p>The time on the server is ${serverTime}.</p>
		<div>Last "created" comic in session data should go here...</div>
		<jsp:include page='comic_new.jsp'/>	
<jsp:include page='footer.jsp'/>