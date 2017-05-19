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


  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $action = $_POST['action'];

    switch($action){
      case "refresh-recent-unlocks":
        getRecentUnlocks();
        exit();
        break;
      default:
        break;
    }
  }


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
    <link rel="stylesheet" href="./css/achievements.css">    
    <link rel="stylesheet" type="text/css" href="./css/progress-bar.css">
    <link href='https://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="./css/unlock.css">
    <script src="./less/less.js-master/dist/less.js" type="text/javascript"></script>
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
          <li class="active"><a href="achievements.php">View Achievements</a></li>
          <li><a href="leaderboard.php">View Leaderboard</a></li>
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
      <div class="achievements-wrapper">
        
      <?php getLockedAchievements(); ?>

      <?php getUnlockedAchievements(); ?>

      <div class="unlock-container"></div>
      </div>
    </div><!--main-content end-->

    
    
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

      $(function(){
      
          $("#optionsToggle").on('click', function(){
            showOptions();
          });
      
      
           function showOptions(){
            console.log("calling show options");
      
            //if the options box is hidden, show it.
            var tempBool = $(".arrow_box").is(":visible");
            if(tempBool){
              console.log("hiding element...");
              $(".arrow_box").hide();
            }
            else{
              console.log("showing element...");
              $(".arrow_box").show();
            }

        }
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

      function refreshRecentUnlocks(){
        $(".recent-unlocks").empty();
        $.ajax({
          method: "POST",
          url: "home.php",
          data: { action: "refresh-recent-unlocks"}
        })
          .done(function( responseText ) {
            $(".recent-unlocks").html("<h4>Recent Unlocks</h4>" + responseText);         
          });
      }

      function renderUnlock(id){
          $.ajax({
          method: "POST",
          url: "DataAccessor.php",
          data: { action: "get-achievement-by-id", id: id}
        })
          .done(function( responseText ) {
            console.log("ajax request finished");
            console.log("achievement lookup id " + id);
           //console.log("response text: " + responseText);
            var details = JSON.parse(responseText);
            //console.log("details array: " + details);
            //console.log("<div class=\"achievement-banner\"><div class=\"achievement-icon\"><img style=\"border-radius: 50px;\" class=\"icon\" src=\""+details["image_path"]+"\" /></div><div class=\"achievement-text\"><p class=\"achievement-notification\">Achievement unlocked</p><p class=\"achievement-name\">"+details["name"]+"</p></div></div>");
            console.log(details);
            console.log("details image path: " + details[0]["image_path"]);
            console.log("details name: " + details[0]["name"]);  
              $(".unlock-container").html("<div class=\"achievement-banner\"><div class=\"achievement-icon\"><img style=\"border-radius: 50px;\" class=\"icon\" src=\""+details[0]["image_path"]+"\" /></div><div class=\"achievement-text\"><p class=\"achievement-notification\">Achievement unlocked</p><p class=\"achievement-name\">"+details[0]["name"]+"</p></div></div>");             
          });
      }

      function refreshAchievementItem(achievement_id){
        $("#achievement-instance-" + achievement_id).empty();

        $.ajax({
            method: "POST",
            url: "DataAccessor.php",
            data: { action: "get-completed-achievement", id: achievement_id}
          })
        .done(function( responseText ) {
            var details = JSON.parse(responseText);
            console.log(details);
            $("#achievement-instance-" + achievement_id).html("<div class=\"col-xs-2\"><!--image--><img class=\"achievement-instance-image\" src=\"" + details[0]["image_path"] + "\" /></div><div class=\"col-xs-8\"><!--achievement name and desc--><h3>" + details[0]["name"] + "</h3><h5>" + details[0]["description"] + "</h5></div><div class=\"col-xs-2\"><!--optional unlock date / complete button--><h6 class=\"achievement-instance-unlock\">Unlocked: " + details[0]["time_completed"] + "</h6></div>");
        
          });
        }

      function unlockAchievement(achievement_id){
          $.ajax({
            method: "POST",
            url: "DataAccessor.php",
            data: { action: "unlock-achievement", achievement_id: achievement_id}
          })
          .done(function( responseText ) {
              console.log("achievements have been unlocked");
              refreshAchievementItem(achievement_id);
              renderUnlock(achievement_id); 
              refreshRecentUnlocks();        
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

function getLockedAchievements(){
    global $data_accessor;

    $result = $data_accessor->getLockedAchievements();
    foreach($result as $row){
        $stringBuilder =  "<div class=\"row achievement-instance\" id=\"achievement-instance-". $row["achievement_id"]."\">
                              <div class=\"col-xs-2\">
                                <!--image-->
                                <img class=\"achievement-instance-image\" src=\"./images/lock.png\" />
                              </div>
                              <div class=\"col-xs-8\">
                                <!--achievement name and desc-->
                                <h3>" . $row["name"] . "</h3>
                                <h5>" . $row["description"] . "</h5>
                              </div>
                              <div class=\"col-xs-2\">
                                <!--optional unlock date / complete button-->";

        if($row["type"] === "r"){
          $stringBuilder .= "<button class=\"btn btn-primary\" onclick=\"unlockAchievement(".$row["achievement_id"].")\" style=\"margin-top: 30px;\">Complete!</button>";
        }
          
        $stringBuilder .= "</div>
                          </div>";
                             
        echo $stringBuilder;                 
    } 
}

function getUnlockedAchievements(){
  global $data_accessor;

  $result = $data_accessor->getUnlockedAchievements();
  foreach($result as $row){
      echo "<div class=\"row achievement-instance achievement-instance-". $row["achievement_id"]."\">
              <div class=\"col-xs-2\">
                <!--image-->
                <img class=\"achievement-instance-image\" src=\"" . $row["image_path"] . "\" />
              </div>
              <div class=\"col-xs-8\">
                <!--achievement name and desc-->
                <h3>" . $row["name"] . "</h3>
                <h5>" . $row["description"] . "</h5>
              </div>
              <div class=\"col-xs-2\">
                <!--optional unlock date / complete button-->
                 <h6 class=\"achievement-instance-unlock\">Unlocked: " . $row["time_completed"] . "</h6>
              </div>
            </div>";
  }
}

?>
