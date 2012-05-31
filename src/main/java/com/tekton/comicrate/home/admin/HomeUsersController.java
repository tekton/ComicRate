package com.tekton.comicrate.home.admin;

import java.util.Locale;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.SessionAttributes;

@Controller
@SessionAttributes
public class HomeUsersController {

	//get list of users
	@RequestMapping(value="/admin/users/", method=RequestMethod.GET)
	public String getListOfUser(Locale locale, Model model) {
		
		HomeUsers h = new HomeUsers();
		h.getAllHomeUsers();
		model.addAttribute("users", h);
		
		return "admin/list_of_users";
	}
	
}
