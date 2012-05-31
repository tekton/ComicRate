package com.tekton.comicrate.home.admin;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

import com.tekton.comicrate.SQLController;

public class HomeUsers extends SQLController {

	List<HomeUser> users;
	
	
	
	public List<HomeUser> getUsers() {
		return users;
	}

	public void setUsers(List<HomeUser> users) {
		this.users = users;
	}

	public HomeUsers() {
		this.users = new ArrayList<HomeUser>();
	}
	
	public void getAllHomeUsers() {
		System.out.println("Shhhhh we're looking for users");
		
		this.createConnection();
		
		String q = "select username from user";
		
		try {
			Statement  stmt  = this.conn.createStatement();
			ResultSet result = null;
			
			try {
				System.out.println( "Query: " + q ); //TODO move to log
				//stmt.executeUpdate( q );
				result = stmt.executeQuery(q);
			} catch(SQLException e) {
				//basically "what went wrong this time?!"
				System.out.println( "SQLException: " + e.getMessage() );
				System.out.println( "SQLState:     " + e.getSQLState() );
				System.out.println( "VendorError:  " + e.getErrorCode() );
			}
			

			while( result.next() ) {
				
				//map.put(Integer.parseInt(result.getString("id")) ,h_file);
				//last_id = result.getString("id");
				/* End Debug Loop **/
				this.users.add(new HomeUser(result.getString("username")));
				
				System.out.println("Adding:: "+result.getString("username"));
			}
		} catch( Exception e ) {
			System.out.println( "Something broke... in HomeUsers" );
			System.out.println( "SQLException " + e.getMessage() );
			e.printStackTrace();
		}
		
		this.closeConnection();
	}
	
}
