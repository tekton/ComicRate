<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>

	<h2>Add a new comic</h2>
	<form method="post" action="addComic.html">
	 
	    <table>
			<tr><td>title</td><td><input type="text" name="title" /></td></tr>
			<tr><td>number</td><td><input type="text" name="issue_number" /></td></tr>
			<tr><td>notes</td><td><input type="text" name="note" /></td></tr>
			<tr><td>overall</td><td><input type="hidden" name="overall" id="overall" value="0" />
				<div id="slider_overall"></div>
			</td></tr>
			<tr><td>art</td><td><input type="hidden" name="art" id="art" value="0" /><div id="slider_art"></div></td></tr>
			<tr><td>story</td><td><input type="hidden" name="story" id="story" value="0" /><div id="slider_story"></div></td></tr>
			<tr><td>likely</td><td><input type="hidden" name="likely_to_buy_next" id="likely_to_buy_next" value="0" /><div id="slider_likely_to_buy_next"></div></td></tr>
			<tr><td>img</td><td><input type="text" name="img_url" /></td></tr>
		    <tr>
		        <td colspan="2">
		            <input type="submit" value="Add Comic Review"/>
		        </td>
		    </tr>
		</table>
	</form>
	
	<jsp:include page='comic_sliders.jsp'/>