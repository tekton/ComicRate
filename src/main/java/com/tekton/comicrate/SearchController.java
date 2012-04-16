/*
 * 
 * URI Brain for Searches
 * 
 */

package com.tekton.comicrate;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.LinkedHashMap;
import java.util.Locale;
import java.util.Map;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.SessionAttributes;

import com.tekton.comicrate.SQLController;
import com.tekton.comicrate.forms.Comic;
import com.tekton.comicrate.forms.Search;

import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;

@Controller
@SessionAttributes
public class SearchController extends SQLController {
	//creating search context
	public String user;
	
	//just need to show the basic form
	@RequestMapping(value="/search/", method=RequestMethod.GET)
	public String compileSearchStr(Model model, Locale locale) {
		//model.addAttribute("serverTime", serverTime(locale, model));
		//System.out.println(x);
		return "search";
	}
	
	
	//process what was requested
	// TODO: add in other 
	@RequestMapping(value="/search/results", method=RequestMethod.POST)
	public String compileSearchStr(@ModelAttribute("search") Search search, BindingResult result, Model model, Locale locale) {

		/* Will add comments later...somehow this is the only function not leaking stuff */
		
		this.createConnection();
		
		Authentication auth = SecurityContextHolder.getContext().getAuthentication();
		this.user = auth.getName(); //get logged in username; we'll be needing that to find the comic...
		
		search.setTable("comic");
		
		String q = search.constructQuery();
		
		model.addAttribute("results", this.sql_stuff(q));
		
		String[] cols = new String[] {
				"overall",
				"story",
				"art",
				"overall_avg",
				"story_avg",
				"art_avg"
		};
		model.addAttribute("cols", cols);
		
		this.closeConnection();
		return "search_results";
	}
	
	//this is for testing, anything shown or returned on this won't really work out
	@RequestMapping(value="/search/test", method=RequestMethod.GET)
	public String searchTest(Model model, Locale locale) {

		Authentication auth = SecurityContextHolder.getContext().getAuthentication();
		this.user = auth.getName(); //get logged in username; we'll be needing that to find the comic...
		
		this.createConnection();
		this.closeConnection();

		return "search";
	}
	
	// like other classes that have this, it's local to this function just in case other things are needed
	// one day they will probably all be consolidated, but that's not today 
	public Map<Integer, Comic> sql_stuff(String q) {
		Map <Integer, Comic> map = new LinkedHashMap <Integer, Comic>();
		Integer y = 0;
		
		try {
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
				Comic comic = new Comic(this.conn);
				comic.setId(result.getString("id"));
				comic.getComicFromDB();
				map.put(y, comic);
				y++;
				
			}
		} catch( Exception e ) {
			System.out.println( "Something broke... sql_stuff in SearchController" );
			System.out.println( "SQLException " + e.getMessage() );
			e.printStackTrace();
		}
		return map;
	}
	
}
