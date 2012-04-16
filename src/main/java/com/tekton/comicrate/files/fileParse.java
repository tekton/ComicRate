/**
 * 
 * This class is really only for the "home server" edition where people would be keeping their personal files of owned printed comics
 * 
 */

package com.tekton.comicrate.files;

import java.io.File;
import java.util.ArrayList;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

//import com.tekton.comicrate.forms.Comic;

import java.sql.Connection;
//import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.ResultSet;

public class fileParse {
	public String path;
	public String indent;
	public File dir;
	
	public String comic;
	public String num;
	public String type;
	public String year;
	public String volume;
	
	public String file;
	
	public Integer dBug;
	
	public Connection conn;
	
	List<fileParse> files= new ArrayList<fileParse>();
	
	// TODO: create function that can setup the table in question if the schema exists
	
	//TODO: create constructor to "" out things
	/**
	 * Default/preferred constructor
	 * @param path The path of where the file/folder is
	 * @param indent How far indented it should be based on the original file
	 * @param conn The connection to the database that's being used
	 */
	public fileParse(String path, String indent, Connection conn) {
		this.path = path;
		this.indent = indent;
		//this.files = files;
		this.conn = conn;
		
		this.file = "";
		
		this.comic= "";
		this.num = "";
		this.type = "";
		this.year = "";
		this.volume = "";
		
		this.dBug = 0;
	}

	/**
	 * A very confused fallback constructor, should really use "fileParse(String path, String indent, Connection conn)"
	 * Could use if created/constructing a file that's not in a normal location...
	 * 
	 * ...or from a script that goes through and adds lots of files all at once.
	 * 
	 * @param conn Database connection to be used...
	 */
	public fileParse(Connection conn) {
		this.conn = conn;
		
		this.path = "";
		this.indent = "";
		this.file = "";
		this.comic= "";
		this.num = "";
		this.type = "";
		this.year = "";
		this.volume = "";
		this.dBug = 0;
	}
	
	/**
	 * really shouldn't be used, but it's in here just in case...
	 * 
	 * @deprecated
	 * @param path The path to the file/folder
	 */
	public fileParse(String path) {
		this.path = path;
		this.indent = "";
		
		this.file = "";
		
		this.comic= "";
		this.num = "";
		this.type = "";
		this.year = "";
		this.volume = "";
		
		this.dBug = 0;
	}	
	
	public String getPath() {
		return path;
	}

	public void setPath(String path) {
		this.path = path;
	}

	public String getIndent() {
		return indent;
	}

	public void setIndent(String indent) {
		this.indent = indent;
	}

	public File getDir() {
		return dir;
	}

	public void setDir(File dir) {
		this.dir = dir;
	}

	public String getComic() {
		return comic;
	}

	public void setComic(String comic) {
		this.comic = comic;
	}

	public String getNum() {
		return num;
	}

	public void setNum(String num) {
		this.num = num;
	}

	public String getType() {
		return type;
	}

	public void setType(String type) {
		this.type = type;
	}

	public String getYear() {
		return year;
	}

	public void setYear(String year) {
		this.year = year;
	}

	public String getVolume() {
		return volume;
	}

	public void setVolume(String volume) {
		this.volume = volume;
	}

	public String getFile() {
		return file;
	}

	public void setFile(String file) {
		this.file = file;
	}

	public Integer getdBug() {
		return dBug;
	}

	public void setdBug(Integer dBug) {
		this.dBug = dBug;
	}

	public Connection getConn() {
		return conn;
	}

	public void setConn(Connection conn) {
		this.conn = conn;
	}

	/****
	 * 
	 * The "main brain" of the entire thing, it's why you call this class!
	 */
	public void y() {
		File dir = new File(this.path);
		
		String[] children = dir.list();
		
		//because we need this to be a little recursive we'll check to see if it has children
		//if there's no children then it's a child! but we'll double check later on anyway...
		if (children == null) {
		    // Either dir does not exist or is not a directory
			if(dir.isFile() == true) {
				//System.out.println( dir.toString() ); //DBUG
				
				this.dir = dir;
				//fill out the info for all the other "columns"
				this.parse_brain();
				this.report();
				
				//put it in the DB!
				// TODO: move this out of here so that items can be re-parsed and then updated easier
				this.send_to_mysql();
			}
		} else {
			//since we're looking for children, and it looks like this has some, lets make like a good parent and make another...
		    for (int i=0; i<children.length; i++) {
		        // Get filename of file or directory
		    	// ...create a new item of the same time and throw in the next indent to make it pretty in the console
		    	
		        //String filename = children[i];  //DBUG
		    	//System.out.println(this.indent+children[i]); //DBUG
		    	
		    	fileParse f = new fileParse(this.path+"\\"+children[i], this.indent+"\t", this.conn);
		    	f.y();
		    }
		}
	}
	
	/**
	 * All of the basics, including removing cruft characters
	 */
	public void parse_brain() {
		String f = this.dir.getName();
		//Comic c = new Comic();
		
		//get the extension of the file
		int mid= f.lastIndexOf(".");
		this.type = f.substring(mid+1,f.length());
		this.file = f.substring(0, mid);
		
		//strip multi space, #, and _ from file name to make parsing easier
		this.file = this.file.replaceAll("_", " ");
		this.file = this.file.replaceAll("#", " ");
		this.file = this.file.replaceAll("  ", " ");
		//System.out.println(this.type);
		
		//parse out all the other data...
		this.find_version();
		this.find_year();
		this.find_comicAndNum();
		
		/*
		c.setTitle(this.comic);
		c.setIssue_number(this.num);
		c.putComicInDB();
		*/
		//put it in the DB!
		// TODO: move this out of here so that items can be re-parsed and then updated easier
		// this.send_to_mysql(); //moved to y for now
	}
	
	/**
	 * Find the version (or volume) of the selected file
	 */
	public void find_version() {
		//find [(| ](v|V\d+[ |)]
		String volMatch = "[\\( ][v|V](\\d+?)[ \\)]";
		Pattern pattern = Pattern.compile(volMatch);
		Matcher matcher = pattern.matcher(this.file);
		
		while (matcher.find()) {
			if(this.dBug > 0) {
				System.out.println(this.file);
				System.out.print("Found a match: " + matcher.group());
				System.out.print(" -- Start position: " + matcher.start());
				System.out.print(" -- End position: " + matcher.end());
				System.out.print("\n");
			}
			this.volume = matcher.group(1);
			
			//remove the "volume" from the file name to make other parsing easier later on
			this.file = this.file.replaceFirst(matcher.group(), " ");
		}
		
	}
	
	/**
	 * Find the year in format \d\d\d\d in the file name
	 */
	public void find_year() {
		String yrMatch = "\\((\\d{4})\\)";
		Pattern pattern = Pattern.compile(yrMatch);
		Matcher matcher = pattern.matcher(this.file);
		
		while (matcher.find()) {
			if(this.dBug > 0) {
				System.out.println(this.file);
				System.out.print("Found a match: " + matcher.group(1));
				System.out.print(" -- Start position: " + matcher.start());
				System.out.print(" -- End position: " + matcher.end());
				System.out.print("\n");
			}
			this.year = matcher.group(1);
		}
	}

	/**
	 * The is the most basic and important of information
	 */
	public void find_comicAndNum() {
		//seperate the comic, number, and cruft
		String regex = "(.*?)[\\(\\[](.*)";
		String complex_redux = "";
		Pattern pattern = Pattern.compile(regex);
		Matcher matcher = pattern.matcher(this.file);
		
		while (matcher.find()) {
			if(this.dBug > 0) {
				System.out.println(this.file);
				System.out.print("Found a match: " + matcher.group(1));
				System.out.print(" -- Start position: " + matcher.start());
				System.out.print(" -- End position: " + matcher.end());
				System.out.print("\n");
			}
			complex_redux = matcher.group(1);
		}
		
		//at this point we should have something that's "comic name" \s and then comic number
		regex = "(.*)\\s(\\d+)";
		pattern = Pattern.compile(regex);
		matcher = pattern.matcher(complex_redux);
		
		while (matcher.find()) {
			if(this.dBug > 0) {
				System.out.println(this.file);
				System.out.print("Found a match: " + matcher.group(1));
				System.out.print(" NUM: " + matcher.group(2));
				System.out.print("\n");
			}
			this.comic = matcher.group(1);
			
			if(matcher.group(2) != "") {
				this.num = matcher.group(2);
			} else {
				this.num = "0";
			}
		}
		
		//if there's no obvious number then just return the whole original string anyway
		if(this.comic == "") {		
			if(complex_redux == "") {
				this.comic = this.file;
			} else {
				this.comic = complex_redux;
			}
		}
	}
	
	/**
	 * Test the setup to make sure things will actually work
	 */
	public void test_mysql() {
		
		String q = "SELECT * from comic_files";
		
        try {
            // The newInstance() call is a work around for some broken Java implementations according to documentation...
            Class.forName("com.mysql.jdbc.Driver").newInstance();
        } catch (Exception ex) {
            // handle the error
        }
        
        try {
            //conn = DriverManager.getConnection("jdbc:mysql://localhost/comicrate?user=root&password=Blizzard1");
			Statement  stmt = conn.createStatement();
			ResultSet result = null;
            // Do something with the Connection
			try {
				System.out.println( "Query: " + q );
				//stmt.executeUpdate( q );
				result = stmt.executeQuery(q);
			} catch(SQLException e) {
				//basically "what went wrong this time?!"
				System.out.println( "SQLException: " + e.getMessage() );
				System.out.println( "SQLState:     " + e.getSQLState() );
				System.out.println( "VendorError:  " + e.getErrorCode() );
			}
			
			while( result.next() ) {				
				//id, round, upper, lower
				String	id = result.getString(  "id" );
				String 	round = result.getString("path");
				String	upper = result.getString("comic");
				String	lower = result.getString("number");
				
				System.out.println( id + "   " + round + " " + upper + " " + lower);

			}
           
        } catch (SQLException ex) {
            // handle any errors
            System.out.println("SQLException: " + ex.getMessage());
            System.out.println("SQLState: " + ex.getSQLState());
            System.out.println("VendorError: " + ex.getErrorCode());
        }
        
	}

	/**
	 * 
	 * Now to send all this recursive data to a database, in this case, MySQL!
	 * 
	 * We'll use prepared statements to make some escaping a little easier, more will need to be done to make it "safer"
	 * TODO: add more secure escaping
	 * TODO: remove connection variables from code to somewhere else
	 */
	
	public void send_to_mysql() {
		//leaving un-needed variables for personal documentation sake
		//String q = "";
		
		String sql = "INSERT INTO comic_files (`path`, `comic`, `number`, `type`, `year`, `volume`) VALUES(?,?,?,?,?,?)";

		//String rtn_str = "";
		int s = 0;

		@SuppressWarnings("unused") //it really does get used later on, but mainly for debugging...
		int autoIncKeyFromApi = -1;
		
		try {
            // The newInstance() call is a work around for some broken Java implementations according to documentation...
            Class.forName("com.mysql.jdbc.Driver").newInstance();
        } catch (Exception ex) {
            // handle the error
        }
        
        try {
    		PreparedStatement pst = null;
            //conn = DriverManager.getConnection("jdbc:mysql://localhost/comicrate?user=root&password=Blizzard1");
    		//Statement  stmt = conn.createStatement();
    		ResultSet result = null;
    		
    		//this will take all those ? in 'sql' and make them mean something!
    		pst = conn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS);
			pst.setString(1, this.path);
			pst.setString(2, this.comic);
			//since the num is an int in the DB it can't be blank!
			if(this.num=="" || this.num == null) {
				pst.setString(3, "0");
			} else {
				pst.setString(3, this.num);
			}

			pst.setString(4, this.type);
			//since the year is an int in the DB it can't be blank!
			if(this.year=="" || this.year == null) {
				pst.setString(5, "0");
			} else {
				pst.setString(5, this.year);
			}
			
			pst.setString(6, this.volume);
    		
            // Going to try to use the connection and all of the things we've compiled above to throw things in the db
			// the only thing we need "returned" is if there was an ID created for the entry, if there was we were successful! in theory...
			try {
				//System.out.println( pst.toString() );
				s = pst.executeUpdate();
				result = pst.getGeneratedKeys();
			} catch(SQLException e) {
				//basically "what went wrong this time?!"
				System.out.println( pst.toString() );
				System.out.println( "SQLException: " + e.getMessage() );
				System.out.println( "SQLState:     " + e.getSQLState() );
				System.out.println( "VendorError:  " + e.getErrorCode() );
			}
			
			if(s > 0) {
				//System.out.println("It's in there! Should redirect to that view...");
				
				if(result.next()) {
					autoIncKeyFromApi = result.getInt(1);
					//System.out.println("Key returned from getGeneratedKeys(): " + autoIncKeyFromApi);
					//return;
				} else {
					System.out.println("No ID returned?!");
				}
			} else {
				System.out.println("Dude, it didn't go in...");
			}
           
        } catch (SQLException ex) {
            // handle any errors
            System.out.println("SQLException: " + ex.getMessage());
            System.out.println("SQLState: " + ex.getSQLState());
            System.out.println("VendorError: " + ex.getErrorCode());
        }
	}
	
	/**
	 * Used from time to time for debugging of the entire line
	 * TODO: output to log file(s) instead
	 */
	public void report() {
		//System.out.print(this.file+" | ");
		//System.out.print(this.path+" | ");
		System.out.print(this.comic+" | ");
		System.out.print(this.num+" | ");
		System.out.print(this.volume +" | ");
		System.out.print(this.year+" | ");
		//System.out.print(this.type+" | ");
		System.out.print("\n");
	}
	
	/**
	 * Part of the install series; NYI
	 */
	public void create_table() {
		/*CREATE TABLE `comic_files` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  `path` varchar(255) DEFAULT NULL,

  `comic` varchar(255) DEFAULT NULL,

  `number` int(11) DEFAULT NULL,

  `type` varchar(45) DEFAULT NULL,

  `year` int(11) DEFAULT NULL,

  `volume` varchar(45) DEFAULT NULL,

  `dBug` varchar(45) DEFAULT '0',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=37396 DEFAULT CHARSET=utf8*/
	}
}