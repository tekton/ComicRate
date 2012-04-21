<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<%@ taglib prefix="s" uri="http://www.springframework.org/security/tags" %>

<html>
	<head>
		<title>comic|rate</title>
		<script type="text/javascript" src="<c:url value="/resources/jquery.min.js" />"> </script>
		<script type="text/javascript" src="<c:url value="/resources/jquery-ui/js/jquery-ui-1.8.17.custom.min.js" />"> </script>
		<script type="text/javascript" src="<c:url value="/resources/jquery.tablesorter.min.js" />"> </script>
		<script type="text/javascript" src="<c:url value="/resources/jquery.validate.min.js" />"> </script>
		<script type="text/javascript" src="<c:url value="/resources/additional-methods.min.js" />"> </script>
		<script type="text/javascript" src="<c:url value="/resources/jquery.validate.password.js" />"> </script>
		<script type="text/javascript" src="<c:url value="/resources/jquery.ui.stars-3.0/jquery.ui.stars.min.js" />"> </script>
		
		<link type='text/css' rel='stylesheet' href="<c:url value="/resources/jquery-ui/css/smoothness/jquery-ui-1.8.17.custom.css" />" />
		<link type='text/css' rel='stylesheet' href="<c:url value="/resources/jquery.ui.stars-3.0/jquery.ui.stars.min.css" />" />
		<link type='text/css' rel='stylesheet' href="<c:url value="/resources/comicrate.css" />" />
		
	</head>
	<body>
		<div id="container">
		
		<div id="top">
			<span class="cmc"><a href="<c:url value="/" />">comic</a></span><span class="rate"><a href="<c:url value="/" />">rate</a></span>
		
			<span class="top_nav-item"><a href="<c:url value="/about/" />">about</a></span>
			<span class="top_nav-item"><a href="<c:url value="/search/" />">search</a></span>
			<s:authorize access="isAuthenticated()">
   				<span class="top_nav-item"><a href="<c:url value="/j_spring_security_logout" />">Logout</a></span>
			</s:authorize>
			<s:authorize access="hasRole('admin')">
				[ Add Comics | Increment Comics | 
				<a href="<c:url value="/files/root/" />">File Scans</a> ]
			</s:authorize>
		</div>
		
		<div id="content"><!-- finished in the footer -->