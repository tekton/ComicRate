package com.tekton.comicrate;

import com.tekton.comicrate.SQLController;
import com.tekton.comicrate.forms.UserPullList;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.SessionAttributes;
import org.springframework.ui.Model;
import java.util.Locale;

/**
 * 
 * Add any known comic to the list to "watch"
 * 
 * This allows for just certain books to get copied "auto-magically" to 
 * "Transfer Me" when the user wants to read their comics in bulk by just 
 * transferring unread issues in that series
 * 
 * @author tekton
 *
 */
@Controller
@SessionAttributes
public class UserPullListController extends SQLController {
	
	public UserPullList rl;
	
	@RequestMapping(value="/user/pulllist", method=RequestMethod.GET)
	public String showUserReadingList(Locale locale, Model model) {
		
		this.rl = new UserPullList();
		model.addAttribute("pulllist", this.rl.books);
		
		return "user/readinglists";
	}

	@RequestMapping(value="/user/pulllist/add/{series}", method=RequestMethod.GET)
	public String addToPullList(Locale locale, Model model, @PathVariable("series") String series) {
		
		this.rl = new UserPullList();
		model.addAttribute("success", this.rl.addSeries(series));	
		return "user/json_add_series";
	}
	
	
}
