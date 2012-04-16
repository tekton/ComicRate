<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<jsp:include page='header.jsp'/>

<div id="authTabs">
	<ul>
		<li><a href="#login">Login</a></li>
		<li><a href="#register">Register</a></li>
	</ul>
	<div id="login">
		<h3>Login with Username and Password</h3>
		<form name='f' action='/ComicRate/j_spring_security_check' method='POST'>
		 <table>
		    <tr><td>User:</td><td><input type='text' name='j_username' value=''></td></tr>
		    <tr><td>Password:</td><td><input type='password' name='j_password'/></td></tr>
		    <tr><td><input type='checkbox' name='_spring_security_remember_me'/></td><td>Remember me on this computer.</td></tr>
		    <tr><td colspan='2'><input name="login" type="submit" value="Login"/></td></tr>
		  </table>
		</form>
	</div>
	
	<div id="register">
		<h3>Register New User</h3>
		<form name='newUser' id="newUser" action='newuser' method='POST'>
		 <table>
		    <tr><td>User:</td>	<td><input type='text' name='user' id="user" value=''></td><td class="status"></td></tr>
		    <tr><td>Password:	</td><td><input type='password' name='password' id="password"/></td><td class="status">
   		  				<div class="password-meter">
		  					<div class="password-meter-message">&nbsp;</div>
		  					<div class="password-meter-bg">
			  					<div class="password-meter-bar"></div>
		  					</div>
	  					</div>
		    </td></tr>
			<tr><td>Password:	</td><td><input type='password' name='password2' id="password2"/></td><td class="status"></td></tr>
			<tr><td>E-Mail:		</td><td><input type='text' name='email'/></td><td class="status"></td></tr>
		    <tr><td colspan='2'><input name="register_user" id="register_user" type="submit" value="Register" /></td></tr>
		  </table>
		</form>
	</div>
</div>

	<script>
		$(function() {
			$( "#authTabs" ).tabs();
		});
	</script>
	
	<script>
	$(document).ready(function() {
		//alert("hi"); //DBUG
		// validate signup form on keyup and submit
		var validator = $("#newUser").validate({
			rules: {
				user: {
					required: true,
					minlength: 2
				},
				password: {
					required: true,
					minlength: 1
				},
				password2: {
					required: true,
					equalTo: "#password"
				}
			},
			messages: {
				user: {
					required: "Enter a username",
					minlength: "Enter at least 1 characters"
				},
				password2: {
					required: "Repeat your password",
					equalTo: "Enter the same password as above"
				}
			},
			// the errorPlacement has to take the table layout into account
			errorPlacement: function(error, element) {
				error.prependTo( element.parent().next() );
			},
			// specifying a submitHandler prevents the default submit, good for the demo
			//submitHandler: function() {
			//	alert("submitted!");
			//},
			//Removed for now, but I may come back to use this "later"...
			// set this class to error-labels to indicate valid fields
			success: function(label) {
				// set &nbsp; as text for IE
				label.html("&nbsp;").addClass("checked");
				//decided against labels for now anyway...
			}
			
		});
	});
	
	</script>

<jsp:include page='footer.jsp'/>