<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<%@ taglib prefix="s" uri="http://www.springframework.org/security/tags" %>
<html>
	<head>
		<script type="text/javascript" src="<c:url value="/resources/jquery.min.js" />"> </script>
		<script type="text/javascript" src="<c:url value="/resources/jquery-ui/js/jquery-ui-1.8.17.custom.min.js" />"> </script>
		<script type="text/javascript" src="<c:url value="/resources/jquery.tablesorter.min.js" />"> </script>
		<script type="text/javascript" src="<c:url value="/resources/jquery.validate.min.js" />"> </script>
		<script type="text/javascript" src="<c:url value="/resources/additional-methods.min.js" />"> </script>
		<script type="text/javascript" src="<c:url value="/resources/jquery.validate.password.js" />"> </script>
		<script type="text/javascript" src="<c:url value="/resources/jquery.ui.stars-3.0/jquery.ui.stars.min.js" />"> </script>
		
		<link type='text/css' rel='stylesheet' href="<c:url value="/resources/jquery-ui/css/smoothness/jquery-ui-1.8.17.custom.css" />" />
		<link type='text/css' rel='stylesheet' href="<c:url value="/resources/jquery.ui.stars-3.0/jquery.ui.stars.min.css" />" />
		<link type='text/css' rel='stylesheet' href="<c:url value="/resources/admin.css" />" />	
		<title>ComicRate: Admin</title>
	</head>
	<body>
		<div id="top">
			<span><a href="<c:url value="/" />">ComicRate Admin Panels</a></span>
		</div>
		
		<div id="left-nav">
			<h3><a href="#">Comics</a></h3>
			<div>
				<ul>
					<li>Add</li>
					<li>Search</li>
					<li>Increment</li>
				</ul>
			</div>
			<h3><a href="#">Users</a></h3>
			<div>
				<ul>
					<li><a href="<c:url value="/admin/users/" />">List</a></li>
					<li>New</li>
					<li>Options</li>
				</ul>
			</div>
			<h3><a href="#config">Config</a></h3>
			<div id="config">
				<ul>
					<li>NYI</li>
				</ul>
			</div>
			<h3><a href="#">Files</a></h3>
			<div>
				<ul>
					<li><a href="<c:url value="/home/files/list/" />">List</a></li>
					<li>Search</li>
					<li>Options</li>
					<li><a href="<c:url value="/home/files/add/" />">Add</a></li>
					<li><a href="<c:url value="/files/root/" />">Root</a></li>
				</ul>
			</div>
			<h3><a href="#">Server</a></h3>
			<div>
				<ul>
					<li>Configure</li>
				</ul>
			</div>
		</div>
		
		<script>
			$(function() {
				$( "#left-nav" ).accordion({
					autoHeight: false,
					navigation: true,
					collapsible: true
				});
			});
		</script>
		
		<div id="main-window">