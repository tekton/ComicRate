package com.tekton.comicrate.forms;

import com.tekton.comicrate.*;

public class Search extends SQLController {
	public String text;
	public String ignore;
	
	public String title;
	public String ignore_title;
	
	public String overall_min;
	public String overall_max;
	public String art_min;
	public String art_max;
	public String story_min;
	public String story_max;
	public String likely_to_buy_next_min;
	public String likely_to_buy_next_max;
	
	public String table;
	
	
	
	public String getText() {
		return text;
	}



	public void setText(String text) {
		this.text = text;
	}



	public String getIgnore() {
		return ignore;
	}



	public void setIgnore(String ignore) {
		this.ignore = ignore;
	}



	public String getTitle() {
		return title;
	}



	public void setTitle(String title) {
		this.title = title;
	}



	public String getIgnore_title() {
		return ignore_title;
	}



	public void setIgnore_title(String ignore_title) {
		this.ignore_title = ignore_title;
	}



	public String getOverall_min() {
		return overall_min;
	}



	public void setOverall_min(String overall_min) {
		this.overall_min = overall_min;
	}



	public String getOverall_max() {
		return overall_max;
	}



	public void setOverall_max(String overall_max) {
		this.overall_max = overall_max;
	}



	public String getArt_min() {
		return art_min;
	}



	public void setArt_min(String art_min) {
		this.art_min = art_min;
	}



	public String getArt_max() {
		return art_max;
	}



	public void setArt_max(String art_max) {
		this.art_max = art_max;
	}



	public String getStory_min() {
		return story_min;
	}



	public void setStory_min(String story_min) {
		this.story_min = story_min;
	}



	public String getStory_max() {
		return story_max;
	}



	public void setStory_max(String story_max) {
		this.story_max = story_max;
	}



	public String getLikely_to_buy_next_min() {
		return likely_to_buy_next_min;
	}



	public void setLikely_to_buy_next_min(String likely_to_buy_next_min) {
		this.likely_to_buy_next_min = likely_to_buy_next_min;
	}



	public String getLikely_to_buy_next_max() {
		return likely_to_buy_next_max;
	}



	public void setLikely_to_buy_next_max(String likely_to_buy_next_max) {
		this.likely_to_buy_next_max = likely_to_buy_next_max;
	}



	public String getTable() {
		return table;
	}



	public void setTable(String table) {
		this.table = table;
	}



	public String constructQuery() {
		//TODO move to prepared statement somehow...
		String q = "SELECT * from "+this.table+" WHERE id > 0";
		
			if(this.text != "" && this.text != null) {
				q += " AND note like \"%"+this.text+"%\"";
			}
			
			if(this.title != "" && this.title != null) {
				q += " AND title like \"%"+this.title+"%\"";
			}

			if(this.overall_min != "" && this.overall_min != null) {
				q += " AND overall >= \""+this.overall_min+"\"";
			}
			
			if(this.overall_max != "" && this.overall_max != null) {
				q += " AND overall <= \""+this.overall_max+"\"";
			}

			if(this.story_min != "" && this.story_min != null) {
				q += " AND story >= \""+this.story_min+"\"";
			}
			
			if(this.story_max != "" && this.story_max != null) {
				q += " AND story <= \""+this.story_max+"\"";
			}
			
			
		return q;
	}
	
}
