package com.tekton.comicrate.home.admin;

import java.io.BufferedInputStream;
import java.io.DataInputStream;
import java.io.File;
import java.io.FileInputStream;
//import java.io.FileOutputStream;
import java.util.Enumeration;
import java.util.Locale;

//import java.nio.channels.FileChannel;
import java.nio.file.*;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.springframework.stereotype.Controller;
import org.springframework.validation.BindingResult;
//import org.springframework.web.bind.ServletRequestUtils;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
//import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.SessionAttributes;
import org.springframework.web.servlet.ModelAndView;
import org.springframework.ui.Model;
import org.springframework.util.FileCopyUtils;

import com.tekton.comicrate.SQLController;
import com.tekton.comicrate.files.fileParse;
import com.tekton.comicrate.forms.Comic;
import com.tekton.comicrate.home.admin.HomeFiles;

@Controller
@SessionAttributes
public class HomeFilesController extends SQLController {
	
	@RequestMapping(value="/home/files/", method=RequestMethod.GET)
	public String init_parse(Model model, Locale locale) {
		
		//get the "home" directory for files
		

		//send that list to the model to show for clicking
		
		//add an "all" function
		return "file_base";
	}

	@RequestMapping(value="/home/file/{id}", method=RequestMethod.GET)
	public String init_parse(Model model, Locale locale, @PathVariable("id") String id) {
		
		//get the "home" directory for files
		

		//send that list to the model to show for clicking
		
		//add an "all" function
		return "file_base";
	}

	
	@RequestMapping(value="/home/process/", method=RequestMethod.POST)
	public String parse_files(@ModelAttribute("HomeFiles") HomeFiles files, BindingResult result, Model model, Locale locale) {
		
		for(int i = 0; i < files.files.length; i++) {
			@SuppressWarnings("unused")
			fileParse file = new fileParse(files.files[i]);
		}
		
		return "file_parsed_list";
	}
	
    /**
     * download
     */
	@RequestMapping(value="/home/download/{id}", method=RequestMethod.GET)
    public ModelAndView download(HttpServletRequest request, HttpServletResponse response, @PathVariable("id") String id) throws Exception {
        
		this.createConnection();

		HomeFile h_file = new HomeFile(this.conn);
		h_file.setId(id);
		h_file.getFileFromDB();
		
        //Files file = this.filesService.find(id);

        File file = new File(h_file.getPath());
        FileInputStream stream = new FileInputStream(file);
		BufferedInputStream ibr = new BufferedInputStream(stream);
		DataInputStream file_input_stream = new DataInputStream(ibr);
		
		byte[] f = new byte[(int) file.length()];
		file_input_stream.readFully(f);
        
        response.setContentType(h_file.getType());
        response.setContentLength((int) file.length());
        
        String f_name = h_file.getComic() + " " + h_file.getNumber() + "." + h_file.getType();
        
        response.setHeader("Content-Disposition","attachment; filename=\"" + f_name +"\"");

        FileCopyUtils.copy(f, response.getOutputStream());

        this.closeConnection();
        
        return null;
    }	

	/**
	 * Eventually this will move to a JSON request most likely
	 * 
	 * TODO: add error handling
	 * 
	 * @param request Standard HTTP request
	 * @param response Standard HTTP response
	 * @param id The ID of the file
	 * @return Nothing for now...
	 * @throws Exception
	 */
	@RequestMapping(value="/home/transfer/{id}", method=RequestMethod.GET)
    public ModelAndView transfer(HttpServletRequest request, 
    		HttpServletResponse response, 
    		@PathVariable("id") String id) throws Exception {
        
		this.createConnection();

		HomeFile h_file = new HomeFile(this.conn);
		h_file.setId(id);
		h_file.getFileFromDB();

        File file = new File(h_file.getPath());
        String f_name = h_file.getComic() + " " + h_file.getNumber() + "." + h_file.getType();
        String base = "F:\\transfer\\"+f_name;
        File out_file = new File(base);
        
        Path in = file.toPath();
        Path out = out_file.toPath();
        
        Files.copy(in,out);
        
        //FileOutputStream dest = new FileOutputStream(out_file);

        this.closeConnection();
        
        return null;
    }
	
	@RequestMapping(value="/home/json/transfer/{id}", method=RequestMethod.GET, headers="Accept=application/xml, application/json")
    public String json_transfer(Model model, 
    		Locale locale, 
    		@PathVariable("id") String id) throws Exception {
        
		this.createConnection();

		HomeFile h_file = new HomeFile(this.conn);
		h_file.setId(id);
		h_file.getFileFromDB();

        File file = new File(h_file.getPath());
        String f_name = h_file.getComic() + " " + h_file.getNumber() + "." + h_file.getType();
        String base = "F:\\transfer\\"+f_name;
        File out_file = new File(base);
        
        this.closeConnection(); //shouldn't need the connection for anything anymore

        model.addAttribute("fileDestination", base);
        model.addAttribute("sourceDestination", f_name);
        
        if(out_file.exists()) {
        	model.addAttribute("success", "already exists");
        	return "json_transfer";
        } else {
	        Path in = file.toPath();
	        Path out = out_file.toPath();
	        
	        Files.copy(in,out);

	        model.addAttribute("success", "true");
	        
	        return "json_transfer";
        }
        
        
    }
	
	@RequestMapping(value="/home/edit/{id}", method=RequestMethod.GET)
	public String edit(Model model, 
			Locale locale, 
			@PathVariable("id") String id) {
		this.createConnection();
		HomeFile file = new HomeFile(this.conn);
		
		file.setId(id);
		file.getFileFromDB();
		
		model.addAttribute("file", file);

		if(file.parent_book_local != null) {
			Comic comic = new Comic(this.conn);
			comic.setId(file.parent_book_local);
			comic.getComicFromDB();
			model.addAttribute("comic", comic);
		}
		
		this.closeConnection();
		return "files_edit";
	}
	
	/**
	 * 
	 * Get data from the DB based on the files at hand to attach a file to a comic; if done correctly this should allow for easier "clean up" of duplicates! 
	 * 
	 * @param model The model (M in MVC) which will have data added to it to show later
	 * @param locale Internal information
	 * @param id The ID of the file
	 * @param c The possible parent book for the file
	 * @return
	 */
	@RequestMapping(value="/home/edit/{id}/from/{c}", method=RequestMethod.GET)
	public String edit_assign(Model model, 
			Locale locale, 
			@PathVariable("id") String id, 
			@PathVariable("c") String c) {
		this.createConnection();
		HomeFile file = new HomeFile(this.conn);
		
		file.setId(id);
		file.getFileFromDB();
		
		file.setParent_book_local(c);
		
		model.addAttribute("file", file);
		model.addAttribute("x", c);
		
		this.closeConnection();
		return "files_edit";
	}

	@RequestMapping(value="/home/h", method=RequestMethod.GET)
	public String stuff(HttpServletRequest request) {
		String headername = "";
		for(Enumeration<?> e = request.getHeaderNames(); e.hasMoreElements();){
			headername = (String)e.nextElement();
			System.out.println("Header Name:: "+ headername +" -- "+request.getHeader(headername));
		}
		
		return "home";
	}
	
	@RequestMapping(value="/home/edit/{id}", method=RequestMethod.POST)
	public String update_file(@ModelAttribute("HomeFile") HomeFile file,
			BindingResult result,
			Model model,
			Locale locale,
			@PathVariable("id") String id) {
		this.createConnection();
		
		file.conn = this.conn;
		file.setId(id);
		//file.getFileFromDB();
		file.updateInLocalDB();
		
		model.addAttribute("file", file);
		
		//show the book data
		if(file.parent_book_local != null) {
			Comic comic = new Comic(this.conn);
			comic.setId(file.parent_book_local);
			comic.getComicFromDB();
			model.addAttribute("comic", comic);
		}
		
		this.closeConnection();
		
		return "files_edit";
	}
	
	
	/**
	 * To get all the confirmed files that haven't been read, this query works! Though sadly it's not all that useful in a multi-user environment...
	 * 
	 * @return
	 */
	public String all_unread() {
		$q = "select cf.id, cf.comic, cf.number from comic_files as cf"+
				"left join user_ratings as ur on cf.parent_book_local = ur.comic"+
				"where cf.parent_book_local IS NOT NULL AND ur.overall IS NULL"+
				"ORDER BY comic, number";
		return "unread";
	}
	
	public String transfer_series_unread() {
		
		
		
		return "unread_series";
	}
	
	/**
	 * TODO: add in some things that make showing which files haven't been read; 
	 * there's no end-all-be-all query that I can figure out given the way things 
	 * are set up. However, the "overall" rating is captured for the user any time
	 * the comic and/or file is accessed...so it would be trivial to add another 
	 * javascript array to searches/series overviews
	 */
	
}
