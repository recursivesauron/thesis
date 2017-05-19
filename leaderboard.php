<?php
  session_start();

  include('./DataAccessor.php');

  //if no valid user_id attached, then abandon page and redirect to login
  if(empty($_SESSION['user_id'])){
    session_destroy();
    header('Location: login.php');
  }

  global $data_accessor;
  $data_accessor = new DataAccessor();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="icon" href="../../favicon.ico">
    <title>Project PlaNET</title>
    <!-- Bootstrap core CSS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/front-page.css">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" type="text/css" href="./css/progress-bar.css">
    <link href='https://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="./css/unlock.css">
    <script src="./less/less.js-master/dist/less.js" type="text/javascript"></script>
  
    <style>
      .achievement-icon{
        border-radius: 10em;
        position: relative;
        background: #000;
        border: .4em solid #656766;
        border-top-color: #81C784;
        border-bottom-color: #81C784;
        
        width: 80px;

        margin: 5px;
        z-index: 100;
      }
    </style>
  </head>
  <body>

    <div class="drawer-edge">
    </div>
    <a class="menu-icon" onclick="displayMenu();">
      <img src="./images/menu-icon3.png" style="width: 30px; height: 30px;">
    </a>
    <!-- side menu deezer style -->
    <div class="left-menu">
      <div class="scrollable-overflow-parent">
        <div class="scrollable-overflow">

        <img src="./images/Project Planet.png" class="header-image"/>

        <ul class="main-navigation">
          <li><a href="home.php">Home</a></li>
          <li><a href="manage-habits.php">Manage Habits</a></li>
          <li><a href="manage-tasks.php">Manage Tasks</a></li>
          <li><a href="achievements.php">View Achievements</a></li>
          <li class="active"><a href="leaderboard.php">View Leaderboard</a></li>
          <li><a href="help.php">Help</a></li>
        </ul>
      
          <div class="karma-points">
            <img src="./images/badge.png" class="karma-points-image" />
            <p class="karma-points-number"><?php echo $data_accessor->getTotalPoints() ?></p>
          </div>
          <div class="recent-unlocks">
            <h4>Recent Unlocks</h4>
            
            <?php getRecentUnlocks(); ?>
            
          </div>
          <div class="logout-container">
            <a href="logout.php" class="btn btn-primary logout">Logout</a>
          </div>
        </div>
      </div>
    </div><!--left menu end-->
    <div id="main-content" class="container-fluid">
      
    	<?php displayOptOutButton(); ?>

      <?php displayLeaderboard(); ?> 

    </div><!-- main content end -->

    
    
    <!-- Bootstrap core JavaScript
      ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type = "text/javascript" 
         src = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        var value = $(window).height() - 75;
        $(".scrollable-overflow-parent").css("min-height", value);
      });

      $(window).resize(function(){
        var value = $(window).height() - 75;
        $(".scrollable-overflow-parent").css("min-height", value);
      });

    </script>

    <script type="text/javascript">
      $(document).ready(function(){
        var menuOpen = false;

        $(window).click(function(){
          //Hide menus if visible
          hideMenu();
        });

        $(".left-menu").on('click', function(){
          event.stopPropagation();
        });

        $(".menu-icon").on('click', function(){
          event.stopPropagation();
        })
      });

      function displayMenu(){
        /*$(".left-menu").animate({
                            display: "block"
                        }, 350);*/
        console.log("showing menu...");
        $(".left-menu").show("slide", {direction: "left"}, 350);
        /*$("#main-content").animate({marginLeft: "250px"}, 350);*/
        menuOpen = true;

        console.log("menu shown!");
      }

      function hideMenu(){
         if( $(window).width() < 768){
           console.log("hiding menu...");
           menuOpen = false;
           /*$(".left-menu").animate({
                              display: "none"
                            }, 350);*/
           $(".left-menu").hide("slide", {direction: "left"}, 350);            
           /*$("#main-content").animate({marginLeft: "0px"}, 350);*/
           
           console.log("menu hidden");
        }
      }

      function optOut(){
         console.log("calling optOut...");
         $.ajax({
            method: "POST",
            url: "DataAccessor.php",
            data: { action: "opt-out"}
          })
          .done(function( responseText ) {
              console.log("done opt out");
              setTimeout(function(){location.reload();}, 1000);      
          });
      }

      function optIn(){
        console.log("calling optIn...");
        $.ajax({
            method: "POST",
            url: "DataAccessor.php",
            data: { action: "opt-in"}
          })
          .done(function( responseText ) {
              console.log("done opt in");
              setTimeout(function(){location.reload();}, 1000);      
          });
      }

    </script>
    
  </body>
</html>

<?php

  function getRecentUnlocks(){
    global $data_accessor;

    $result = $data_accessor->getRecentUnlocks();

    $count = 0;
    foreach($result as $row){
      //if the number is even, it's the first image, or the first image in a new set
      if($count % 2 == 0){
        echo "<div class=\"row recent-unlocks-row\"><img src=\"".$row["image_path"]."\" class=\"left-unlock\" />";
      }
      //if the number is odd, it's the second image, or the second image in a set
      if($count % 2 == 1){
        echo "<img src=\"".$row["image_path"]."\" class=\"right-unlock\" /></div>";
      }

      $count++;
    }
    //if the number is odd then the last processed number was even so then the div container was never closed for the set.
    if($count % 2 == 1){
      echo "</div>";
    }
  }

  function displayOptOutButton(){
    global $data_accessor;

    $result = $data_accessor->checkOptOut();

    if($result === "false"){
      echo "<button class=\"btn btn-primary\" style=\"width: 300px; display: block; margin: 0 auto; margin-bottom: 50px;\" onclick=\"optOut()\">Hide me from Leaderboard</button>";
    }
    else{
      echo "<button class=\"btn btn-primary\" style=\"width: 300px; display: block; margin: 0 auto; margin-bottom: 50px;\" onclick=\"optIn()\">Show me in Leaderboard</button>";
    }
  }

	function displayLeaderboard(){
		global $data_accessor;

	  	$result = $data_accessor->getLeaderboard();

      $tableString = "<div style=\"width: 90%; display: block; margin: 0 auto;\"><table class=\"table table-bordered table-hover\"><thead><th>Position</th><th>Player</th><th>Points</th><th>Achievements</th></thead><tbody>";

	  	$count = 1;
      $lastUserId = null;
	  	foreach($result as $row){
          if($row["user_id"] === $lastUserId){ //if the user is equal to the last user id then just adding more unlock images.
              $tableString .= "<img class=\"achievement-icon\" src=\"".$row["image_path"] . "\" />";
          }
          elseif($count === 1 && $row["user_id"] !== $lastUserId){//if it's the first user, open a new row but don't close it.
              
            $tableString .= ($row["user_id"] === $_SESSION['user_id'] ? "<tr class=\"active\">" : "<tr>");
            $tableString .= "<td>".$count."</td>
                             <td>".$row["alias"]."</td>
                             <td>".$row["points"]."</td>
                             <td>";

            if(isset($row["image_path"])){
              $tableString .= "<img img class=\"achievement-icon\" src=\"".$row["image_path"] . "\" />";
            }  
                  

            $lastUserId = $row["user_id"];
            $count++;
          }
          else{ //this is another new user, close the row, and open a new one.
           
            $tableString .= "</td>";

            $tableString .= "</tr>";
            $tableString .= ($row["user_id"] === $_SESSION['user_id'] ? "<tr class=\"active\">" : "<tr>");
            $tableString .= "<td>".$count."</td>
                             <td>".$row["alias"]."</td>
                             <td>".$row["points"]."</td>
                             <td>";

            if(isset($row["image_path"])){
              $tableString .= "<img class=\"achievement-icon\" src=\"".$row["image_path"] . "\" />";
              $hasUnlocks = true;
            }  

            $lastUserId = $row["user_id"];
            $count++;
          }    

	  	}

      $tableString .= "</td></tr></tbody></table></div>";

      echo $tableString;
  }
	

?>