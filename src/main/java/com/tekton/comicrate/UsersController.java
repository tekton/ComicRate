package com.tekton.comicrate;

import java.util.Locale;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.SessionAttributes;

import com.tekton.comicrate.forms.NewUser;

@Controller
@SessionAttributes
public class UsersController {
	
	/**
	 * Uses SpringSecurity objects/models
	 * @param newUser The newUser object as defined by SpringSecurity
	 * @param result Post data from what has been submitted
	 * @param locale Information about the session and location of the user
	 * @param model The model that gets passed to the JSP files
	 * @return The JSP file name
	 */
	
	@RequestMapping(value = "/newuser", method = RequestMethod.POST)
	public String newuser(@ModelAttribute("NewUser") NewUser newUser, BindingResult result, Locale locale, Model model) {

		newUser.hash_psw();
		
		if(newUser.add_to_db() == true) {
			return "newuser";
		} else {
			return "newuser_failed";
		}
	}
	
	@RequestMapping(value = "/loggedout", method = RequestMethod.GET)
	public String loggedout(Locale locale, Model model) {

		return "loggedout";
	}
	
	@RequestMapping(value = "/login", method = RequestMethod.GET)
	public String login_form(Locale locale, Model model) {

		return "login";
	}

	@RequestMapping(value = "/about", method = RequestMethod.GET)
	public String about_form(Locale locale, Model model) {

		return "about";
	}
}
