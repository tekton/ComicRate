<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>
<div id="solo">
	<h2><a href="<c:url value="/home/transfer/unread/${title}" />">${title}</a></h2>
	<div>Series Overall Feeling: ${overall_avg}</div>
	<div>Series Average Story: ${story_avg}</div>
	<div>Series Average Art: ${art_avg}</div>
	
	<div style="padding: 15px;">
		<table id="results" class="tablesorter">
			<thead>
			<tr>
				<th>Title</th>
				<th>Issue</th>
				<th width="135px">Overall</th>
				<th width="135px">Story</th>
				<th width="135px">Art</th>
			</tr>
			</thead>
			<tbody>
			<c:forEach var="item" items="${comics}" varStatus="status">
				<tr>
			 		<td>
			 			<a href="<c:url value="/user/comic/${item.value.getId()}" />">${item.value.getTitle()}</a></td>
					<td>${item.value.getIssue_number()}
								 			<c:forEach var="cf" items="${item.value.confirmed_files}">
						     	
				     	<span class="ui-widget ui-icon ui-icon-plus ui-corner-all" id="transfer_${cf.value.id}">T</span>
						<script>
							$(document).ready(function(){
								$("#transfer_${cf.value.id}").click(function(){
									var transfer_url = "<c:url value="/home/json/transfer/${cf.value.id}" />";
									$.ajax({
										type: "GET",
										url: transfer_url,
										processData: true,
										data: {},
										dataType: "json",
										success: function(json) {
											//alert(json.success);
											$("#transfer_${item.value.id}").removeClass('ui-state-default');
										},
										error: function(x,y,z) {
											alert("there was an error...");
										}
									});
								});
							});
						</script>
						</c:forEach>
					</td>
					
					<fmt:formatNumber var="overall" value="${(item.value.overall_avg /2)}" maxFractionDigits="2" minFractionDigits="2" />
					<td>${item.value.create_stars_user_input(item.value.overall, "overall")}/(${overall})</td>
					
					<fmt:formatNumber var="story" value="${(item.value.story_avg /2)}" maxFractionDigits="2" minFractionDigits="2" />
					<td>${item.value.create_stars_user_input(item.value.story, "story")}/(${story})</td>
					
					<fmt:formatNumber var="art" value="${(item.value.art_avg /2)}" maxFractionDigits="2" minFractionDigits="2" />
					<td>${item.value.create_stars_user_input(item.value.art, "art")}/(${art})</td>
				</tr>
			</c:forEach>
			</tbody>
		</table>
	</div>
	
	<script>
	$(function() { 
		$( "#results" ).tablesorter();
	});
	</script>
</div>
<jsp:include page='footer.jsp'/>