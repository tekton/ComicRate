package com.tekton.comicrate.home.admin;

import com.tekton.comicrate.*;
import com.tekton.comicrate.forms.TableRows;

import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.ResultSet;
//import java.sql.ResultSetMetaData; //left in for debugging reasons
import java.sql.PreparedStatement;
import java.util.HashMap;
import java.util.Map;

public class HomeFile extends SQLController {
	public String table = "comic_files";
	
	public String id;
	public String path;
	public String comic;
	public String number;
	public String type;
	public String year;
	public String volume;
	public String dBug;
	public String parent_book_local;
	public String parent_book_server;
	public String book_status;
	public String link_disp;
	public Map<Integer,TableRows> rows;
	
	public String getTable() {
		return table;
	}
	public void setTable(String table) {
		this.table = table;
	}
	public String getId() {
		return id;
	}
	public void setId(String id) {
		this.id = id;
		this.update_table_row_value("id", id);
	}
	public String getPath() {
		return path;
	}
	public void setPath(String path) {
		this.path = path;
		this.update_table_row_value("path", path);
	}
	public String getComic() {
		return comic;
	}
	public void setComic(String comic) {
		this.comic = comic;
		this.update_table_row_value("comic", comic);
	}
	public String getNumber() {
		return number;
	}
	public void setNumber(String number) {
		this.number = number;
		this.update_table_row_value("number", number);
	}
	public String getType() {
		return type;
	}
	public void setType(String type) {
		this.type = type;
		this.update_table_row_value("type", type);
	}
	public String getYear() {
		return year;
	}
	public void setYear(String year) {
		this.year = year;
		this.update_table_row_value("year", year);
	}
	public String getVolume() {
		if(this.volume == "" || this.volume == null) {
			return null;
		} else {
			return volume;
		}
	}
	public void setVolume(String volume) {
		this.volume = volume;
		this.update_table_row_value("volume", volume);
	}
	public String getdBug() {
		return dBug;
	}
	public void setdBug(String dBug) {
		this.dBug = dBug;
		this.update_table_row_value("dBug", dBug);
	}
	public String getParent_book_local() {
		if(this.parent_book_local == "" || this.parent_book_local == null) {
			return null;
		} else {
			return parent_book_local;
		}
	}
	public void setParent_book_local(String parent_book_local) {
		this.parent_book_local = parent_book_local;
		this.update_table_row_value("parent_book_local", parent_book_local);
	}
	public String getParent_book_server() {
		if(this.parent_book_server == "" || this.parent_book_server == null) {
			return null;
		} else {
			return parent_book_server;
		}
	}
	public void setParent_book_server(String parent_book_server) {
		this.parent_book_server = parent_book_server;
		this.update_table_row_value("parent_book_server", parent_book_server);
	}
	public String getBook_status() {
		if(this.book_status == "" || this.book_status == null) {
			return null;
		} else {
			return book_status;
		}
	}
	public void setBook_status(String book_status) {
		this.book_status = book_status;
		this.update_table_row_value("book_status", book_status);
	}
	
	public Map<Integer, TableRows> getRows() {
		return rows;
	}
	public void setRows(Map<Integer, TableRows> rows) {
		this.rows = rows;
	}
	
	public String getLink_disp() {
		return link_disp;
	}
	public void setLink_disp(String link_disp) {
		this.link_disp = link_disp;
		
		String[] part = link_disp.split("\\\\");
		String f_name = part[part.length - 1];
		
		if(f_name.length() > 20) {
			this.link_disp = f_name.substring(0, 17)+"...";
		} else {
			this.link_disp = f_name;//.substring(0, 20);
		}
		
		this.update_table_row_value("link_disp", this.link_disp);
	}
	
	
	public HomeFile() {
		//because updating needs a constructor, too!
		System.out.println("A DB connection of some kind will still need to be made..."+
				"I hope you realize that as there's probaly an error coming up...");
		this.rows = new HashMap<Integer,TableRows>();
		this.create_rows();
	}
	
	/**
	 * Get things rolling for the basic data for the file associated with the comic
	 * 
	 * @param conn The connection that's being used for everything else basically...
	 */
	public HomeFile(Connection conn) {
		/* Since Java doesn't really have ref's or pointers, this is "good enough" it would seem... */
		//System.out.println("HomeFile:: Passing a connection to save on connections!");
		
		this.conn = conn;
		this.rows = new HashMap<Integer,TableRows>();
		this.create_rows();
		
		//Authentication auth = SecurityContextHolder.getContext().getAuthentication();
		//this.user = auth.getName(); //get logged in username; we'll be needing that to find the comic...
	}
	
	/**
	 * Create the rows of info for the file that's possible associated with the comic; makes editing easier code wise...
	 */
	public void create_rows() {
		
		//TableRows(String label, String name, String type)
		int i = 0;
		this.rows.put(i,new TableRows("id","id","text")); i++;
		this.rows.put(i,new TableRows("path","path","text")); i++;
		this.rows.put(i,new TableRows("comic","comic","text")); i++;
		this.rows.put(i,new TableRows("number","number","text")); i++;
		this.rows.put(i,new TableRows("type","type","text")); i++;
		this.rows.put(i,new TableRows("year","year","text")); i++;
		this.rows.put(i,new TableRows("volume","volume","text")); i++;
		this.rows.put(i,new TableRows("dBug","dBug","text")); i++;
		this.rows.put(i,new TableRows("parent_book_local","parent_book_local","text")); i++;
		this.rows.put(i,new TableRows("parent_book_server","parent_book_server","text")); i++;
		this.rows.put(i,new TableRows("book_status","book_status","text")); i++;
		this.rows.put(i,new TableRows("link_disp","link_disp","text")); i++;
	
	}
	
	public void update_table_row_value(String row, String val) {
		for(int i = 0; i < this.rows.size(); i++) {
			TableRows x = this.rows.get(i);
			if(x.name.equals(row)) {
				//set val to an empty string instead of a null string for easier parsing later...
				if(val == null) {
					val = "";
				}
				this.rows.get(i).value = val;
			}
		}
	}

	public void report_rows() {
		for(int i = 0; i < this.rows.size(); i++) {
			TableRows x = this.rows.get(i);
			System.out.println(x.name + " | " +x.value);
		}		
	}
	
	public void getFileFromDB() {
		//take the info in "this" to search and populate data
		// TODO: Add "comic_exists" flag tracking somewhere in here...
		try {
			//Class.forName( "com.mysql.jdbc.Driver" ).newInstance();
			
			//create a local version of the connection which should be released when the function is done
			Connection conn = this.conn;
			Statement  stmt = conn.createStatement();
			ResultSet result = null;
			
			//create a query to get the comic info and the user opinions
			String q = "SELECT *"
					+" FROM comic_files as c"
					+" where c.id = '"+this.id+"'";
			
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
				this.setId(result.getString("id"));
				this.setPath(result.getString("path"));
				this.setLink_disp(result.getString("path"));
				this.setComic(result.getString("comic"));
				this.setNumber(result.getString("number"));
				this.setType(result.getString("type"));
				this.setYear(result.getString("year"));
				this.setVolume(result.getString("volume"));
				this.setdBug(result.getString("dBug"));
				this.setParent_book_local(result.getString("parent_book_local"));
				this.setParent_book_server(result.getString("parent_book_server"));
				this.setBook_status(result.getString("book_status"));
			}
		} catch( Exception e ) {
			System.out.println( "Something broke in HOMEFILE.JAVA" );
			System.out.println( e.getMessage() );
			e.printStackTrace();
		}
	}
	
	/**
	 * Code for updating the information about the table on the users system
	 */
	public void updateInLocalDB() {
		//take the info in "this" and create an entry
		//need to check for exceptions, like it already exists!
		// TODO: clean up and fix collision issues
		Integer s = 0;
		
		try {
			Class.forName( "com.mysql.jdbc.Driver" ).newInstance();
			Connection conn = this.conn;
			
			PreparedStatement pst = null;
			
			String sql = "UPDATE comic_files SET "+
					"path=?, comic=?, number=?, type=?, year=?, volume=?, dBug=?, parent_book_local=? , parent_book_server=?, book_status=?"+
							" WHERE id=?";
			pst = conn.prepareStatement(sql);
			pst.setString(1, this.getPath());
			pst.setString(2, this.getComic());
			pst.setString(3, this.getNumber());
			pst.setString(4, this.getType());
			pst.setString(5, this.getYear());
			pst.setString(6, this.getVolume());
			pst.setString(7, this.getdBug());
			pst.setString(8, this.getParent_book_local());
			pst.setString(9, this.getParent_book_server());
			pst.setString(10, this.getBook_status());
			pst.setString(11, this.getId());

			
			try {
				System.out.println(pst.toString());
				s = pst.executeUpdate();
			} catch(SQLException e) {
				//basically "what went wrong this time?!"
				System.out.println( "SQLException: " + e.getMessage() );
				System.out.println( "SQLState:     " + e.getSQLState() );
				System.out.println( "VendorError:  " + e.getErrorCode() );
			}
			
			if(s > 0) {
				System.out.println("It's UPDATED! Will redirect to that view...");
			} else {
				System.out.println("Dude, it didn't go in...a horrible looking error will be thrown now. GG.");
			}
			
		} catch( Exception e ) {
			System.out.println( "Something broke...HomeFile :: updateInLocalDB" );
			System.out.println( e.getMessage() );
			e.printStackTrace();
		}
	}
	
}
