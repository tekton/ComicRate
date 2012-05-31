package com.tekton.comicrate.home.admin;

import com.tekton.comicrate.forms.UserPullList;

public class HomeUser {

	String name;
	UserPullList upl;
	
	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public UserPullList getUpl() {
		System.out.println(upl.books);
		return upl;
	}

	public void setUpl(UserPullList upl) {
		this.upl = upl;
	}

	//when getting basic user information also get the pull list for that user!
	public HomeUser(String name) {
		this.setName(name);
		upl = new UserPullList(name);
	}
	
}
