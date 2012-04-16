<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>

<h3>Registration...</h3>
<div>Well, it looks like you registered...someday in the future this will also log you in, however that day is now now sadly...</div>
	<div id="login">
		<h3>Login with your new Username and Password!</h3>
		<form name='f' action='/ComicRate/j_spring_security_check' method='POST'>
		 <table>
		    <tr><td>User:</td><td><input type='text' name='j_username' value=''></td></tr>
		    <tr><td>Password:</td><td><input type='password' name='j_password'/></td></tr>
		    <tr><td><input type='checkbox' name='_spring_security_remember_me'/></td><td>Remember me on this computer.</td></tr>
		    <tr><td colspan='2'><input name="submit" type="submit" value="Login"/></td></tr>
		  </table>
		</form>
	</div>
<jsp:include page='footer.jsp'/>