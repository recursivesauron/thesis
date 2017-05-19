<?php
session_start();

//includes and requires
require_once('login-database.php');

//logic structure
if(isset($_POST['submit'])){
	//variable initialization
	$username = $_POST['username'];
	$password = $_POST['password'];

	//authenticate with database
	if(createUser($username, $password)){
		//header to main page
		setValidSessionVariables($username);
		header('Location: home.php?tour=true');
	}
	else{
		
		display_login_page(true); //true signifies there was an error	
	}
}
else{
	display_login_page(false); //false signifies there was not an error
}


function display_login_page($error){
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Signin Page</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">

  </head>

  <body>

    <div class="container">

      <form action="" class="form-signin" method="post">
        <h2 class="form-signin-heading">Enter your account information:</h2>
        <label for="username" class="sr-only">Username</label>
        <input type="username" id="username" class="form-control" name="username" placeholder="Username" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
        <label for="re-password" class="sr-only">Re-enter Password</label>
        <input type="password" id="re-password" class="form-control" name="re-password" placeholder="Re-enter Password" required>

        <p class="g2g" id="good-username" style="display: none;">This is a valid username</p>
        <p class="error" id="error" style="display: none;">The passwords do not match.</p>

        <button class="btn btn-lg btn-primary btn-block" id="submit-button" name="submit" type="submit" disabled>Sign up</button>

      </form>

    </div> <!-- /container -->

  </body>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script>
  		var userError = false;
  		var passError = false;

  		//password match checker. Works on keyup applied to both password and re-password
  		function errorProcess(userError, passError){
        	if(userError || passError){
        		$("#submit-button").attr("disabled", true);
        	}
        	else{
        		$("#submit-button").attr("disabled", false);
        	}
        }

        function checkUsername(username){
        	$.ajax({
			          method: "POST",
			          url: "DataAccessor.php",
			          data: { action: "check-username", username: username}
			        })
			        .done(function(status) {
			          var isValid = false;
			          console.log(status);
			          if(status === "true"){
			          	isValid = true;
			          }
			         
			          if(isValid && username.length > 0){
					  		$("#good-username").text("This is a valid username");
					  		$("#good-username").addClass("g2g");
					  		$("#good-username").removeClass("error");
					  		$("#good-username").show();
					  		userError = false;
					  	}
					  	else if(username.length == 0){
		           			$("#good-username").text("This username cannot be empty");
					  		$("#good-username").addClass("error");
					  		$("#good-username").removeClass("g2g");

					  		userError = true;
		           		}
					  	else{
					  		$("#good-username").text("This username is already taken");
					  		$("#good-username").addClass("error");
					  		$("#good-username").removeClass("g2g");
					  		$("#good-username").show();

					  		userError = true;
					  	}

					  	errorProcess(userError, passError);
			         });
        }

  		jQuery(function(){
  			var delay = (function(){
				            var timer = 0;
				            return function(callback, ms){
				              clearTimeout (timer);
				              timer = setTimeout(callback, ms);
				            };
				          })();

  			$("#password").keyup(function(){
            
	            var tmpPass = $("#password").val();
			  	var tmpPass2 = $("#re-password").val();
			  	
			  	if(tmpPass !== tmpPass2){
			  		$("#error").removeClass("g2g");
			  		$("#error").addClass("error");
			  		$("#error").text("Password mismatch");
			  		$("#error").show();
			  		passError = true;
			  	}
			  	else if(tmpPass.length == 0){
			  		$("#error").removeClass("g2g");
			  		$("#error").addClass("error");
			  		$("#error").text("Password cannot be empty");
			  		$("#error").show();
			  		passError = true;
			  	}
			  	else{
			  		$("#error").removeClass("error");
			  		$("#error").addClass("g2g");
			  		$("#error").text("Password looks good");
			  		passError = false;
			  	}

			  	errorProcess(userError, passError);
			});

			$("#re-password").keyup(function(){
            
	            var tmpPass = $("#password").val();
			  	var tmpPass2 = $("#re-password").val();

			  	if(tmpPass !== tmpPass2){
			  		$("#error").removeClass("g2g");
			  		$("#error").addClass("error");
			  		$("#error").show();
			  		passError = true;
			  	}
			  	else if(tmpPass.length == 0){
			  		$("#error").removeClass("g2g");
			  		$("#error").addClass("error");
			  		$("#error").text("Password cannot be empty");
			  		$("#error").show();
			  		passError = true;
			  	}
			  	else{
			  		$("#error").removeClass("error");
			  		$("#error").addClass("g2g");
			  		$("#error").text("Password looks good");
			  		passError = false;
			  	}

			  	errorProcess(userError, passError);
			});

			//dynamic check on username
			$("#username").keyup(function(){
                
                 delay(function(){
			        var username = $("#username").val();

                 	checkUsername(username);

			      }, 200);
        	});
		});
  </script> 
</html>

<?php
}


function createUser($username, $password){
	$isValid = true;

	// A higher "cost" is more secure but consumes more processing power
	$cost = 10;

	// Create a random salt
	$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

	// Prefix information about the hash so PHP knows how to verify it later.
	// "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
	$salt = sprintf("$2a$%02d$", $cost) . $salt;

	// Value:
	// $2a$10$eImiTXuWVxfM37uY4JANjQ==

	// Hash the password with the salt
	$hash = crypt($password, $salt);

	// Value:
	// $2a$10$eImiTXuWVxfM37uY4JANjOL.oTxqp7WylW7FCzx2Lc7VLmdJIddZq

	//this code will need to be updated to allow error checking
	$database = connectToDatabase();
	
	try{
		$database->beginTransaction();
		
		//create username and password for login
		$query = "INSERT INTO login VALUES(:username, :password)";
		$stmt = $database->prepare($query);
		$result = $stmt->execute(array(":username" => $username, ":password" => $hash));

		//create actual user in the system
		$query = "INSERT INTO users VALUES(DEFAULT, :username, 0, 0)";
		$stmt = $database->prepare($query);
		$result = $stmt->execute(array(":username" => $username));

		$user_id = $database->lastInsertId();

		//add all achievements for the user
		$query = "INSERT INTO user_active_achievements (user_id, achievement_id, is_tracked) (SELECT :user_id, achievement_id, 0 FROM achievements)";
		$stmt = $database->prepare($query);
		$result = $stmt->execute(array(":user_id" => $user_id));

		//update the user to be tracking numerical achievements
		$query = "UPDATE user_active_achievements SET is_tracked = 1 WHERE user_id = :user_id AND achievement_id IN (SELECT 2 as achievement_id FROM DUAL UNION SELECT 3 as achievement_id FROM DUAL UNION SELECT 4 as achievement_id FROM DUAL)";
		$stmt = $database->prepare($query);
		$result = $stmt->execute(array(":user_id" => $user_id));

		//give the user 3 dailies
		$query = "INSERT INTO user_active_dailies (user_id, daily_id) (SELECT :user_id, daily_id FROM dailies LIMIT 3)";
		$stmt = $database->prepare($query);
		$result = $stmt->execute(array(":user_id" => $user_id));

		//give the user 3 default habits
		$query = "INSERT INTO user_habits (user_id, community_habit_id, title, description, karma_points) (SELECT :user_id, community_habit_id, title, description, karma_points FROM community_habits WHERE community_habit_id < 4)";
		$stmt = $database->prepare($query);
		$result = $stmt->execute(array(":user_id" => $user_id));

		//give the user 2 tasks
		$query = "INSERT INTO tasks VALUES (DEFAULT, :user_id, 'Visit the site help section', NULL, 10, 0), (DEFAULT, :user_id, 'Fill out entry survey', NULL, 10, 0)";
		$stmt = $database->prepare($query);
		$result = $stmt->execute(array(":user_id" => $user_id));


		$database->commit();
	}
	catch(PDOException $ex){
		echo $ex->getMessage();
		exit();
		$database->rollback();
		$isValid = false;
	}

	return $isValid;
}


function setValidSessionVariables($username){
	$query = "SELECT user_id FROM users WHERE alias = :username";

	$database = connectToDatabase();
	$stmt = $database->prepare($query);
	$result = $stmt->execute(array(":username" => $username));
	$user_id = $stmt->fetch()['user_id'];

	$_SESSION['user_id'] = $user_id;

}

?>