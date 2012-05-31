<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='../header.jsp'/>
<div id="solo">	
	<div style="padding: 15px;">
		<table>
			<tr>
				<th>Title</th>
				<th>Overall</th>
				<th>Story</th>
				<th>Art</th>
			</tr>
			<c:forEach var="item" items="${series}" varStatus="status">
				<tr>
			 		<td>${item.getTitle()}</td>
					<td>${item.getOverall()}</td>
					<td>${item.getStory()}</td>
					<td>${item.getArt()}</td>
				</tr>
			</c:forEach>
		</table>
	</div>
</div>
<jsp:include page='../footer.jsp'/>