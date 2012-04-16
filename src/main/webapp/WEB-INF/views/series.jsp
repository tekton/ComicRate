<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>
<div id="solo">
	<h2>${title}</h2>
	<div>Series Overall Feeling: ${overall_avg}</div>
	<div>Series Average Story: ${story_avg}</div>
	<div>Series Average Art: ${art_avg}</div>
	
	<div style="padding: 15px;">
		<table>
			<tr>
				<th>Title</th>
				<th>Issue</th>
				<th>Overall</th>
				<th>Story</th>
				<th>Art</th>
				<th>Avg Overall</th>
				<th>Avg Story</th>
				<th>Avg Art</th>
			</tr>
			<c:forEach var="item" items="${comics}" varStatus="status">
				<tr>
			 		<td><a href="<c:url value="/comic/${item.value.getId()}" />">${item.value.getTitle()}</a></td>
					<td>${item.value.getIssue_number()}</td>
					<td>${item.value.create_stars_input(item.value.overall, "overall")}</td>
					<td>${item.value.create_stars_input(item.value.story, "story")}</td>
					<td>${item.value.create_stars_input(item.value.art, "art")}</td>
					<td>${item.value.create_stars_input(item.value.overall_avg, "overall_avg")}</td>
					<td>${item.value.create_stars_input(item.value.story_avg, "story_avg")}</td>
					<td>${item.value.create_stars_input(item.value.art_avg, "art_avg")}</td>
				</tr>
			</c:forEach>
		</table>
	</div>
</div>
<jsp:include page='footer.jsp'/>