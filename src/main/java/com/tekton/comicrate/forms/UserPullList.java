package com.tekton.comicrate.forms;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;

import com.tekton.comicrate.SQLController;;


/**
 * 
 * The "model" for user Reading Lists
 * 
 * @author tekton
 *
 */
public class UserPullList extends SQLController {
	
	public List<String> books;
	public String user;
	
	public List<String> getBooks() {
		return books;
	}

	public void setBooks(List<String> books) {
		this.books = books;
	}

	public String getUser() {
		return user;
	}

	public void setUser(String user) {
		this.user = user;
	}

	public UserPullList() {
		this.books = new ArrayList<String>();
		
		Authentication auth = SecurityContextHolder.getContext().getAuthentication();		
		this.setUser(auth.getName());
		
		this.getUserReadingList();
		//this.user = "";
	}
	
	public UserPullList(String name) {
		this.books = new ArrayList<String>();
		this.setUser(name);
		this.getUserReadingList();
	}
	
	public void getUserReadingList() {
		
		this.createConnection();
		PreparedStatement pst = null;
		ResultSet result = null;
		//prepared statement to get the reading list using the user defined at the start of the model...
		try {	
			String sql = "SELECT * FROM readinglists where user=?";
			pst = this.conn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS);
			pst.setString(1, this.user);
			
			System.out.println(pst.toString());
			
			try {
				result = pst.executeQuery(); 
				System.out.println("Attempting to get reading lists:: " + pst.toString() );
				
				while( result.next() ) {
					
					/* Debug Loop **
					ResultSetMetaData md = result.getMetaData ();
					// Get the number of columns in the result set
					int numCols = md.getColumnCount();
					int i;
					for (i=1; i<=numCols; i++) {
						//if (i > 1) System.out.print(",");
						//System.out.println(md.getColumnLabel(i));
						System.out.println(md.getColumnLabel(i)+" , "+result.getString(md.getColumnLabel(i)));
					}
					*//* End Debug Loop **/
					
					this.books.add(result.getString("series"));
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
	
	public Integer addSeries(String series) {
		this.createConnection();
		
		try {	
			String sql = "INSERT INTO readinglists (`series`,`user`) VALUES (? , ?)";
			PreparedStatement pst = this.conn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS);
			pst.setString(1, series);
			pst.setString(2, this.user);
			
			System.out.println(pst.toString());
			
			try {
				pst.executeUpdate(); 
				System.out.println("Attempting to add series to readinglists:: " + pst.toString() );
				ResultSet rs = pst.getGeneratedKeys(); //this doesn't really matter at the moment...
				if (rs.next()) {
			        return rs.getInt(1);
			    } else {
			    	//do nothing, it will return 0 later like nothing happened...cause it didn't...
			    }
			} catch(SQLException e) {
				//basically "what went wrong this time?!"
				System.out.println( "SQLException: " + e.getMessage() );
				System.out.println( "SQLState:     " + e.getSQLState() );
				System.out.println( "VendorError:  " + e.getErrorCode() );
			}
		
		} catch( Exception e ) {
			System.out.println( "Something broke in COMIC.USER.JAVA during an insert/update" );
			System.out.println( e.getMessage() );
			e.printStackTrace();
		}
		
		this.closeConnection();
		return 0;
	}
	
	public void removeSeries(String series) {
		this.createConnection();
		
		try {	
			String sql = "DELETE FROM readinglists where series=? and user=?";
			PreparedStatement pst = this.conn.prepareStatement(sql);
			pst.setString(1, series);
			pst.setString(2, this.user);
			
			System.out.println(pst.toString());
			
			try {
				pst.executeUpdate(); 
				System.out.println("Attempting to update user setting:: " + pst.toString() );
			} catch(SQLException e) {
				//basically "what went wrong this time?!"
				System.out.println( "SQLException: " + e.getMessage() );
				System.out.println( "SQLState:     " + e.getSQLState() );
				System.out.println( "VendorError:  " + e.getErrorCode() );
			}
		
		} catch( Exception e ) {
			System.out.println( "Something broke in readinglists during a deletion" );
			System.out.println( e.getMessage() );
			e.printStackTrace();
		}
		
		this.closeConnection();
		//we'll just assume everything went well...if it didn't we'll get the error later anyway...or there was nothing to delete...
	}
	
}
