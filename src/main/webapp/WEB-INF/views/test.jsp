<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<h2>Contact Manager</h2>
<form method="post" action="addContact.html">
 
    <table>
    <tr>
        <td><label>First Name</label></td>
        <td><input name="firstname" /></td>
    </tr>
    <tr>
        <td><label>Last Name</label></td>
        <td><input name="lastname" /></td>
    </tr>
    <tr>
        <td><label>Email</label></td>
        <td><input name="email" /></td>
    </tr>
    <tr>
        <td><label>Telephone</label></td>
        <td><input name="telephone" /></td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="submit" value="Add Contact"/>
        </td>
    </tr>
</table>  
 
</form>
