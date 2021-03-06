package com.tekton.comicrate.forms;

import com.tekton.comicrate.forms.Comic;
import com.tekton.comicrate.*;

import java.util.LinkedHashMap;
import java.util.Map;

import java.sql.SQLException;
import java.sql.Statement;
import java.sql.ResultSet;

public class Series extends SQLController {
	public String title;
	public String overall;
	public String art;
	public String story;
	
	public Series() {
		
	}
	
	public Series(String title, String overall, String art, String story) {
		this.setTitle(title);
		this.setOverall(overall);
		this.setArt(art);
		this.setStory(story);
	}
	
	public String getTitle() {
		return title;
	}
	public void setTitle(String title) {
		this.title = title;
	}
	public String getOverall() {
		return overall;
	}
	public void setOverall(String overall) {
		this.overall = overall;
	}
	public String getArt() {
		return art;
	}
	public void setArt(String art) {
		this.art = art;
	}
	public String getStory() {
		return story;
	}
	public void setStory(String story) {
		this.story = story;
	}
	
	public void reportSeries() {
		System.out.println(this.title);
		System.out.println(this.overall);
		System.out.println(this.art);
		System.out.println(this.story);
	}
	
	public void getSeriesDataFromDB() {
		this.createConnection();
		String q = "select c.title, AVG(ur.overall) as overall, AVG(ur.art) as art, AVG(ur.story) as story from user_ratings as ur"+
				"left join comic as c on c.id = ur.comic where c.title = "+this.title+" group by c.title";
		this.processSeriesDataFromDB(q);
		this.closeConnection();
	}
	
	public void getSeriesDataFromDBForUserAll() {
		this.createConnection();
		String user = "";
		String q = "select c.title, AVG(ur.overall) as overall, AVG(ur.art) as art, AVG(ur.story) as story from user_ratings as ur"+
				"left join comic as c on c.id = ur.comic where ur.user = "+user+" group by c.title";
		this.processSeriesDataFromDB(q);
		this.closeConnection();
	}
	
	public void processSeriesDataFromDB(String q) {
		ResultSet result = null;

			try {
				this.createConnection();
				//Connection conn = DriverManager.getConnection( this.CONNECTION_URL );
				Statement  stmt = this.conn.createStatement(); //using name as it's easier when browsing documentation
				
				try {
					System.out.println( "Query: " + q );
					result = stmt.executeQuery(q);
				} catch(SQLException e) {
					//basically "what went wrong this time?!"
					System.out.println( "SQLException: " + e.getMessage() );
					System.out.println( "SQLState:     " + e.getSQLState() );
					System.out.println( "VendorError:  " + e.getErrorCode() );
				}
				
				while( result.next() ) {
					this.setOverall(result.getString("overall"));
					this.setArt(result.getString("art"));
					this.setStory(result.getString("story"));
				}
				this.closeConnection();
			} catch( Exception e ) {
				System.out.println( "Something broke...SEREIES.JAVA" );
				System.out.println( e.getMessage() );
				e.printStackTrace();
			}
	}
	
	public Map<Integer, Comic> sql_stuff(String q) {
		//String CONNECTION_URL = "jdbc:mysql://localhost/comicrate?user=root&password=Blizzard1";

		Map <Integer, Comic> map = new LinkedHashMap <Integer, Comic>();
		Integer y = 0;
		
		try {
			//this.createConnection();
			//Connection conn = DriverManager.getConnection( CONNECTION_URL );
			Statement  stmt = this.conn.createStatement();
			ResultSet result = null;
			
			try {
				System.out.println( "Query: " + q );
				result = stmt.executeQuery(q);
			} catch(SQLException e) {
				//basically "what went wrong this time?!"
				System.out.println( "SQLException: " + e.getMessage() );
				System.out.println( "SQLState:     " + e.getSQLState() );
				System.out.println( "VendorError:  " + e.getErrorCode() );
			}
			

			while( result.next() ) {
				Comic comic = new Comic();
				comic.setId(result.getString("id"));
				comic.getComicFromDB();
				//comic.closeConnection();
				map.put(y, comic);
				y++;
			}
		} catch( Exception e ) {
			System.out.println( "Something broke... sql_stuff series" );
			System.out.println( "SQLException " + e.getMessage() );
			e.printStackTrace();
		}
		//this.closeConnection();
		return map;
	}
}
