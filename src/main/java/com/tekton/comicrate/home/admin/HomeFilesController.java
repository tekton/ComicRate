package com.tekton.comicrate.home.admin;

import java.io.BufferedInputStream;
import java.io.DataInputStream;
import java.io.File;
import java.io.FileInputStream;
//import java.io.FileOutputStream;
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
	 * @param request Standard HTTP request
	 * @param response Standard HTTP response
	 * @param id The ID of the file
	 * @return Nothing for now...
	 * @throws Exception
	 */
	@RequestMapping(value="/home/transfer/{id}", method=RequestMethod.GET)
    public ModelAndView transfer(HttpServletRequest request, HttpServletResponse response, @PathVariable("id") String id) throws Exception {
        
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
	@RequestMapping(value="/home/edit/{id}", method=RequestMethod.GET)
	public String edit(Model model, Locale locale, @PathVariable("id") String id) {
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
	
	@RequestMapping(value="/home/edit/{id}/from/{c}", method=RequestMethod.GET)
	public String edit_assign(Model model, Locale locale, @PathVariable("id") String id, @PathVariable("c") String c) {
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

	@RequestMapping(value="/home/edit/{id}", method=RequestMethod.POST)
	public String update_file(@ModelAttribute("HomeFile") HomeFile file, BindingResult result, Model model, Locale locale, @PathVariable("id") String id) {
		this.createConnection();
		
		file.conn = this.conn;
		file.setId(id);
		//file.getFileFromDB();
		file.updateInLocalDB();
		
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
}
