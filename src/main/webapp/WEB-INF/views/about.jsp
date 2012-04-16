<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!--  Require the header with all the scripts and things -->
<jsp:include page='header.jsp'/>
<div id="solo">

	<div>This is my <em>alpha</em> of a comic rating program that I have felt was missing.</div>
	<div>The artwork and some of the visual inspiration is thanks to <a href="http://www.danapull.com/">Mr. Dana Pull</a></div>

	<div>Some things I'd like to get done:
	<ul>
		<li>Change the sliders to "stars" (Done!)</li>
		<li>Allow starts to work on non "edit" pages (need to create json calls)</li>
		<li>Finish the "owned" field</li>
		<li>Clean up the UI a lot</li>
		<li>Fix remaining DB connection leaks</li>
		<li>URL Forwarding on timeout</li>
	</ul>
	</div>

<div style="clear: both;">&nbsp;</div>
</div>
<div style="clear: both;">&nbsp;</div>
<!-- TODO: make sliders read only -->
<!-- Require whatever the footer needs to be -->
<jsp:include page='footer.jsp'/>