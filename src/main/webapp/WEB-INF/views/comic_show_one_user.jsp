<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!--  Require the header with all the scripts and things -->
<jsp:include page='header.jsp'/>
<div id="main_form">
	<table>
		<tr>
			<td rowspan="8"><img src="${comic.img_url}" /></td>
			<td>Title</td>
			<td>${comic.title}</td>
		</tr>
		<tr>
			<td>Issue</td>
			<td>${comic.issue_number}</td>
		</tr>
		<tr>
			<!-- <td>Overall</td>
			<td>${comic.overall}</td> -->
			<td>Overall</td>
			<td>
				${comic.create_stars_user_input(comic.overall, "overall")}
			</td>
		<tr>
			<td>Art</td>
			<td>
				${comic.create_stars_user_input(comic.art, "art")}
			</td>
		</tr>
		<tr>
			<td>Story</td>
			<td>
				${comic.create_stars_user_input(comic.story, "story")}
			</td>
		</tr>
		<tr>
			<td>Keep Reading?</td>
			<td>
				${comic.create_stars_user_input(comic.likely_to_buy_next, "next")}
			</td>
		</tr>
		<tr>
			<td>Notes</td>
			<td>${comic.note}</td>
		</tr>
		<tr>
			<td>Owned</td>
			<td>${comic.own_physical}</td>
		</tr>
	</table>
	<div style="clear: both;">&nbsp;</div>
</div>

<div id="right-nav">
	<table>
		<tr>
			<th style="text-align: center;" colspan="2">All Users Averages</th>
		</tr>
		<tr>
			<!-- <td>Overall</td>
			<td>${comic.overall}</td> -->
			<td>Overall</td>
			<td>
				<div id="stars-overall-avg">
			        <select name="overall-avg">
			            <option value="1">Very poor</option>
			            <option value="2">Poor</option>			            
			            <option value="3">Not that bad</option>
			            <option value="4">Fair</option>
			            <option value="5">Average</option>
			            <option value="6">Almost Good</option>
			            <option value="7">Good</option>
			            <option value="8">Very Good</option>
			            <option value="9">Excellent</option>
			            <option value="10">Perfect</option>
			        </select>
				</div>
			</td>
		<tr>
			<td>Art</td>
			<td>
				<div id="stars-art-avg">
			        <select name="art-avg">
			            <option value="1">Very poor</option>
			            <option value="2">Poor</option>			            
			            <option value="3">Not that bad</option>
			            <option value="4">Fair</option>
			            <option value="5">Average</option>
			            <option value="6">Almost Good</option>
			            <option value="7">Good</option>
			            <option value="8">Very Good</option>
			            <option value="9">Excellent</option>
			            <option value="10">Perfect</option>
			        </select>
				</div>
			</td>
		</tr>
		<tr>
			<td>Story</td>
			<td>
				<div id="stars-story-avg">
			        <select name="story-avg">
			            <option value="1">Very poor</option>
			            <option value="2">Poor</option>			            
			            <option value="3">Not that bad</option>
			            <option value="4">Fair</option>
			            <option value="5">Average</option>
			            <option value="6">Almost Good</option>
			            <option value="7">Good</option>
			            <option value="8">Very Good</option>
			            <option value="9">Excellent</option>
			            <option value="10">Perfect</option>
			        </select>
				</div>
			</td>
		</tr>
	</table>
	<div>&nbsp;</div>
	<div><a href="<c:url value="/s/${comic.title}" />">Series Summary</a></div>
	<div><span id="add_to_pulllist">Add to Pull List</span></div>
	<script>
		$(document).ready(function(){
			$("#add_to_pulllist").click(function(){
				$.ajax({
					type: "GET",
					url: "<c:url value="/user/pulllist/add/${comic.title}" />",
					processData: true,
					data: {},
					dataType: "json",
					success: function(json) {
						//not really sure we'd need to to anything, maybe change the color?
						if(json.success > 0) {
							alert("Added to pull list");
						} else {
							alert("Not added, may already be there!");
						}
					},
					error: function(x,y,z) {
						alert("there was an error adding the series to the pull list::"+z+" -- "+y+" -- "+z);
					}
				});
			});
		});
	</script>
	<div>
		<h3>Confirmed Local Files</h3>
			<c:forEach var="item" items="${comic.confirmed_files}" varStatus="status">
				<div><a href="<c:url value="/home/download/${item.value.id}" />">${item.value.link_disp}</a> 
					<a href="<c:url value="/home/edit/${item.value.id}/from/${comic.id}" />">
					<span class="ui-widget ui-icon ui-icon-gear ui-corner-all" id="edit_${item.value.id}">E</span></a>
					<span class="ui-widget ui-icon ui-icon-plus ui-corner-all" id="transfer_${item.value.id}">JT</span>
					<script>
						$(document).ready(function(){
							$("#transfer_${item.value.id}").click(function(){
								var transfer_url = "<c:url value="/home/json/transfer/${item.value.id}" />";
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
				</div>
			</c:forEach>
		<h3>Possible Local Files</h3>
			<c:forEach var="item" items="${comic.files}" varStatus="status">
				<div>
					<a href="<c:url value="/home/edit/${item.value.id}/from/${comic.id}" />">${item.value.link_disp}</a>
					 [<a href="<c:url value="/home/download/${item.value.id}" />">D</a>]
				</div>
			</c:forEach>
	</div>
	<div>&nbsp;</div>
	<div style="clear: both;">&nbsp;</div>	
</div>

<div style="clear: both;">&nbsp;</div>

	<script>
		$("#stars-overall").stars({
			inputType: "select",
			split: 2,
			cancelShow: false,
			disabled: true
		});
		$("#stars-art").stars({
			inputType: "select",
			split: 2,
			cancelShow: false,
			disabled: true
		});
		$("#stars-story").stars({
			inputType: "select",
			cancelShow: false,
			split: 2,
			disabled: true
		});
		$("#stars-keep-reading").stars({
			inputType: "select",
			cancelShow: false,
			split: 2,
			disabled: true
		});
		$("#stars-overall-avg").stars({
			inputType: "select",
			split: 2,
			cancelShow: false,
			disabled: true
		});
		$("#stars-art-avg").stars({
			inputType: "select",
			split: 2,
			cancelShow: false,
			disabled: true
		});
		$("#stars-story-avg").stars({
			inputType: "select",
			cancelShow: false,
			split: 2,
			disabled: true
		});
		
		//comic_show_one_user
		$("#stars-overall").stars("select", ${comic.getOverall()});
		$("#stars-art").stars("select", ${comic.getArt()});
		$("#stars-story").stars("select", ${comic.getStory()});
		$("#likely_to_buy_next-stars").stars("select", ${comic.getLikely_to_buy_next()});

		$("#stars-overall-avg").stars("select", Math.round(${comic.overall_avg}));
		$("#stars-art-avg").stars("select", Math.round(${comic.art_avg}));
		$("#stars-story-avg").stars("select", Math.round(${comic.story_avg}));
	</script>

<jsp:include page='comic_sliders.jsp'/>
<!-- TODO: make sliders read only -->
<!-- Require whatever the footer needs to be -->
<jsp:include page='footer.jsp'/>