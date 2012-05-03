package com.tekton.comicrate.server.admin;

import org.springframework.stereotype.Controller;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.SessionAttributes;

import java.util.Locale;
import java.util.Set;
import java.util.Scanner;

import org.springframework.ui.Model;

import com.tekton.comicrate.forms.Comic;

@Controller
@SessionAttributes
public class NewComicsController extends NewComicController {
	
	public String theList;
	public Set<String> series;
	//the "easiest" version I would think would be a tab separated list...
	
	public String getTheList() {
		return theList;
	}

	public void setTheList(String theList) {
		this.theList = theList;
	}

	public Set<String> getSeries() {
		return series;
	}

	public void setSeries(Set<String> series) {
		this.series = series;
	}

	public NewComicsController() {

	}
	
	@RequestMapping(value="/admin/add/tabList", method=RequestMethod.POST)
	public String add_from_tab_list(@ModelAttribute("NewComicsController") NewComicsController NewComicsController, BindingResult result, Model model, Locale locale) {
		//model.addAttribute("serverTime", serverTime(locale, model));
		//System.out.println(NewComicsController.theList);
		
		this.createConnection();
		
		Scanner scanner = new Scanner(NewComicsController.theList);
		while (scanner.hasNextLine()) {
		  String line = scanner.nextLine();
		  // process the line
		  //System.out.println(line);
		  String delims = "[\\t]+";
		  String[] tokens = line.split(delims);
		  if(tokens.length > 0) {
			  Comic comic = new Comic(this.conn);
			  for(int i=0; i< tokens.length; i++) {
				  //System.out.println(tokens[i]);
				  /*
				   * 0 - name
				   * 1 - year
				   * 2 - number
				   * 3 - publisher
				   * 4 - volume
				   */
				  if(i == 0) {
					  comic.setTitle(tokens[i]);
				  } else if (i == 1) {
					  comic.setYear(tokens[i]);
				  } else if (i == 2) {
					  comic.setIssue_number(tokens[i]);
				  } else if (i == 3) {
					  comic.setPublisher(tokens[i]);
					  if(tokens[i] == "DC") {
						  comic.setNew52("1");
					  }
				  } else {
					  
				  }
			  }
			  this.process_series(comic);
		  }
		}
		
		return "admin_comics_added";
	}

	public void process_series(Comic comic) {
		System.out.println(comic.reportComic());
		Integer max = Integer.parseInt(comic.issue_number);
		
		for(int i=1; i <= max; i++) { //sometimes there's a 0 or .1 comic; add those later by hand in a different way
			comic.issue_number = Integer.toString(i);
			comic.putComicInDB(); //.add(i, comic.putComicInDB());
			//model.addAttribute("comics", comic_ids);
		}
		
	}

	public void process_series_inc(Comic comic, String start) {
		System.out.println(comic.reportComic());
		Integer max = Integer.parseInt(comic.issue_number);
		
		for(int i=Integer.parseInt(start); i <= max; i++) { //sometimes there's a 0 or .1 comic; add those later by hand in a different way
			comic.issue_number = Integer.toString(i);
			comic.putComicInDB(); //.add(i, comic.putComicInDB());
			//model.addAttribute("comics", comic_ids);
		}
		
	}
	
	@RequestMapping(value="/admin/add/tabList", method=RequestMethod.GET)
	public String tab_list_view(Model model, Locale locale) {
		//model.addAttribute("serverTime", serverTime(locale, model));
		
		
		return "admin_comics_tab_list";
	}
	
	/*
	 * Basically, if you're inserting "Batman 5" we should go back and make sure Batman 1-4 exist...
	 */
	public void check_for_earlier(String series, int issue) {
		//check for title = series and issue_number < issue
		//do we need to create a list and then remove items as they match?
		
		//select * from comic where title = /series/ -- what about volume?!
		// will possibly need a "guided entry" form or move to own class...
		
	}
	
}
