<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>
	<h2>Edit comic</h2>
	<form method="post" action="${comic.id}">
	 
	    <table>
			<tr><td>title</td><td><input type="text" name="title" value="${comic.title}" /></td></tr>
			<tr><td>number</td><td><input type="text" name="issue_number" value="${comic.issue_number}" /></td></tr>
			<tr><td>notes</td><td><input type="text" name="note" value="${comic.note}" /></td></tr>
			<tr><td>overall</td><td>
				<!-- <input type="hidden" name="overall" id="overall" value="${comic.overall}" />  -->
				<div id="caption_overall"></div>
				<div id="stars-overall">
			        <input type="radio" name="overall" value="1" title="Very poor" />
			        <input type="radio" name="overall" value="2" title="Poor" />
			        <input type="radio" name="overall" value="3" title="Not that bad" />
			        <input type="radio" name="overall" value="4" title="Fair" />
			        <input type="radio" name="overall" value="5" title="Average" />
			        <input type="radio" name="overall" value="6" title="Almost good" />
			        <input type="radio" name="overall" value="7" title="Good" />
			        <input type="radio" name="overall" value="8" title="Very good" />
			        <input type="radio" name="overall" value="9" title="Excellent" />
			        <input type="radio" name="overall" value="10" title="Perfect" />
			        <input type="hidden" name="overall" id="overall" value="${comic.overall}"/>
				</div>
			</td></tr>
			<tr>
				<td>art</td>
				<td>
				<div id="caption_art"></div>
				<div id="stars-art">
			        <select name="art-sel" id="art">
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
			        <input type="hidden" name="art" id="art" value="${comic.art}"/>
				</div>
				</td>
			</tr>
			<tr>
				<td>story</td>
				<td>
				<div id="caption_story"></div>
				<div id="stars-story">
			        <select name="story-sel" id="story">
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
			        <input type="hidden" name="story" id="story" value="${comic.story}"/>
				</div>
				</td>
			</tr>
			<tr><td>likely</td><td>
				<input type="hidden" name="likely_to_buy_next" id="likely_to_buy_next" value="${comic.likely_to_buy_next}" />
				<div id="likely_to_buy_next-stars">
			        <select name="likely_to_buy_next-sel" id="story">
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
				</div></td></tr>
			<!-- <tr><td>img</td><td><input type="text" name="img_url" value="${comic.img_url}"/></td></tr>  -->
			
		    <tr>
		        <td colspan="2">
		            <input type="submit" value="Add Comic Review"/>
		        </td>
		    </tr>
		</table>

	<script>
		$("#stars-overall").stars({
			split: 2,
			cancelShow: false,
			captionEl: $("#caption-overall"),
			callback: function(ui, type, value) {
				document.getElementById("overall").value = value;
			}
		});

		$("#stars-art").stars({
			inputType: "select",
			split: 2,
			cancelShow: false,
			callback: function(ui, type, value) {
				document.getElementById("art").value = value;
			}
		});
		
		$("#stars-story").stars({
			inputType: "select",
			split: 2,
			cancelShow: false,
			callback: function(ui, type, value) {
				document.getElementById("story").value = value;
			}
		});
		
		$("#likely_to_buy_next-stars").stars({
			inputType: "select",
			split: 2,
			cancelShow: false,
			callback: function(ui, type, value) {
				document.getElementById("likely_to_buy_next").value = value;
			}
		});
		
		$("#stars-overall").stars("select", ${comic.overall});
		$("#stars-art").stars("select", ${comic.art});
		$("#stars-story").stars("select", ${comic.story});
		$("#likely_to_buy_next-stars").stars("select", ${comic.likely_to_buy_next});
		
		
		
		
	</script>

	</form>

	<jsp:include page='comic_sliders.jsp'/>
<jsp:include page='footer.jsp'/>