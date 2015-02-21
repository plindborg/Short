$(document).ready(function(){
	$("#add_err").css('display', 'none', 'important');
	$("#login").click(function(){	
	 	  //alert('Hej!');
		  username=$("#user_name").val();
		  password=$("#password").val();
		  //alert(username + " " + password);
		  $.ajax({
		   type: "POST",
		   url: "login.php",
			data: "user_name="+username+"&password="+password,
		   success: function(html){    
			if(html=='true')    {
			 //$("#add_err").html("right username or password");
			 window.location="index.php";
			}
			else    {
				$("#add_err").css('display', 'inline', 'important');
			 	$("#add_err").html("Wrong username or password");
			}
		   },
		   beforeSend:function()
		   {

		   }
		  });
		return false;
	});
	$("#signup_err").css('display', 'none', 'important');
	$("#signup").click(function(){	
	 	  //alert('Hej!');
		  username=$("#signup_user_name").val();
		  password=$("#signup_password").val();
		  //alert(username + " " + password);
		  $.ajax({
		   type: "POST",
		   url: "users.php",
			data: "user_name="+username+"&password="+password,
		   success: function(html){    
			if(html=='true')    {
			 	$("#signup_err").css('display', 'inline', 'important');
			 	$("#signup_err").html("User " + username + " successfully created. Now log in!");
			 	setTimeout(function(){
  					window.location="index.php";
				}, 2000);	
			 	
			}
			else {
				$("#signup_err").css('display', 'inline', 'important');
			 	$("#signup_err").html("Username not available");
			}
		   },
		   beforeSend:function()
		   {

		   }
		  });
		return false;
	});	
});