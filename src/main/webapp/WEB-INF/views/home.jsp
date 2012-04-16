<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>

<div id="main_form">
	<div>
		<h3>Highest Rated Overall</h3>
		  <table>
		    <c:forEach var="item" items="${highest}" varStatus="status">
		    <tr>
		      <td><a href="<c:url value="/comic/${item.value.getId()}" />">${item.value.getTitle()} ${item.value.getIssue_number()}</a></td>
		      
		    </tr>
		    </c:forEach>
		</table>	
	</div>
	<div>
		<h3>Entries You Haven't</h3>
		  <table>
	    <c:forEach var="item" items="${norate}" varStatus="status">
	    <tr>
	      <td><a href="<c:url value="/comic/${item.value.getId()}" />">${item.value.getTitle()}</a></td>
	      <td>${item.value.getIssue_number()}</td>
	    </tr>
	    </c:forEach></table>
    </div>
</div>
<div id="right-nav">

	<div>
	<h3>Books You've Recent Rated</h3>
		  <table>
		    <c:forEach var="item" items="${five}" varStatus="status">
		    <tr>
				<td><a href="<c:url value="/user/comic/${item.value.getId()}" />">${item.value.getTitle()} ${item.value.getIssue_number()}</a></td>
				<td>${item.value.create_stars_input(item.value.overall, "overall")}</td>
		    </tr>
		    </c:forEach>
		</table>
	</div>

	<p>The time on the server is ${serverTime}.</p>
	<div style="clear: both;">&nbsp;</div>
</div>
<div style="clear: both;">&nbsp;</div>

<jsp:include page='footer.jsp'/>