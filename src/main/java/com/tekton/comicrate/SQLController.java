/*
 * 
 * The SQL heart of the application
 * 
 * Until I have time to not be coding and instead be the admin, this will remain.
 * 
 * Function: to provide a single place for connection to databases
 * 
 * Goals: to remove the current functionality and move to JDBC connection pools
 * 
 */

package com.tekton.comicrate;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class SQLController {
	public Connection conn;
	public String CONNECTION_URL = "jdbc:mysql://localhost/comicrate?user=comicrate&password=Blizzard1";
	//public String CONNECTION_URL = "jdbc:mysql://mysql.tektonsnow.com/comicrate?user=comicrate&password=Blizzard1";
	
	/** 
	 * Given the limited nature of this application connection can be made and closed in rapid succession and it's not so bad on the DB really
	 * This allows them to be created quickly from any app that extends this class
	 *  
	 *  */
	public void createConnection() {
		try {
			Class.forName( "com.mysql.jdbc.Driver" ).newInstance();
			this.conn = DriverManager.getConnection(this.CONNECTION_URL);
		} catch( Exception e ) {
			System.out.println( "SQLController Connection Didn't work" );
			System.out.println( e.getMessage() );
			e.printStackTrace();
		} 
	}
	
	/** 
	 * 
	 * 
	 * Close out the connection and set everything to null...just to be sure...
	 * 
	 * **/
	public void closeConnection() {
		try {
			this.conn.close();
		} catch (SQLException e) {
            // ignore -- as we can't do anything about it here
			// on second though, lets go ahead and figure out what failed...
			System.out.println( "SQLController closeConnection didn't work" );
			System.out.println( e.getMessage() );
			e.printStackTrace();
        }
        try {
        	this.conn = null;
        } catch (Exception e) {
        	//given all the problems I used to have with connections releasing, this is handy
			System.out.println( "SQLController closeConnection null didn't work" );
			System.out.println( e.getMessage() );
			e.printStackTrace();        	
        }
	}
	
}
