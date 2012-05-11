package com.tekton.comicrate;

import com.tekton.comicrate.files.*;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.SessionAttributes;
import org.springframework.ui.Model;

import java.util.List;
import java.util.Locale;
import java.util.Map;
import java.util.LinkedHashMap;
import java.util.ArrayList;
import java.util.Iterator;

import java.io.File;

@Controller
@SessionAttributes
public class FilesController extends SQLController {
	
	// TODO: create "settings" table to house base of comics
	String base = "F:\\Comics\\";
	
	@RequestMapping(value="/files/root/", method=RequestMethod.GET)
	public String show_root(Model model, Locale locale) {
		
		File dir = new File(this.base);
		String[] children = dir.list();
		Map<Integer, String> folders = new LinkedHashMap<Integer, String>(); 
		
		if (children == null) {
			//why are there no comics?!
		} else {
		    for (int i=0; i<children.length; i++) {
		    	//loop through a list of items to make sure it's not on the don't show list...
				//iterate through them all and add them in!
		    	if(this.bad_files_list(children[i]) == false) {
		    		folders.put(i, children[i]);
		    	}
		    }
		}
		
		model.addAttribute("folders", folders);
		
		return "files_root";
	}

	/*
	@RequestMapping(value="/files/root/process", method=RequestMethod.GET)
	public String process_root_folder(Model model, Locale locale, @PathVariable("folder") String folder) {
		
		File dir = new File(this.base);
		return "files_folder";
	}
	*/
	
	@RequestMapping(value="/files/root/{folder}", method=RequestMethod.GET)
	public String show_folder_options(Model model, Locale locale, @PathVariable("folder") String folder) {
		
		File dir = new File(this.base+"\\"+folder);
		String[] children = dir.list();
		Map<Integer, String> folders = new LinkedHashMap<Integer, String>(); 
		
		if (children == null) {
			//why are there no comics?!
		} else {
		    for (int i=0; i<children.length; i++) {
				//iterate through them all and add them in!
		    	if(this.bad_files_list(children[i]) == false) {
		    		folders.put(i, children[i]);
		    	}
		    }
		}
		
		model.addAttribute("folders", folders);
		
		return "files_folder";
	}

	@RequestMapping(value="/files/root/{folder}/{sub}", method=RequestMethod.GET)
	public String show_subfolder_options(Model model, Locale locale, @PathVariable("folder") String folder, @PathVariable("sub") String sub) {
		
		File dir = new File(this.base+"\\"+folder+"\\"+sub);
		String[] children = dir.list();
		Map<Integer, String> folders = new LinkedHashMap<Integer, String>(); 
		
		if (children == null) {
			//why are there no comics?!
		} else {
		    for (int i=0; i<children.length; i++) {
				//iterate through them all and add them in!
		    	if(this.bad_files_list(children[i]) == false) {
		    		folders.put(i, children[i]);
		    	}
		    }
		}
		
		model.addAttribute("folders", folders);
		
		return "files_folder";
	}
	
	@RequestMapping(value="/files/root/{folder}/process", method=RequestMethod.GET)
	public String process_folder(Model model, Locale locale, @PathVariable("folder") String folder) {
		
		//File dir = new File(this.base+"\\"+folder);
		
		this.createConnection();
		
		fileParse f = new fileParse(this.conn);
		
		String path = this.base+folder;
		
		f.setPath(path);
		f.y();
		
		//model.addAttribute("folders", folders);
		
		this.closeConnection();
		
		return this.show_folder_options(model, locale, folder);
	}

	@RequestMapping(value="/files/root/{folder}/{sub}/process", method=RequestMethod.GET)
	public String process_sub_folder(Model model, Locale locale, @PathVariable("folder") String folder, @PathVariable("sub") String sub) {
		
		//File dir = new File(this.base+"\\"+folder);
		
		this.createConnection();
		
		fileParse f = new fileParse(this.conn);
		
		String path = this.base+folder+"\\"+sub;
		
		f.setPath(path);
		f.y();
		
		//model.addAttribute("folders", folders);
		
		this.closeConnection();
		
		return this.show_subfolder_options(model, locale, folder, sub);
	}
	
	public Boolean bad_files_list(String file) {
		//TODO add a sql call to a "do not add" table instead of the hard coded one
		System.out.println("Checking: bad_files_list:: "+file);
		
		List<String> files= new ArrayList<String>();
		
		files.add("folder.pl");
		files.add(".git");
		files.add(".svn");
		files.add("deleteMe");
		files.add("tekton");
		files.add("nomatch.txt");
		files.add(".DS_Store");
		files.add("._.DS_Store");
		files.add("transferMe");
		
		Iterator<String> it = files.iterator(); ////the name is just far too fitting...
		
		while(it.hasNext())
		{
			String bad = (String)it.next();
			
			//System.out.println("Checking: "+bad);
			
			if(file.equals(bad)) {
				//System.out.println("Bad file: "+file);
				return true;
			}
		}
		
		return false;
	}
}
