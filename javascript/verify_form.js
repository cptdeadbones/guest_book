function validateForm(str)
	{
		// first name is required
		var fn=document.forms[str]["first_name"].value;
		if (fn == "")
		{
  		  alert("Please Fill In First name");
		  return false;
		}
	
		// last name is required
		var fn=document.forms[str]["last_name"].value;
		if (fn == "")
		{
  		  alert("Please Fill In Last name");
		  return false;
		}
		// verify email if provided
		var em=document.forms[str]["email"].value;
		if (em != "") {
	    	var atpos=em.indexOf("@");
	    	var dotpos=em.lastIndexOf("."); 
			if (atpos<1 || dotpos<atpos+2 || dotpos+2>=em.length)
			  {
		    	alert("You have entered an invalid e-mail address");
			    return false;
			  }
		}
	}
	
function validateInstall()
	{
		var fn=document.forms["install_form"]["host"].value;
		if (fn == "")
		{
  		  alert("Host is required");
		  return false;
		}
	
		var fn=document.forms["install_form"]["user_name"].value;
		if (fn == "")
		{
  		  alert("User name is required");
		  return false;
		}
		
		var fn=document.forms["install_form"]["password"].value;
		if (fn == "")
		{
  		  alert("Password is required");
		  return false;
		}
		
		var fn=document.forms["install_form"]["db_name"].value;
		if (fn == "")
		{
  		  alert("Database Name is required");
		  return false;
		}
	}