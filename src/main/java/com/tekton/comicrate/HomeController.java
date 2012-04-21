package com.tekton.comicrate;

import java.text.DateFormat;
import java.util.Date;
import java.util.LinkedHashMap;
import java.util.Locale;
import java.util.Map;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
//import org.springframework.validation.BindingResult;
//import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;

import java.sql.SQLException;
import java.sql.Statement;
import java.sql.ResultSet;

import com.tekton.comicrate.forms.Comic;
//import com.tekton.comicrate.forms.NewUser;

/**
 * Handles requests for the application home page.
 */
@Controller
public class HomeController extends SQLController {
	
	private static final Logger logger = LoggerFactory.getLogger(HomeController.class);
	
	/**
	 * Simply selects the home view to render by returning its name.
	 */
	@RequestMapping(value = "/", method = RequestMethod.GET)
	public String home(Locale locale, Model model) {
		logger.info("Welcome home! the client locale is "+ locale.toString());
		
		Date date = new Date();
		DateFormat dateFormat = DateFormat.getDateTimeInstance(DateFormat.LONG, DateFormat.LONG, locale);
		
		String formattedDate = dateFormat.format(date);
		
		model.addAttribute("serverTime", formattedDate );
		//model.addAttribute(map_name, map);
		
		this.createConnection();
		
		Authentication auth = SecurityContextHolder.getContext().getAuthentication();
		String user = auth.getName(); //get logged in username; we'll be needing that to find the comic...
		
		model.addAttribute("five", sql_stuff("SELECT comic as id from user_ratings WHERE user='"+user+"' ORDER BY last_updated DESC limit 5;"));
		
		model.addAttribute("highest", sql_stuff("SELECT comic as id, avg(overall) from user_ratings group by comic ORDER BY overall DESC limit 5"));
		
		model.addAttribute("norate", sql_stuff("SELECT left_tbl.* FROM  comic as left_tbl LEFT JOIN user_ratings as right_tbl ON left_tbl.id = right_tbl.comic WHERE right_tbl.comic IS NULL ORDER BY last_updated desc, issue_number asc, ID desc LIMIT 5"));
		
		this.closeConnection();
		
		return "home";
	}
	
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
				logger.info( "what went wrong this time?!");
				logger.info( "SQLException: " + e.getMessage() );
				logger.info( "SQLState:     " + e.getSQLState() );
				logger.info( "VendorError:  " + e.getErrorCode() );
				
				return map;
			} catch(NullPointerException e) {
				logger.info( "Null pointer on the DB in HomeController");
				
				return map;
			}
			

			while( result.next() ) {
				Comic comic = new Comic(this.conn);
				comic.setId(result.getString("id"));
				comic.getComicFromDB();
				comic.validate_to_zero();
				map.put(y, comic);
				comic.reportComic();
				y++;
			}
			
		} catch(NullPointerException e) {
			logger.info( "Null pointer on the outter DB in HomeController");
			
			return map;
		} catch(SQLException e) {
			//basically "what went wrong this time?!"
			logger.info( "stmt or result set not working right");
			logger.info( "SQLException: " + e.getMessage() );
			logger.info( "SQLState:     " + e.getSQLState() );
			logger.info( "VendorError:  " + e.getErrorCode() );
			
			return map;
		}
		
		return map;
	}
	
}
