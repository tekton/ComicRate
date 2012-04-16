<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>
	<h2>Create Search Parameters</h2>
	
	<div style="padding: 15px;">
	<form method="post" action="results">
		<table>
			<tbody>
				<tr>
					<td>Title</td><td><input type="text" name="title" /></td>
				</tr>
				<!-- <tr>
					<td>Overall Min</td><td><input type="text" name='overall_min' /></td>
					<td>Overall Max</td><td><input type="text" name='overall_max' /></td>
				</tr>
				<tr>
					<td>Art Min</td><td><input type="text" name='art_min' /></td>
					<td>Art Max</td><td><input type="text" name='art_max' /></td>
				</tr>
				<tr>
					<td>Story Min</td><td><input type="text" name='story_min' /></td>
					<td>Story Max</td><td><input type="text" name='story_max' /></td>
				</tr>
				<tr>
					<td>Note</td><td><input type="text" name='text' /></td>
				</tr> -->
				<tr><td colspan="2">More options to come soon...like rating ranged, and flags for certain events...</td></tr>
			    <tr>
			        <td colspan="2">
			            <input type="submit" value="Submit Search"/>
			        </td>
			    </tr>
		    </tbody>
		</table>
	</form>
	</div>
<jsp:include page='footer.jsp'/>