<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>
<div id="solo">
	<h2>Search Results</h2>
	
	<div>
		<table id="results" class="tablesorter">
			<thead>
			<tr>
				<th>Title</th>
				<th>Issue</th>
				<th>Your Overall/Avg</th>
				<th>Your Story/Avg</th>
				<th>Your Art/Avg</th>
			</tr>
			</thead>
			<tbody>
			<c:forEach var="item" items="${results}" varStatus="status">
				<tr>
			 		<td><a href="<c:url value="/user/comic/${item.value.getId()}" />">${item.value.getTitle()}</a></td>
					<td>${item.value.getIssue_number()}</td>
					<td>${item.value.create_stars_input(item.value.overall, "overall")}<br /><hr />${item.value.create_stars_input(item.value.overall_avg, "overall_avg")}</td>
					<td>${item.value.create_stars_input(item.value.story, "story")}<br /><hr />${item.value.create_stars_input(item.value.story_avg, "story_avg")}</td>
					<td>${item.value.create_stars_input(item.value.art, "art")}<br /><hr />${item.value.create_stars_input(item.value.art_avg, "art_avg")}</td>
				</tr>
			</c:forEach>
			</tbody>
		</table>
	</div>
	
	<script>
	$(function() { 
		$( "#results" ).tablesorter({widgets: ['zebra']});
	});
	</script>
</div>	
<jsp:include page='footer.jsp'/>