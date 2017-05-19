<?php
session_start();
$userIP = $_SERVER['REMOTE_ADDR'];

//includes and requires
require_once('login-database.php');

//logic structure
if(isset($_POST['submit'])){
	//variable initialization
	$username = $_POST['username'];
	$password = $_POST['password'];

	//authenticate with database
	if(verifyLogin($username, $password, $userIP)){
		//header to main page
		setValidSessionVariables($username);
		header('Location: home.php');	
	}
	else{
		updateLogins($userIP);	
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
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/login.css" rel="stylesheet">

  </head>

  <body>

    <div class="container">

      <form action="" class="form-signin" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="userID" class="sr-only">Username</label>
        <input type="username" id="username" class="form-control" name="username" placeholder="Username" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
        
        <a href="./create-account.php" style="width: 300px; text-align: center; display: block; margin: 0 auto; margin-top: 10px; margin-bottom: 10px;">Create an account if you are a new user</a>

        <?php 
        	if($error){
        		echo '<p class="error">The username or password was incorrect.</p>';
        	}
        ?>


        <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Sign in</button>

        <?php
        	//<a href="create-account.php" style=" width: 175px; display: block; margin: 0 auto; padding-top: 5px;">or Create a New Account</a>
        ?>
      </form>


    </div> <!-- /container -->

  </body>
</html>

<?php
}


function verifyLogin($username, $password, $userIP){

	$isValid = false;
/*
	date_default_timezone_set('US/Eastern');
	$date = new DateTime();
	$interval = new DateInterval('PT1H');
	$currentTime = $date->format('Y-m-d h:i:s') . "\n";

	$date->sub($interval);
	$startTime =  $date->format('Y-m-d h:i:s') . "\n";


	echo "SELECT COUNT(lastLogin) as attempts, MAX(blockUntil) FROM login_tracking WHERE ip = ".$userIP." AND lastLogin >= ".$startTime." AND lastLogin <= ".$currentTime;
	exit();

	$mysqli = connectToDatabase();
	$stmt = $mysqli->prepare('SELECT COUNT(lastLogin) as attempts, MAX(blockUntil) FROM login_tracking WHERE ip = ? AND lastLogin >= ? AND lastLogin <= ?');
	$stmt->bind_param('sss', $userIP, $startTime, $currentTime);
	$stmt->execute();
	$stmt->bind_result($attempts, $blockTime);
	$stmt->fetch();

	if($currentTime >= $blockTime)
		return $isValid;
*/

	// A higher "cost" is more secure but consumes more processing power
	$cost = 10;

	// Create a random salt
	$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

	// Prefix information about the hash so PHP knows how to verify it later.
	// "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
	$salt = sprintf("$2a$%02d$", $cost) . $salt;

	// Value:
	// $2a$10$eImiTXuWVxfM37uY4JANjQ==

	// Hash the password with the salt.
	//This line isn't necessary unless updating the hash in the DB
	$hash = crypt($password, $salt);

	// Value:
	// $2a$10$eImiTXuWVxfM37uY4JANjOL.oTxqp7WylW7FCzx2Lc7VLmdJIddZq
	
	$query = "SELECT password FROM login WHERE username = :username LIMIT 1";

	
	$database = connectToDatabase();
	$stmt = $database->prepare($query);
	$result = $stmt->execute(array(":username" => $username));
	$pass = $stmt->fetch()['password'];
	

	// Hashing the password with its hash as the salt returns the same hash
	if (strcmp($pass, crypt($password, $pass)) == 0 && !is_null($pass)) {
	  	// Ok!
		$isValid = true;
	}

	return $isValid;
}

function updateLogins($userIP){

	date_default_timezone_set('US/Eastern');
	$date = new DateTime();
	$interval = new DateInterval('PT1H');
	$currentTime = $date->format('Y-m-d h:i:s') . "\n";

	$date->add($interval);
	$blockUntilTime =  $date->format('Y-m-d h:i:s') . "\n";

	$query = "INSERT into login_tracking VALUES(:ip,:lastLogin,:blockUntil)";

	$database = connectToDatabase();
	$stmt = $database->prepare($query);
	$result = $stmt->execute(array(":ip" => $userIP, ":lastLogin" => $currentTime, ":blockUntil" => $blockUntilTime));

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