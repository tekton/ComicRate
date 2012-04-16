package com.tekton.comicrate;

import com.tekton.comicrate.forms.Comic;
import com.tekton.comicrate.SQLController;
//import com.tekton.comicrate.home.admin.*;
import org.springframework.stereotype.Controller;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.SessionAttributes;
import org.springframework.ui.Model;

import java.text.DateFormat;
import java.util.Date;
import java.util.Locale;

@Controller
@SessionAttributes
public class ComicController extends SQLController {

	public String serverTime(Locale locale, Model model) {
		
		Date date = new Date();
		DateFormat dateFormat = DateFormat.getDateTimeInstance(DateFormat.LONG, DateFormat.LONG, locale);
		String formattedDate = dateFormat.format(date);
		
		return formattedDate;
		
	}
	
	// TODO: create a json return for easy dynamic loading
	// will also help when the home "client" version of the server is made!
	@RequestMapping(value="/comic/json/{id}", method=RequestMethod.GET, headers="Accept=application/xml, application/json")
	public @ResponseBody Comic getComicFromDB(@PathVariable String id) {
		
		Comic comic = new Comic();
		comic.setId(id);
		comic.getComicFromDB();
		
		return comic;
		
	}
	
	/*
	 * 
	 * 
	 * The "meat" of the application: basic comic data!
	 * 
	 * This get the data to show the averages and users rating if they have any for it
	 * 
	 * 
	 */
	@RequestMapping(value="/comic/{id}", method=RequestMethod.GET)
	public String showComicViaID(Model model, Locale locale, @PathVariable("id") String id) {
	//TODO: FIX THIS!
		this.createConnection();
		
			Comic comic = new Comic(this.conn);
			
			comic.setId(id);
			comic.getComicFromDB();
			comic.validate_to_zero();
			System.out.println("ComicController 65:: "+comic.reportComic());
			
			model.addAttribute("comic", comic);
		
		this.closeConnection();
		
		return "comic_show_one";
	}

	
	/*** In light of changing up the base "comic" class, all admin functions need to be re-written ***/
	@RequestMapping(value="/admin/comic/edit/{id}", method=RequestMethod.GET)
	public String editComic(Model model, Locale locale, @PathVariable("id") String id) {
		model.addAttribute("serverTime", serverTime(locale, model));
		
		this.createConnection();
		
		Comic comic = new Comic(this.conn);
		
		comic.setId(id);
		comic.getComicFromDB();
		System.out.println("ComicController 86:: "+comic.reportComic());
		
		model.addAttribute("comic", comic);
		
		this.closeConnection();
		
		return "comic_edit";
	}

	@RequestMapping(value="/admin/comic/edit/{id}", method=RequestMethod.POST)
	public String editComic(@ModelAttribute("comic") Comic comic, BindingResult result, Model model, Locale locale, @PathVariable("id") String id) {
		
		//model.addAttribute("serverTime", serverTime(locale, model));
		
		comic.setId(id);
		comic.updateComic();
		System.out.println("ComicController 102:: "+comic.reportComic());
		
		return "redirect:/comic/"+id;
	}
	
	//just in case someone "refreshes" the page or bookmarks it...forward them back to the basic add view
	@RequestMapping(value="/admin/comic/addComic", method=RequestMethod.GET)
	public String addComicGet() {
		return "redirect:../";
	}
	//this is the least bjorked admin function as it doesn't rely on most anything
	@RequestMapping(value="/admin/comic/addComic", method=RequestMethod.POST)
	public String addComic(@ModelAttribute("comic") Comic comic, BindingResult result, Model model, Locale locale) {
		
		//model.addAttribute("serverTime", serverTime(locale, model));

		String i = comic.putComicInDB();
		System.out.println("ComicController 119:: "+comic.reportComic());
		
		return "redirect:/comic/"+i;
	}
	
	/*** end admin ***/
	
	//if you go to the directory without an ID, just send you back to the main page
	@RequestMapping(value = "/comic/", method = RequestMethod.GET)
	public String comic(Locale locale, Model model) {
		//return "comic";
		return "redirect:/";
	}
	
	
	/*** The below will be useful when the "installer" stage is gotten to ***/
	/**
	private void create_table() {
		/*
			String q = CREATE TABLE `comic` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) DEFAULT NULL,
			  `note` text,
			  `overall` int(11) DEFAULT NULL,
			  `art` int(11) DEFAULT NULL,
			  `story` int(11) DEFAULT NULL,
			  `likely_to_buy_next` int(11) DEFAULT NULL,
			  `img_url` varchar(255) DEFAULT NULL,
			  `issue_number` int(11) DEFAULT NULL,
			  `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  `volume` varchar(45) DEFAULT NULL,
			  `year` varchar(45) DEFAULT NULL,
			  `own_physical` varchar(45) DEFAULT NULL,
			  `do_not_incremnet` int(11) DEFAULT NULL,
			  `mini_series_max` int(11) DEFAULT NULL,
			  `New52` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `ComicNumVolume` (`title`,`issue_number`,`volume`)
			) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1";*/
	/**}**/
}
