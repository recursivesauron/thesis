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
          <li><a href="achievements.php">View Achievements</a></li>
          <li><a href="leaderboard.php">View Leaderboard</a></li>
          <li class="active"><a href="help.php">Help</a></li>
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
      <div style="width: 90%; display: block; margin: 0 auto;">
        <h3>The Home Dashboard</h3>
        <hr />

        <p>The Home Dashboard is where you will interact with your Daily Challenges, Habits, Tasks, and see progress towards Achievements.</p>
        <p>On this page you can complete tasks, and daily challenges by clicking on their checkbox. Once completed, they will disappear from your Home Dashboard. Completed tasks will be added to the "Completed Tasks" section of your "Manage Tasks" page, and the site will keep track of your completed Daily Challenges to make sure you keep getting new ones!
        <p>You can complete a "Habit" action by clicking the "+" or "-" buttons. Clicking the plus earns you the shown number of points, and clicking the minus takes that amount of points away. Your habits won't disappear, because they are meant to be small things that you complete more than once. Be sure to be honest when you're completing all your activities!</p>

        <br />
        <h3>Manage Habits</h3>
        <hr />
        <p>Habits are simple day to day activities you can do to be more sustainable. Think of things like recycling a can, or remembering to turn off a light switch. I've added a few sample habits for you!</p>
        <p>The 'Manage Habits' page allows you to add, remove and edit habits. You can also take on habits the community has created! All habits listed under 'My Habits' will appear in your Home Dashboard.</p>
        <p>It's important to mention that any new habit that you create get's added to BOTH 'My Habits' and 'Community Habits'. This only happens on creation though, you can go through and edit your habits however you like, and whatever changes you save will be just for you. After taking on a community habit, you can also edit it how you would like, and that saves changes for just you.</p>

        <img src="./images/habit.png" style="display: block; margin: 0 auto;"></img>

        <br />
        <p>Using the above image as an example, I'll explain what you can do with habits. Any text shown in a habit can be directly edited to your liking. You can adjust the amount of points a habit is worth by dragging the slider in the bottom left corner. Habits can be removed from your 'My Habits' section by clicking the gray trash can icon in the top right. Don't forget, since habits are also added to Community Habits when you create them, you can always add this habit back to My Habits by searching in Community Habits.</p>

        <p>Any changes you make won't be saved until you click the blue save icon in the top right corner. Once you click this, what you see on screen for that particular habit is immediately updated in our systems, and you'll see the changes right away on every other page.</p>

        <br />
        <h3>Manage Tasks</h3>
        <hr />
        <p>Tasks are very similar to habits, but are for activities you will only do once rather than multiple times. Buying a re-useable water bottle would be a good example of a task because you only need one! The 'Manage Tasks' page works the same as Manage Habits, except there are no community tasks. Tasks should be specific to you personally.</p>

        <p>For help regarding use of tasks, please refer to the Manage Habits section above, as Habits and Tasks work the same way.</p>

        <br />
        <h3>Achievements</h3>
        <hr />
        <p>The 'Achievements' section holds the full list of achievements. Some are points based, which the site keeps track of for you, but there are also some very daunting sustainability challenges in there too! If you complete one of these challenges you can unlock the achievement for yourself on this page. All of your unlocked achievements will be showcased in Leaderboard if you choose to participate.</p>

        <br />
        <h3>Leaderboard</h3>
        <hr />
        <p>The site Leaderboard lets you see how you're doing compared to other members. This is optional, and this page has an opt-out button if you wish to be hidden on the leaderboard (you can also opt-in again at any time).</p>

        <br />
        <h3>The Points System</h3>
        <hr />
        <img src="./images/badge.png" style="width: 200px; height: auto; display: block; margin: 0 auto;"></img>
        <br />
        <p>The number in badge shown above is your total points. When you see a number within this badge on the site, it shows the number of points you'll gain for completing habits, tasks, and daily challenges. Earning points will get you higher on the leaderboard and can earn you achievements!</p>
        <p>All point milestone achievements are tracked for you, and you'll be able to see your progress in your Home Dashboard.</p>

        <br />
        <h3>Daily Challenges</h3>
        <hr />
        <p>Daily Challenges are the fastest way to earn points.</p>
        <p>You may notice some daily challenges have a note saying "for the week". If you've already done this task earlier this week, or will do it later in the week then good job! You've completed this challenge, and should check it off today to collect your points.</p>
        <p>There's new challenges generated everyday at midnight EST, so be sure to keep checking! We also keep track of the daily challenges you complete, so each day you should keep getting new challenges until you've completed them all.</p>

        <br />
        <h3>Recent Unlocks</h3>
        <hr />
        <p>The Recent Unlocks section of the menu holds all the icons for the achievements you've unlocked. If you have a small height monitor don't worry, you can hover over the menu and scroll to see any content that looks hidden!</p>
        <br />
        <br />
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

      function unlockAchievement(achievement_id){
          $.ajax({
            method: "POST",
            url: "DataAccessor.php",
            data: { action: "unlock-achievement", achievement_id: achievement_id}
          })
          .done(function( responseText ) {
              console.log("achievements have been unlocked");
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
