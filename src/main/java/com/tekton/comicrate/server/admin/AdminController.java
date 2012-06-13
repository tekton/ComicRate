package com.tekton.comicrate.server.admin;

import java.sql.SQLException;
import java.sql.Statement;
import java.sql.ResultSet;
//import java.sql.ResultSetMetaData; //left in for debugging reasons
import java.sql.PreparedStatement;

import javax.servlet.http.HttpServletRequest;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.SessionAttributes;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.ResponseBody;

import org.springframework.ui.Model;


import com.tekton.comicrate.SQLController;
import com.tekton.comicrate.forms.Comic;
import com.tekton.comicrate.server.admin.NewComicsController;

/**
 * 
 * A controller/mapper for all the things that should be found under the /admin/ section of things
 * 
 * Comic editing - year, volume, publisher, etc
 * @note Comic file editing is under the HomeFilesController
 * 
 * Config - home install vs server install
 * 	If it's a home install, everything for talking to the server should be here, too
 * 		:: server uri, username, password
 * 	Add, edit, delete options/configurations
 * 
 * Users - basic modifications
 * 
 * @author tekton
 *
 */
@Controller
@SessionAttributes
public class AdminController extends SQLController {

	@RequestMapping(value="/admin", method=RequestMethod.GET)
	public String slashAdmin() {
		return "admin";
	}

	@RequestMapping(value="/admin/increment", method=RequestMethod.GET)
	public String admin_increment_all(Model model) {
		System.out.println("/admin/increment/ called, processing...");
		this.createConnection();
		Comic comic = new Comic(this.conn);
		String q = "select title, year, max(issue_number) as issue_number, max(do_not_increment) as do_not_increment, New52, publisher from comic group by title having do_not_increment IS NULL OR do_not_increment = 0";
		try {
			PreparedStatement pst = this.conn.prepareStatement(q, Statement.RETURN_GENERATED_KEYS);
			this.inc_comic(pst, model, comic, "inc");
		} catch(SQLException e) {
			
		}
		
		System.out.println("/admin/increment/ winding down...");
		this.closeConnection();
		return "admin";
	}

	@RequestMapping(value="/admin/increment/{series}", method=RequestMethod.GET)
	public String admin_increment_series(Model model, @PathVariable("series") String series) {
		this.createConnection();
		Comic comic = new Comic(this.conn);
		String q = "select title, year, max(issue_number) as issue_number, max(do_not_increment) as do_not_increment, New52, publisher from comic " +
				"where title=?"+
				"group by title having do_not_increment IS NULL OR do_not_increment = 0";
		
		try {
			PreparedStatement pst = this.conn.prepareStatement(q, Statement.RETURN_GENERATED_KEYS);
			pst.setString(1, series);
			this.inc_comic(pst, model, comic, "inc");
		} catch(SQLException e) {
			
		}
		
		this.closeConnection();
		return "admin";
	}
	
	@RequestMapping(value="/admin/increment/{series}/{val}", method=RequestMethod.GET)
	public String admin_increment_book_to_val(Model model, @PathVariable("series") String series, @PathVariable("val") String val) {
		this.createConnection();
		Comic comic = new Comic(this.conn);
		comic.setTitle(series);
		//get the highest numbered version of said book to set later...
		String q = "select title, year, max(issue_number) as issue_number, max(do_not_increment) as do_not_increment, New52, publisher from comic where title = ?";
		try {
			PreparedStatement pst = this.conn.prepareStatement(q);
			pst.setString(1, series);
			this.inc_comic(pst, model, comic, val);
		} catch(SQLException e) {
			
		}

		this.closeConnection();
		model.addAttribute("success", "true");
		return "admin";
	}
	
	public Boolean inc_comic(PreparedStatement pst, Model model, Comic comic, String val) {
		System.out.println("inc_comic:: "+val);
		NewComicsController ncc = new NewComicsController();
		Integer s = 0;
		try {
			//PreparedStatement pst = null;
			ResultSet result = null;
			
			try {
				System.out.println( pst.toString() );
				result = pst.executeQuery();			
			} catch (SQLException e) {
				System.out.println("admin_increment_book_to_val hates you in the sql");
				System.out.println( "SQLException: " + e.getMessage() );
				System.out.println( "SQLState:     " + e.getSQLState() );
				System.out.println( "VendorError:  " + e.getErrorCode() );
				this.closeConnection();
				model.addAttribute("success", "fail");
				return false;
			}
			
				//check if result returned anything, if not give it a comic...
			
				String start = "1";
			
				if( result.isBeforeFirst() == false ){
				    System.out.println("time to make a number one...");
				    /*comic.setIssue_number("1");
				    comic.putComicInDB(); //might as well make it in the DB...
					if(val == "inc") {
						Integer v = 2;
						val = v.toString();
					} 
					comic.setIssue_number(val);
					ncc.process_series_inc(comic, "1");*/
				} else {
					while( result.next() ) {
						if(result.getString("do_not_increment")=="1") {
							this.closeConnection();
							model.addAttribute("success", "do_not_increment");
							return false;
						} else {
							//comic.setTitle(result.getString("title"));
							comic.setYear(result.getString("year"));
							if(result.getString("issue_number") != null && result.getString("issue_number") != "") {
								start = result.getString("issue_number");
							}
							if(val == "inc") {
								Integer v = Integer.parseInt(start) + 1;
								val = v.toString();
							} 
							comic.setIssue_number(val);
							comic.setDo_not_increment(result.getString("do_not_increment"));
							comic.setNew52(result.getString("New52"));
							comic.setPublisher(result.getString("publisher"));
						}	
					}
				}
				
				ncc.process_series_inc(comic, start);
			
		} catch (Exception e) {
			System.out.println("admin_increment_book_to_val hates you");
			System.out.println( "Exception: " + e.getMessage() );
			this.closeConnection();
			model.addAttribute("success", "fail");
			return false;
		}	
		
		return true;
	}
	
	//TODO add series add code; check filename for "of" to set max/do not increment values
	@RequestMapping(value="/admin/new/series", method=RequestMethod.GET)
	public String new_series_blank(Model model) {
		
		return "new_series_blank";
	}
	
	@RequestMapping(value="/admin/new/series/{name}/{number}", method=RequestMethod.GET)
	public String new_series_name(Model model, @PathVariable("name") String name, @PathVariable("number") String number) {
		model.addAttribute("name", name);
		model.addAttribute("number", number);
		return "new_series_name";
	}
	
	@RequestMapping(value="/admin/new/series/{name}/{max}", method=RequestMethod.GET)
	public String new_series_name_max(Model model, @PathVariable("name") String name, @PathVariable("max") String max) {
		//set attributes so that number and max are the same...
		model.addAttribute("name", name);
		model.addAttribute("number", max);
		model.addAttribute("max", max);
		return "new_series_name_max";
	}
	
	@RequestMapping(value="/admin/new/series", method=RequestMethod.POST)
	public String new_series(Model model, HttpServletRequest request) {
		//String name	= request.getParameter("name");
		//String max	= request.getParameter("max");
		//String number	= request.getParameter("number");
		
		return "new_series_blank";
	}
	
}
