package com.tekton.comicrate.forms;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;

import com.tekton.comicrate.SQLController;
import com.tekton.comicrate.forms.Series;

/**
 * 
 * A place for the reporting and manipulation of all the series that the user has rated...
 * 
 * @author tekton
 *
 */
public class UserSeries extends SQLController {

	public List<Series> series;
	
	public UserSeries() {
		this.series = new ArrayList<Series>();
	}
	
	public void getSeriesDataFromDBForUserAll() {
		
		Authentication auth = SecurityContextHolder.getContext().getAuthentication();
		String user = auth.getName(); //get logged in username; we'll be needing that to find the comic...

		String q = "select c.title, AVG(ur.overall) as overall, AVG(ur.art) as art, AVG(ur.story) as story from user_ratings as ur "+
				"left join comic as c on c.id = ur.comic where ur.user = ? group by c.title";

		this.createConnection();
		PreparedStatement pst = null;
		ResultSet result = null;
		//prepared statement to get the reading list using the user defined at the start of the model...
		try {	

			pst = this.conn.prepareStatement(q);
			pst.setString(1, user);
			
			System.out.println(pst.toString());
			
			try {
				result = pst.executeQuery(); 
				System.out.println("Attempting to get reading lists:: " + pst.toString() );
				
				while( result.next() ) {	
					this.series.add(new Series(
							result.getString(1),
							result.getString(2),
							result.getString(3),
							result.getString(4))
					);
				}
				
			} catch(SQLException e) {
				//basically "what went wrong this time?!"
				System.out.println( "SQLException: " + e.getMessage() );
				System.out.println( "SQLState:     " + e.getSQLState() );
				System.out.println( "VendorError:  " + e.getErrorCode() );
			}
		
		} catch( Exception e ) {
			System.out.println( "Something broke in READING_LISTS on the get" );
			System.out.println( e.getMessage() );
			e.printStackTrace();
		}
		
		this.closeConnection();
	}
	
	public void getRatingDataAll() {
		
	}
}
