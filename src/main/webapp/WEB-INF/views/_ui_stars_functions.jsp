<%!

public String validate_var(String var) {
	if(var == null) {
		return "0";
	} else {
		return var;
	}
}

public String create_stars_user_input(String var, String c_name, String id) {
	String stars = "<div id=\""+id+"-stars-"+c_name+"\">"+
	        "<select name=\""+c_name+"-sel\" id=\""+id+c_name+"\">"+
		    		"<option value=\"1\">Very poor</option>"+
		    		"<option value=\"2\">Poor</option>"+
		    		"<option value=\"3\">Not that bad</option>"+
		    		"<option value=\"4\">Fair</option>"+
		    		"<option value=\"5\">Average</option>"+
		    		"<option value=\"6\">Almost Good</option>"+
		    		"<option value=\"7\">Good</option>"+
		    		"<option value=\"8\">Very Good</option>"+
		    		"<option value=\"9\">Excellent</option>"+
		    		"<option value=\"10\">Perfect</option>"+
				"</select>"+
				"<input type=\"hidden\" name=\""+c_name+"\" id=\""+id+"-hidden-"+c_name+"\" value=\""+validate_var(var)+"\"/>"+
			"<script>"+
			"$(\"#"+id+"-stars-"+c_name+"\").stars({"+
				"inputType: \"select\","+
				"cancelShow: false,"+
				"split: 2,"+
				"disabled: false,"+
				"callback: function(ui, type, value){"+
					"$(\""+id+"-stars-"+c_name+"\").hide();"+
					"$(\""+id+c_name+"_loading\").show();"
				+"}"+
			"});"+
			"$(\"#"+id+"-stars-"+c_name+"\").stars(\"select\", Math.round("+validate_var(var)+"));"+
			"</script>"+
			"</div>";
	
	stars += "<div class='loading' id='"+id+c_name+"_loading'></div>";
	
			return stars;		
}

%>