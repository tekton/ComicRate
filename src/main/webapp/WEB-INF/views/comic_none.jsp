<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!--  Require the header with all the scripts and things -->
<jsp:include page='header.jsp'/>
<h4>It looks like you haven't rated this one yet; you can do so now by clicking on "edit" below</h4>
<table>
	<tr>
		<td rowspan="7"><img src="${img_url}" /></td>
		<td>Title</td>
		<td>${title}</td>
	</tr>
	<tr>
		<td>Issue</td>
		<td>${issue_id}</td>
	</tr>
	<tr>
		<td>Overall</td>
		<td>${overall}
	<tr>
		<td>Art</td>
		<td>${art}</td>
	</tr>
	<tr>
		<td>Story</td>
		<td>${story}</td>
	</tr>
	<tr>
		<td>Notes</td>
		<td>${note}</td>
	</tr>
	<tr>
		<td>Owned</td>
		<td>${owned}</td>
	</tr>
</table>
<!-- 
<div>${title} - ${issue_id}</div>
<div>${note}</div>
<div>${overall}</div>
<div>${art}</div>
<div>${story}</div>
<div><img src="${img_url}" /></div> -->
<div><a href="<c:url value="/user/comic/edit/${id}" />">Edit My Ratings</a></div>
<div><a href="<c:url value="/s/${title}" />">Series Summary</a></div>
<jsp:include page='comic_sliders.jsp'/>
<!-- TODO: make sliders read only -->
<!-- Require whatever the footer needs to be -->
<jsp:include page='footer.jsp'/>