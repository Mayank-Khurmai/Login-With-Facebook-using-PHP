<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<style>
		#logout-btn{
			display:none;
		}

		#email,#picture{
			float:left;
		}
	</style>
</head>
<body>
		<img id="picture">
		<h1 id="email"></h1>
	
<script>
	window.onload = function(){
		if(sessionStorage.getItem("user") != null)
  					{
  						$("#login-btn").css({display:'none'});
  						$("#logout-btn").css({display:'block'});
  						
  						var all_data = JSON.parse(sessionStorage.getItem("user"));

  						$("#email").html(all_data.user_email);
  						$("#picture").attr("src",all_data.user_photo);
  					}
	}


  window.fbAsyncInit = function() {
    FB.init({
      appId      : 'YOUR_APP_ID_HERE',
      cookie     : true,
      xfbml      : true,
      version    : 'v7.0'
    });
      
    
	FB.getLoginStatus(function(response) {
	    statusChangeCallback(response);
	}); 


      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


  function checkLoginState() {
	  FB.getLoginStatus(function(response) {
	    statusChangeCallback(response);
	  });
	}


  function statusChangeCallback(response)
  {
  	if(response.status == "connected")
  	{
  		get_result();
  	}

  }

  function get_result()
  {
  	FB.api("/me?fields=id,email,name,picture,birthday,gender,hometown",function(result){
  		var email = result.email;
  		var name = result.name;
  		var picture = result.picture.data.url;
  		var dob = result.birthday;
  		var gender = result.gender;
  		var address = result.hometown.name;

  		$.ajax({
  			type : "POST",
  			url : "store.php",
  			data : {
  				email : email,
  				name : name,
  				picture : picture,
  				dob : dob,
  				gender : gender,
  				address : address
  			},

  			success : function(response)
  			{
  				if(response.trim() == "success")
  				{
  					var data = {
  						user_email : email,
  						user_photo : picture,
  					}

  					data = JSON.stringify(data);

  					sessionStorage.setItem("user",data);

  					if(sessionStorage.getItem("user") != null)
  					{
  						$("#login-btn").css({display:'none'});
  						$("#logout-btn").css({display:'block'});
  						
  						var all_data = JSON.parse(sessionStorage.getItem("user"));

  						$("#email").html(all_data.user_email);
  						$("#picture").attr("src",all_data.user_photo);
  					}
  				}
  			}
  		});
  	});
  }

  function logout()
  {
  	sessionStorage.removeItem("user");

  	if(sessionStorage.getItem("user") == null)
  	{
  		window.location = location.href;
  	}
  }

</script>


<div class="fb-login-button" id="login-btn" data-size="medium" data-button-type="login_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="false" data-width="" scope="public_profile,email,user_birthday,user_gender,user_hometown" onlogin="checkLoginState()"></div>

<button id="logout-btn" onclick="logout()">Logout</button>
</body>
</html>