/*
 * 
 * One of the cornerstones of comics: the series
 * 
 * Function: Provide a logic wrapper for getting series data
 * 
 */

package com.tekton.comicrate;

import com.tekton.comicrate.forms.Comic;
import com.tekton.comicrate.SQLController;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.SessionAttributes;
import org.springframework.ui.Model;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import java.util.LinkedHashMap;
import java.util.Locale;
import java.util.Map;

@Controller
@SessionAttributes
public class SeriesController extends SQLController {
	
	/*
	 * To make things easy, just add ID
	 * 
	 * Since the comics are held in one database, and the user ratings in another
	 * 		we can just get the list of ID's and then grab user data later.
	 * 
	 * Given we get the data here, makes sense to also calculate the averages over the whole set and not ping the DB again
	 * 
	 */
	
	@RequestMapping(value="/s/{x}", method=RequestMethod.GET)
	public String showComicViaID(Model model, Locale locale, @PathVariable("x") String x) { //
		
		this.createConnection();
		
		Map <Integer, Comic> map = this.sql_stuff("SELECT * from comic WHERE title=\""+x+"\";");
		
		model.addAttribute("comics", map);
		
		
		System.out.println(map.size()); //debug to help match how many comics were vs should be shown
		
		Double overall_size = 0.00;
		Double art_size = 0.00;
		Double story_size = 0.00;
		
		Double overall_avg = 0.00;
		Double art_avg = 0.00;
		Double story_avg = 0.00;
		
		//Since not all comics may be completely rated, only count those that do for that category
		for(int i=0; i < map.size(); i++) {
			Comic c = map.get(i);
			if(c.overall_avg != "" && c.overall_avg != null) {
				overall_avg += Double.parseDouble(c.overall_avg);
				overall_size++;
			}
			if(c.art_avg != "" && c.art_avg != null) {
				art_avg += Double.parseDouble(c.art_avg);
				art_size++;
			}
			if(c.story_avg != "" && c.story_avg != null) {
				story_avg += Double.parseDouble(c.story_avg);
				story_size++;
			}
			c.validate_to_zero();
		}
		
		overall_avg = overall_avg / overall_size;
		art_avg = art_avg / art_size;
		story_avg = story_avg / story_size;	
		
		model.addAttribute("overall_avg", overall_avg);
		model.addAttribute("art_avg", art_avg);
		model.addAttribute("story_avg", story_avg);
		
		this.closeConnection();
		return "series";
	}


	public Map<Integer, Comic> sql_stuff(String q) {
		/**
		 * 
		 * This is a function name that gets used a lot and is not limited to this class
		 * An Integer is used really for debugging purposes (and probably for a reason that I've 
		 * forgotten since I didn't write enough comments then...)
		 * In order to check SQL Rows and make sorting a little bit easier on the JSP we 
		 * just return things as a map!
		 * 
		 * *
		 */
		
		//Creat the thing that will be returned!
		Map <Integer, Comic> map = new LinkedHashMap <Integer, Comic>();
		Integer y = 0;
		
		try {
			Statement  stmt = this.conn.createStatement();
			ResultSet result = null;
			
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
				Comic comic = new Comic(this.conn);
				comic.setId(result.getString("id"));
				comic.getComicFromDB();
				map.put(y, comic);
				y++;
			}
		} catch( Exception e ) {
			System.out.println( "Something broke... sql_stuff in SeriesController" );
			System.out.println( "SQLException " + e.getMessage() );
			e.printStackTrace();
		}
		return map;
	}
}
