package com.tekton.comicrate.forms;

import java.util.Locale;
import java.util.Map;
import java.util.LinkedHashMap;

import com.tekton.comicrate.forms.TableRows;
import com.tekton.comicrate.forms.Comic;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.SessionAttributes;

@Controller
@SessionAttributes
public class NewComicSeries {

	public String title;
	public String volume;
	public String publisher;
	public String number;
	public int max;
	public Map<Integer, String> comic_ids = new LinkedHashMap<Integer,String>();
	
	@RequestMapping(value = "/admin/comics/new", method = RequestMethod.GET)
	public String comic(Locale locale, Model model) {
		
		Map <Integer, TableRows> rows = new LinkedHashMap<Integer, TableRows>();
		
		rows.put(1, new TableRows("Title","title","text"));
		rows.put(2, new TableRows("Volume","volume","text"));
		rows.put(3, new TableRows("Publisher","publisher","text"));
		rows.put(4, new TableRows("Number","issue_number","text"));
		rows.put(5, new TableRows("Max","max","text"));
		rows.put(6, new TableRows("New52", "New52", "checkbox"));
		rows.put(7, new TableRows("", "_New52", "hidden"));
		rows.put(8, new TableRows("Year","year","text"));
		//<input type="hidden" name="_<c:out value="${status.value}"/>">
		
		model.addAttribute("rows", rows);
		
		return "comics_propose_new";
	}

	@RequestMapping(value = "/admin/comics/add", method = RequestMethod.POST)
	public String add_series(@ModelAttribute("comic") Comic comic, BindingResult result, Locale locale, Model model) {
		
		comic.createConnection();
		
		if(comic.max == "0" || comic.max == "") {
			this.max = Integer.parseInt(comic.issue_number);
		} else {
			// Decision: if there is a max we should assume it's a "mini series" of some kind! and add do_not_increment
			this.max = Integer.parseInt(comic.max);
			comic.do_not_increment = "1";
			comic.mini_series_max = comic.max;
		}
		//check to see if series exists
		
		System.out.println("New52: "+comic.New52);
		
		for(int i=1; i <= this.max; i++) { //sometimes there's a 0 or .1 comic; add those later by hand in a different way
			comic.issue_number = Integer.toString(i);
			comic_ids.put(i, comic.putComicInDB()); //.add(i, comic.putComicInDB());
			model.addAttribute("comics", comic_ids);
		}
		
		comic.closeConnection();
		
		return "comics_added";
	}
	

}
