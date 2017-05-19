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
    <link rel="stylesheet" type="text/css" href="./css/progress-bar.css">
    <link href='https://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="./css/unlock.css">
    <link rel="stylesheet" href="./bootstrap-tour/build/css/bootstrap-tour.css">
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
          <li class="active" id="home-link"><a href="home.php">Home</a></li>
          <li id="habits-link"><a href="manage-habits.php">Manage Habits</a></li>
          <li id="tasks-link"><a href="manage-tasks.php">Manage Tasks</a></li>
          <li id="achievements-link"><a href="achievements.php">View Achievements</a></li>
          <li id="leaderboard-link"><a href="leaderboard.php">View Leaderboard</a></li>
          <li id="help-link"><a href="help.php">Help</a></li>
        </ul>
      
          <div class="karma-points" id="points">
            <img src="./images/badge.png" class="karma-points-image" />
            <p class="karma-points-number"><?php echo $data_accessor->getTotalPoints() ?></p>
          </div>
          <div>
            <h4 style="color: #ffffff; border-bottom: 2px solid #ffffff; padding-left: 20px;">Recent Unlocks</h4>
            <div class="recent-unlocks" id="recent-unlocks">
            <?php getRecentUnlocks(); ?>
            
            </div>
          </div>
          <div class="logout-container">
            <a href="logout.php" class="btn btn-primary logout">Logout</a>
          </div>
        </div>
      </div>
    </div><!--left menu end-->
    <div id="main-content" class="container-fluid">
      

      <!-- daily challenges -->
      <div class="container-fluid daily-challenges-container">
          <h3 id="daily-challenges-header" style="width: 200px;">Daily Challenges</h3>
          
          <div class="row daily-challenges-row">

            <?php getDailies(); ?>
         

        </div>
      </div>


      <div class="row category-container">
        <div id="habits-col" class="col-lg-12">
          <div class="inner-wrapper">
            <h3>My Habits</h3>

            <?php getHabits(); ?>

          </div><!--end of inner wrapper-->
        </div> <!-- end of habits column --> 
     

      
        <div id="tasks-col" class="col-lg-12">
          <div class="inner-wrapper">
            <h3>My Tasks</h3>

            <?php getTasks(); ?>


          </div><!--end of inner wrapper-->
        </div> <!--end of tasks column-->



        <div id="achievements-col" class="col-lg-12">
          <div class="inner-wrapper">
            <h3>My Achievements</h3>

            
            <?php getUserAchievements(); ?>

          </div><!--end of inner wrapper-->
        </div><!--end of achievements column-->


        <div class="unlock-container"></div>
      </div> <!-- end of container row -->
    </div><!-- main content end -->

    
    
    <!-- Bootstrap core JavaScript
      ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type = "text/javascript" 
         src = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script src="./bootstrap-tour/build/js/bootstrap-tour.js"></script>
    
    <?php

      if(isset($_GET['tour'])){
    ?>
      <script>
        $(document).ready(function(){
          // Instance the tour
          var tour = new Tour({
            steps: [
            {
              orphan: true,
              title: "Welcome",
              content: "Hello and welcome! <br /><br />This tour is a short, optional guide through the basics of the site. If you wish to skip, all this information can also be found in the 'Help' section of the menu."
            },
            {
              element: "#home-link",
              title: "The Home Dashboard",
              content: "The Home Dashboard is where you will interact with your Daily Challenges, Habits, Tasks, and see progress towards Achievements."
            },
            {
              element: "#habits-link",
              title: "Habits",
              content: "Habits are simple day to day activities you can do to be more sustainable. Think of things like recycling a can, or remembering to turn off a light switch. I've added a few sample habits for you! <br /><br />The 'Manage Habits' page allows you to add, remove and edit habits. You can also take on habits the community has created! All habits listed under 'My Habits' will appear in your Home Dashboard."
            },
            {
              element: "#tasks-link",
              title: "Tasks",
              content: "Tasks are very similar to habits, but are for activities you will only do once rather than multiple times. Buying a re-useable water bottle would be a good example of a task because you only need one!<br /><br />The 'Manage Tasks' page works the same as Manage Habits, except there are no community tasks. Tasks should be specific to you personally."
            },
            {
              element: "#achievements-link",
              title: "Achievements",
              content: "The 'Achievements' section holds the full list of achievements. Some are points based, which the site keeps track of for you, but there are also some very daunting sustainability challenges in there too! If you complete one of these challenges you can unlock the achievement for yourself on this page. <br /><br />All of your unlocked achievements will be showcased in Leaderboard if you choose to participate."
            },
            {
              element: "#leaderboard-link",
              title: "Leaderboard",
              content: "The site Leaderboard lets you see how you're doing compared to other members. <br /><br />This is optional, and this page has an opt-out button if you wish to be hidden on the leaderboard (you can also opt-in again at any time)."
            },
            {
              element: "#help-link",
              title: "Help",
              content: "The 'Help' section contains all the information from this tour. If you are ever confused about how something on the site works, you can find more information about it here."
            },
            {
              element: "#points",
              title: "The Points System",
              content: "The number in this badge is your total points. When you see a number within this badge on the site, it shows the number of points you'll gain for completing habits, tasks, and daily challenges. <br/><br/>Earning points will get you higher on the leaderboard and can earn you achievements!"
            },
            {
              element: "#recent-unlocks",
              title: "Recent Unlocks",
              content: "This section holds all the icons for the achievements you've unlocked. <br /><br />If you have a small height monitor don't worry, you can hover over the menu and scroll to see any content that looks hidden!"
            },
            {
              element: "#daily-challenges-header",
              title: "Daily Challenges",
              content: "Daily Challenges are the fastest way to earn points. There's new challenges generated everyday, so be sure to keep checking! We also keep track of the daily challenges you complete, so each day you should be getting new options."
            },
            {
              orphan: true,
              title: "Last Few Notes",
              content: "The last important thing to note is creating a new habit (in the 'Manage Habits' page) makes it for both you, and the community. Be sure to check community habits before creating a new one because it might already exist. <br/><br/>So that's the basics! Enjoy the site, and best of luck improving your sustainability!"
            }

          ]});

          // Initialize the tour
          tour.init();

          // Start the tour
          tour.start(true);
        });

      </script>
    <?php
    }
    ?>
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
      
          $("#complete-habit").on('click', function(e){
            e.stopPropagation();
            console.log("completed habit");
            var tempPoints = parseInt($("#points").text());
            tempPoints += 500;
            $("#points").text(tempPoints);
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

      function refreshPoints(){
        $(".karma-points-number").empty();
        $.ajax({
          method: "POST",
          url: "DataAccessor.php",
          data: { action: "get-total-points"}
        })
          .done(function( responseText ) {
            $(".karma-points-number").text(responseText); 
            $("#progress-2").attr('data-progress', Math.floor((responseText / 500) * 100));
            $("#progress-3").attr('data-progress', Math.floor((responseText / 1000) * 100));
            $("#progress-4").attr('data-progress', Math.floor((responseText / 2500) * 100));        
          });
      }

      function refreshRecentUnlocks(){
        $("#recent-unlocks").empty();
        $.ajax({
          method: "POST",
          url: "home.php",
          data: { action: "refresh-recent-unlocks"}
        })
          .done(function( responseText ) {
            $("#recent-unlocks").html(responseText);         
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
          });
      }

      function increment_habit(community_id){

        console.log("beginning ajax request...");
        console.log("incrementing habit id: " + community_id);
        $.ajax({
          method: "POST",
          url: "DataAccessor.php",
          data: { action: "increment-habit", community_id: community_id}
        })
          .done(function( responseText ) {
  
            console.log("ajax request finished");
            
            var status = responseText.split('|')[0];
            var unlocks = JSON.parse(responseText.split('|')[1]);
            
            refreshPoints();

            for(var index = 0; index < unlocks.length; index++){
              unlockAchievement(unlocks[index]);
              setTimeout(renderUnlock, (5500 * index), unlocks[index]); //works
            }

            //refresh recent unlocks if something was unlocked
            if(unlocks.length > 0){
              //refreshRecentUnlocks();;
            }
            
          });
      }

      function decrement_habit(community_id){

        console.log("beginning ajax request...");
        console.log("decrementing habit id: " + community_id);
        $.ajax({
          method: "POST",
          url: "DataAccessor.php",
          data: { action: "decrement-habit", community_id: community_id}
        })
          .done(function(success) {
            refreshPoints();
            console.log("ajax request finished");
            console.log("response text: " + success);
          });
      }

      function completeTask(task_id){
        console.log("beginning ajax request...");
        console.log("completing task id: " + task_id);
        $.ajax({
          method: "POST",
          url: "DataAccessor.php",
          data: { action: "complete-task", task_id: task_id}
        })
          .done(function( responseText ) {
            console.log(responseText);
            
            var status = responseText.split('|')[0];
            var unlocks = JSON.parse(responseText.split('|')[1]);
            refreshPoints();

            for(var index = 0; index < unlocks.length; index++){
              unlockAchievement(unlocks[index]);
              setTimeout(renderUnlock, (5500 * index), unlocks[index]); //works
            }

            //refresh recent unlocks if something was unlocked
            if(unlocks.length > 0){
              refreshRecentUnlocks();
            }

            $("#task-" + task_id).remove();
          });
      }

      function completeDaily(daily_id){

        console.log("beginning ajax request...");
        console.log("completing daily id: " + daily_id);
        $.ajax({
          method: "POST",
          url: "DataAccessor.php",
          data: { action: "complete-daily", daily_id: daily_id}
        })
          .done(function( responseText ) {
            console.log(responseText);
            
            var status = responseText.split('|')[0];
            var unlocks = JSON.parse(responseText.split('|')[1]);
            refreshPoints();

            for(var index = 0; index < unlocks.length; index++){
              unlockAchievement(unlocks[index]);
              setTimeout(renderUnlock, (5500 * index), unlocks[index]); //works
            }

            //refresh recent unlocks if something was unlocked
            if(unlocks.length > 0){
              refreshRecentUnlocks();
            }

            $("#daily-" + daily_id).remove();
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

function getDailies(){

  global $data_accessor;
  $dailies = $data_accessor->getDailies();

  //start count at 1 to match css div ids
  $count = 1;
  foreach($dailies as $daily){
    echo "<div class=\"col-md-8 col-md-offset-2 col-xs-12 daily-challenge-instance daily-challenge-container-".$count."\" id=\"daily-".$daily["daily_id"]."\">";
      echo "<div class=\"daily-challenge-inner\">";
        echo "<h4>".$daily["title"]."</h4>";
        echo "<hr />";
        echo "<div class=\"row\">
                  <div class=\"col-xs-8 large-width-override\">".$daily["description"]."</div>";
                echo "<div class=\"col-xs-4 width-override\" style=\"position: relative;\">";
                echo "<img src=\"./images/badge.png\" style=\"width: 75px; height: 75px; position: relative;\">
                        <div style=\"width: 70px; height: 15px; position: absolute; top: 30px; left: 18px; text-align: center;\">".$daily["karma_points"]."</div>
                      </img>
                    </div>
                    <input class=\"task-checkbox\" style=\"top: 80px;\" type=\"checkbox\" onclick=\"completeDaily(".$daily["daily_id"].")\" />
                 </div>
              </div>
            </div>";
  
    $count++;
  }

}

function getHabits(){
  global $data_accessor;
  $user_id = $_SESSION['user_id'];

  $result = $data_accessor->getUserHabits();

  foreach($result as $habit){

      echo  "<div class=\"row habit-row\">
            <div class=\"col-md-8 col-md-offset-2 col-xs-12 habit-item\">
              <div class=\"row\">
                <div class=\"col-xs-8 large-width-override\">
                  <h4 class=\"habit-name\">".$habit['title']."</h4>
                </div>
                <div class=\"col-xs-4 width-override\">
                  <img src=\"./images/badge.png\" style=\"width: 75px; height: 75px; position: relative; top: 15px;\">
                    <div style=\"width: 70px; height: 15px; position: absolute; top: 45px; left: 18px; text-align: center;\">".$habit["points"]."</div>
                  </img>
                </div>
              </div>
              <div class=\"habit-button-wrapper\">
                <button type=\"button\" class=\"btn btn-default btn-number plus\" data-type=\"plus\" data-field=\"quant[1]\" onclick=\"increment_habit('".$habit['community_habit_id']."')\">
                  <span class=\"glyphicon glyphicon-plus\"></span>
                </button>
                <button type=\"button\" class=\"btn btn-default btn-number minus\" data-type=\"plus\" data-field=\"quant[1]\" onclick=\"decrement_habit('".$habit['community_habit_id']."')\">
                  <span class=\"glyphicon glyphicon-minus\"></span>
                </button>
              </div>
            </div>
          </div>";
  }
}

function getTasks(){
  global $data_accessor;
  $user_id = $_SESSION['user_id'];

  $result = $data_accessor->getActiveTasks();

  foreach($result as $task){
        echo "<div class=\"row task-row\" id=\"task-".$task['task_id']."\">
              <div class=\"col-md-8 col-md-offset-2 col-xs-12 task-wrapper\">
              
                <div class=\"row\">
                  <div class=\"col-xs-8 large-width-override\">
                    <h4 class=\"task-name\">".$task['title']."</h4>
                  </div>
                  <div class=\"col-xs-4 width-override\">
                    <img src=\"./images/badge.png\" style=\"width: 75px; height: 75px; position: relative; top: 15px;\">
                      <div style=\"width: 70px; height: 15px; position: absolute; top: 45px; left: 18px; text-align: center;\">".$task["points"]."</div>
                    </img>
                  </div>
                  
                  <input class=\"task-checkbox\" type=\"checkbox\" onclick=\"completeTask(".$task['task_id'].")\"/>
                </div><!--end of task instance row-->

              </div><!--end of column handler-->
            </div><!--end of task row-->";
  }     
}

function getUserAchievements(){
  global $data_accessor;
  $user_id = $_SESSION['user_id'];

  $result = $data_accessor->getUserAchievements($user_id);

  foreach($result as $achievement){
     echo "<div class=\"row achievement-row\">
              <div class=\"col-md-8 col-md-offset-2 col-xs-12 achievement-wrapper\">
                <div class=\"row\">
                  <div class=\"col-xs-3\">
                    <img src=\"".$achievement["image_path"]."\" class=\"tracked-achievement-icon\"/>
                  </div>
                  <div class=\"col-xs-6\">
                    <h4 class=\"achievement-name\">".$achievement['name']."</h4>
                  </div>
                  <div class=\"col-xs-3\">
                    <div id=\"progress-".$achievement['achievement_id']."\"class=\"radial-progress\" data-progress=\"".($achievement['requirement'] == 0 ? 0 : floor(($achievement['points'] / $achievement['requirement']) * 100))."\">
                      <div class=\"circle\">
                        <div class=\"mask full\">
                          <div class=\"fill\"></div>
                        </div>
                        <div class=\"mask half\">
                          <div class=\"fill\"></div>
                          <div class=\"fill fix\"></div>
                        </div>
                        <div class=\"shadow\"></div>
                      </div>
                      <div class=\"inset\">
                        <div class=\"percentage\">
                          <div class=\"numbers\"><span>-</span><span>0%</span><span>1%</span><span>2%</span><span>3%</span><span>4%</span><span>5%</span><span>6%</span><span>7%</span><span>8%</span><span>9%</span><span>10%</span><span>11%</span><span>12%</span><span>13%</span><span>14%</span><span>15%</span><span>16%</span><span>17%</span><span>18%</span><span>19%</span><span>20%</span><span>21%</span><span>22%</span><span>23%</span><span>24%</span><span>25%</span><span>26%</span><span>27%</span><span>28%</span><span>29%</span><span>30%</span><span>31%</span><span>32%</span><span>33%</span><span>34%</span><span>35%</span><span>36%</span><span>37%</span><span>38%</span><span>39%</span><span>40%</span><span>41%</span><span>42%</span><span>43%</span><span>44%</span><span>45%</span><span>46%</span><span>47%</span><span>48%</span><span>49%</span><span>50%</span><span>51%</span><span>52%</span><span>53%</span><span>54%</span><span>55%</span><span>56%</span><span>57%</span><span>58%</span><span>59%</span><span>60%</span><span>61%</span><span>62%</span><span>63%</span><span>64%</span><span>65%</span><span>66%</span><span>67%</span><span>68%</span><span>69%</span><span>70%</span><span>71%</span><span>72%</span><span>73%</span><span>74%</span><span>75%</span><span>76%</span><span>77%</span><span>78%</span><span>79%</span><span>80%</span><span>81%</span><span>82%</span><span>83%</span><span>84%</span><span>85%</span><span>86%</span><span>87%</span><span>88%</span><span>89%</span><span>90%</span><span>91%</span><span>92%</span><span>93%</span><span>94%</span><span>95%</span><span>96%</span><span>97%</span><span>98%</span><span>99%</span><span>100%</span></div>
                        </div>
                      </div>
                    </div><!--end of radial progress-->
                  </div><!--end of achievement progress column-->
                </div><!--end of achievement row-->
              </div><!--end of achievement wrapper-->
            </div><!--end of achievement item-->";
  }
}

?>