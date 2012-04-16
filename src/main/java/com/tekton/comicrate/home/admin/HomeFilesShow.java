package com.tekton.comicrate.home.admin;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.LinkedHashMap;
import java.util.Locale;
import java.util.Map;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
//import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.SessionAttributes;

//import com.tekton.comicrate.forms.Comic;
import com.tekton.comicrate.SQLController;

import com.tekton.comicrate.forms.Search;
//import com.tekton.comicrate.SearchController;

import com.tekton.comicrate.home.admin.HomeFile;

@Controller
@SessionAttributes
public class HomeFilesShow extends SQLController {
	
	public String table = "comic_files";
	public String path;
	public String c_name;
	public String c_num;
	
	public Map<Integer, HomeFile> show_similar_files(String comic, String num, String parent) {
		this.createConnection();
		this.c_name = comic;
		comic = this.clean_up_comic_name(comic);
		Map<Integer, HomeFile> files = this.sql_stuff("SELECT * from "+this.table+" WHERE comic like \""+comic+"\" AND number = \""+num+"\" AND (parent_book_local <> \""+parent+"\" OR parent_book_local IS NULL)");
		this.closeConnection();
		
		return files;	
	}
	
	public Map<Integer, HomeFile> show_confirmed_files(String parent) {
		this.createConnection();
		Map<Integer, HomeFile> files = this.sql_stuff("SELECT * from "+this.table+" WHERE parent_book_local = \""+parent+"\"");
		this.closeConnection();
		
		return files;	
	}	
	
	public String clean_up_comic_name(String comic) {
		if(comic != null) {
			String rtn_str = comic.replaceAll("[:_]", " -");
			return rtn_str;
		}
	/*	if(rtn_str.equals("Green Lantern New Guardians")) {
			rtn_str = "Green Lantern - New Guardians";
		} */
		
		return comic;
	}
	
	//get the files that supposedly match a comic
	@RequestMapping(value="/file/test", method=RequestMethod.GET)
	public String test_report_similar_files(Model model, Locale locale) {
		
		this.createConnection();
		
		Search s1 = new Search();
		//SearchController s = new SearchController();
		s1.table = this.table;
		//s1.title = this.c_name;
		//s1.overall_min = this.c_num;
		s1.title = "Batman";
		s1.overall_min = "5";
		
		Map<Integer, HomeFile> files = this.sql_stuff("SELECT * from comic_files WHERE comic like \"%Batman\" AND number = \"5\"");
		model.addAttribute("files", files);
		
		this.closeConnection();
		
		return "files_show";
	}
	
	public Map<Integer, HomeFile> sql_stuff(String q) {
		Map <Integer, HomeFile> map = new LinkedHashMap <Integer, HomeFile>();
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
				HomeFile file = new HomeFile(this.conn);
				file.setId(result.getString("id"));
				file.getFileFromDB();
					//file.report_rows();
				map.put(y, file);
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
