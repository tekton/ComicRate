package com.tekton.comicrate.home.admin;
import java.util.Locale;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.SessionAttributes;

import com.tekton.comicrate.SQLController;

/**
 * 
 * Intended to create local copies of "new comics" based on files; this in turn would upload incremented comic numbers to the server
 * 
 * @author tekton
 *
 */

@Controller
@SessionAttributes
public class HomeFilesReports extends SQLController {

	@RequestMapping(value="/home/report", method=RequestMethod.GET)
	public String reportComicsWithNumber(Model model, Locale locale) {
		
		
		return "home_reportComicsWithNumber";
	}
	
}
