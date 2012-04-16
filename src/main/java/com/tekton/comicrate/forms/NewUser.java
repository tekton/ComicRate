package com.tekton.comicrate.forms;

import com.tekton.comicrate.*;

import java.security.*;

import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.PreparedStatement;

public class NewUser extends SQLController {
	private String user;
	private String password;
	private String email;
	private String captcha; // TODO: Add captcha support!
	private String hash;
	
	public String getUser() {
		return user;
	}
	public void setUser(String user) {
		this.user = user;
	}
	public String getPassword() {
		return password;
	}
	public void setPassword(String password) {
		this.password = password;
	}
	public String getEmail() {
		return email;
	}
	public void setEmail(String email) {
		this.email = email;
	}
	public String getCaptcha() {
		return captcha;
	}
	public void setCaptcha(String captcha) {
		this.captcha = captcha;
	}
	
	public NewUser() {
		this.createConnection();
	}
	
	public boolean add_to_db() {
		//take the info in "this" and create an entry
		//need to check for exceptions, like it already exists!

		Integer s = 0;
		Integer t = 0;
		
		try {
			Class.forName( "com.mysql.jdbc.Driver" ).newInstance();
			Connection conn = this.conn; //DriverManager.getConnection( this.CONNECTION_URL );
			
			PreparedStatement pst = null;
			
			String sql = "INSERT INTO user (`username`, `password`, `enabled`) VALUES(?,?,?)";
			
			pst = conn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS);
			pst.setString(1, this.user);
			pst.setString(2, this.hash);
			pst.setString(3, "1"); //probably shouldn't validate users right away, but what the heck, it's just alpha
			
			try {
				System.out.println( pst.toString() );
				s = pst.executeUpdate();
			} catch(SQLException e) {
				//basically "what went wrong this time?!"
				System.out.println( "SQLException: " + e.getMessage() );
				System.out.println( "SQLState:     " + e.getSQLState() );
				System.out.println( "VendorError:  " + e.getErrorCode() );
			}
			
			if(s > 0) {
				System.out.println("It's in there! Should redirect to that view...");
				
				//now to add "authority" items
				sql = "INSERT INTO authority (`username`, `authority`) VALUES(?,?)";
				pst = conn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS);
				pst.setString(1, this.user);
				pst.setString(2, "user");
				
				try {
					System.out.println( pst.toString() );
					t = pst.executeUpdate();
				} catch(SQLException e) {
					//basically "what went wrong this time?!"
					System.out.println( "SQLException: " + e.getMessage() );
					System.out.println( "SQLState:     " + e.getSQLState() );
					System.out.println( "VendorError:  " + e.getErrorCode() );
				}
				
				if(t == 0 ) {
					return false;
				}
				
				return true;
			} else {
				System.out.println("Dude, it didn't go in...");
				return false;
			}
			
		} catch( Exception e ) {
			System.out.println( "Something broke...NewUser" );
			System.out.println( e.getMessage() );
			e.printStackTrace();
		}
		
		return true;
	}
	
	public void hash_psw() {
		try {
	         MessageDigest sha_ecoder = MessageDigest.getInstance("SHA1");
	         byte[] digest = sha_ecoder.digest(this.password.getBytes());
	         System.out.println("Digest: " + this.bytes2String(digest));
	         this.hash = this.bytes2String(digest);
		} catch (Exception e) {
			System.out.println("Exception: "+e); //should really log this instead...meh
		}
	}
	
	//shamelessly taken from an article I was reading as I couldn't see any other way of doing it, sadly I forgot to copy the URL :(
	private String bytes2String(byte[] bytes) {
	    StringBuilder string = new StringBuilder();
	    for (byte b : bytes) {
	        String hexString = Integer.toHexString(0x00FF & b);
	        string.append(hexString.length() == 1 ? "0" + hexString : hexString);
	    }
	    return string.toString();
	}
	
}
