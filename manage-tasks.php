<?php

session_start();
include('./DataAccessor.php');

  //if no valid user_id attached, then abandon page and redirect to login
  if(empty($_SESSION['user_id'])){
    session_destroy();
    header('Location: login.php');
  }

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $action = $_POST['action'];

    switch($action){
      case "show-active":
        getActiveTasks();
        exit();
        break;
      case "show-complete":
        getCompleteTasks();
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
    <link rel="stylesheet" href="./css/tasks.css">
    <link rel="stylesheet" type="text/css" href="./css/progress-bar.css">
    <link href='https://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
    <link href="./bootstrap-slider-master/dist/css/bootstrap-slider.min.css" rel="stylesheet" />
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="./less/less.js-master/dist/less.js" type="text/javascript"></script>
    
    <!-- Bootstrap core JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script type = "text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
    <script src="./js/isotope.js"></script>
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
          <li class="active"><a href="manage-tasks.php">Manage Tasks</a></li>
          <li><a href="achievements.php">View Achievements</a></li>
          <li><a href="leaderboard.php">View Leaderboard</a></li>
          <li><a href="help.php">Help</a></li>
        </ul>
      
          <div class="karma-points">
            <img src="./images/badge.png" class="karma-points-image" />
            <p class="karma-points-number"><?php echo $data_accessor->getTotalPoints($_SESSION['user_id']) ?></p>
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
      
      <!--search input-->
      <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-xs-10 col-xs-offset-1">
          <input class="form-control" type="text" id="quicksearch" placeholder="Search">
        </div>
      </div>

      <ul class="nav nav-pills tasks-filter">
        <li role="presentation" class="nav-active-tasks active"><a href="#" onclick="getActiveTasks();">My Active Tasks</a></li>
        <li role="presentation" class="nav-complete-tasks"><a href="#" onclick="getCompleteTasks();">Completed Tasks</a></li>
        <li><a class="btn btn-default" data-toggle="modal" data-target="#createTask">Create Task</a></li>
      </ul>

      <!-- Modal -->
      <div class="modal fade" id="createTask" tabindex="-1" role="dialog" aria-labelledby="createTaskLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="createTaskLabel">Create a new Task</h4>
            </div>
            <div class="modal-body">
                
                  <h4>Task Name:</h4>
                  <input class="form-control" type="text" id="create-name"/>

                  <br />
                  <h4>Task Description (optional):</h4>
                  <textarea class="form-control" placeholder="Optional description..." id="create-desc"></textarea>

                  <br />
                  <h4>Point Value:</h4>

                  <img src="./images/badge.png" style="width: 75px; height: 75px; display: block; margin: 0 auto;">
                    <div style="width: 70px; height: 15px; position: relative; top: -45px; display: block; margin: 0 auto; text-align: center;"><input type="text" id="create-amount" class="karma-points-amount" style="text-align: center;" readonly></div>
                  </img>
                   
                  <div id="create-task-slider"></div>

                  <div id="ajax-result" style="display: none;"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="createTask();">Create Task!</button>
            </div>
          </div>
        </div>
      </div>

      <div class="tasks-wrapper">

        <?php getActiveTasks(); ?>

        
      </div><!--tasks-wrapper end-->
    </div><!--main-content end-->
    
     <script>
        var container;
        var quicksearch;
        var qsRegex;

        jQuery(function ($) {
          // quick search regex
          
          initializeIsotope();
          
        });

        function initializeIsotope(){
          // init Isotope
          container = $('.tasks-wrapper').isotope({
            itemSelector: '.task-instance',
            layoutMode: 'fitRows',
            filter: function() {
              return qsRegex ? $(this).text().match( qsRegex ) : true;
            }
          });

          // use value of search field to filter
          var quicksearch = $('#quicksearch').keyup( debounce( function() {
            qsRegex = new RegExp( quicksearch.val(), 'gi' );
            container.isotope();
          }, 200 ) );
        }

        // debounce so filtering doesn't happen every millisecond
        function debounce( fn, threshold ) {
          var timeout;
          return function debounced() {
            if ( timeout ) {
              clearTimeout( timeout );
            }
            function delayed() {
              fn();
              timeout = null;
            }
            timeout = setTimeout( delayed, threshold || 100 );
          }
        }
      </script>
    
     <script>
        $( function() {
          $( "#create-task-slider" ).slider({
            range: "min",
            value: 10,
            min: 1,
            max: 15,
            slide: function( event, ui ) {
              $( "#create-amount" ).val(ui.value );
            }
          });
          $( "#create-amount" ).val( $( "#create-task-slider" ).slider( "value" ) );
        } );
    </script>

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
      
          $("#complete-task").on('click', function(e){
            e.stopPropagation();
            console.log("completed task");
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
    </script>
    <script>
    function createTask(){
      var name = $("#create-name").val();
      var description = $("#create-desc").val();
      var points = $("#create-amount").val();

      console.log("beginning ajax request...");
      console.log("name: " + name + ", description: " + description + ", points: " + points);
      $.ajax({
        method: "POST",
        url: "DataAccessor.php",
        data: { action: "create-task", name: name, description: description, points: points }
      })
        .done(function( success ) {
          console.log("ajax request finished");
          console.log("response text: " + success);
          if(success == "true"){
            $("#ajax-result").removeClass("ajax-error");            
            $("#ajax-result").addClass("ajax-success");
            $("#ajax-result").html("<p style=\"text-align: center;\">Your task was created successfully!</p>");
          }
          else{
            $("#ajax-result").removeClass("ajax-success");            
            $("#ajax-result").addClass("ajax-error"); 
            $("#ajax-result").html("<p style=\"text-align: center;\">There was an error! Please check your input and try again.</p>");
          }

          $("#ajax-result").css("display", "block");
        });
    }

    function deleteTask(task_id){
       console.log("calling ajax request...");
       $.ajax({
        method: "POST",
        url: "DataAccessor.php",
        data: { action: "delete-task", task_id: task_id }
      }) 
       .done(function( success ) {
          console.log("response text: " + success);
          $("#task-instance-" + task_id).remove();
        });
    }

    function saveTask(task_id){
      var name = $("#title-" + task_id).val();
      var description = $("#description-" + task_id).val();
      var points = $("#amount-" + task_id).val();

      console.log("beginning ajax request...");
      console.log("task_id: " + task_id,  "name: " + name + ", description: " + description + ", points: " + points);
      $.ajax({
        method: "POST",
        url: "DataAccessor.php",
        data: { action: "save-task", task_id: task_id, name: name, description: description, points: points }
      })
        .done(function( success ) {
          console.log("ajax request finished");
          console.log("response text: " + success);
        });
    }

    function addTask(task_id){
       console.log("calling ajax request...");
       $.ajax({
        method: "POST",
        url: "DataAccessor.php",
        data: { action: "add-task", task_id: task_id }
      }) 
       .done(function( success ) {
          console.log("response text: " + success);
          $("#task-instance-" + task_id).remove();
        });
    }

    function getActiveTasks(){
      $(".nav-active-tasks").addClass("active");
      $(".nav-complete-tasks").removeClass("active");
      $(".tasks-wrapper").empty();
      $.ajax({
        method: "POST",
        url: window.location.pathname,
        data: { action: "show-active"}
      })
        .done(function( responseHTML ) {
          console.log("ajax request finished");
          console.log("response text: " + responseHTML);
          $(".tasks-wrapper").html(responseHTML);
          
          //re-initialize isotope
          container.isotope('reloadItems');
          container.isotope();
        });
    }

    function getCompleteTasks(){
      $(".nav-complete-tasks").addClass("active");
      $(".nav-active-tasks").removeClass("active");
      $(".tasks-wrapper").empty();
      $.ajax({
        method: "POST",
        url: window.location.pathname,
        data: { action: "show-complete"}
      })
        .done(function( responseHTML ) {
          console.log("ajax request finished");
          console.log("response text: " + responseHTML);
          $(".tasks-wrapper").html(responseHTML);
           

           //re-initialize isotope
           container.isotope('reloadItems');
           container.isotope();
        });
    }

    $('#createTask').on('hidden.bs.modal', function () {
        if($(".nav-active-tasks").hasClass("active")){
          getActiveTasks();
        }
        else{
          getCompleteTasks();
        }
    });
    </script>
   
  </body>
</html>


<?php

  function getActiveTasks(){
    
    global $data_accessor;
    $tasks = $data_accessor->getActiveTasks();

    $html = "";
    $scripts = "";

    foreach($tasks as $task){
      $html.= "<div class=\"task-instance\" id=\"task-instance-".$task["task_id"]."\">  
                  <div class=\"row\">
                  <div class=\"col-md-6 col-xs-8\">
                  <textarea id=\"title-".$task["task_id"]."\" class=\"form-control task-instance-name\" placeholder=\"Task name.\">".$task["title"]."</textarea>
              </div>
              <div class=\"col-md-6 col-xs-4\">
                <a style=\"float: right;\" onclick=\"deleteTask(".$task["task_id"].")\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-trash\"></span></a>
                <a style=\"float: right; margin-right: 5px;\" onclick=\"saveTask(".$task["task_id"].")\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-floppy-disk\"></span></a>
              </div> 
            </div>
            <hr />            

            <div class=\"row\">
              <div class=\"col-md-4 col-xs-12\">
                <img src=\"./images/badge.png\" style=\"width: 75px; height: 75px; display: block; margin: 0 auto;\">
                    <div style=\"width: 70px; height: 15px; position: relative; top: -45px; display: block; margin: 0 auto; text-align: center;\"><input type=\"text\" id=\"amount-".$task["task_id"]."\" class=\"karma-points-amount\" style=\"text-align: center;\" readonly></div>
                </img>
                <!-- slider -->
                <div class=\"section\">
                                     
                  <div id=\"slider-".$task["task_id"]."\"></div>
                </div>

              </div>
              <div class=\"col-md-8 col-xs-12\">
                <textarea id=\"description-".$task["task_id"]."\" class=\"form-control\" style=\"height: 100px;\"  placeholder=\"(optional) Enter a small description about this task\">".$task["description"]."</textarea>
              </div>
            </div>
          </div>";


      $scripts.= "<script>$( function() {
                    $( \"#slider-".$task["task_id"]."\" ).slider({
                      range: \"min\",
                      value: ".$task["points"].",
                      min: 1,
                      max: 15,
                      slide: function( event, ui ) {
                        $( \"#amount-".$task["task_id"]."\" ).val(ui.value );
                      }
                    });
                    $( \"#amount-".$task["task_id"]."\" ).val( $( \"#slider-".$task["task_id"]."\" ).slider( \"value\" ) );
                  } );</script>";
    }


    echo $html;
    echo $scripts;

  }



  function getCompleteTasks(){
    
    global $data_accessor;
    $tasks = $data_accessor->getCompleteTasks($_SESSION['user_id']);

    $html = "";
    $scripts = "";

    foreach($tasks as $task){
      $html.= "<div class=\"task-instance\" id=\"task-instance-".$task["task_id"]."\">  
                  <div class=\"row\">
                  <div class=\"col-md-6 col-xs-8\">
                  <textarea id=\"title-".$task["task_id"]."\" class=\"form-control task-instance-name\" placeholder=\"Task name.\" readonly>".$task["title"]."</textarea>
              </div>
              <div class=\"col-md-6 col-xs-4\">
                <a style=\"float: right;\" onclick=\"addTask(".$task["task_id"].")\" class=\"btn btn-primary\">Add to Active Tasks</a>
              </div> 
            </div>
            <hr />            

            <div class=\"row\">
              <div class=\"col-md-4 col-xs-12\">
                <img src=\"./images/badge.png\" style=\"width: 75px; height: 75px; display: block; margin: 0 auto;\">
                    <div style=\"width: 70px; height: 15px; position: relative; top: -45px; display: block; margin: 0 auto; text-align: center;\"><input type=\"text\" id=\"amount-".$task["task_id"]."\" class=\"karma-points-amount\" value=\"".$task["points"]."\" style=\"text-align: center;\" readonly></div>
                </img>
                    

              </div>
              <div class=\"col-md-8 col-xs-12\">
                <textarea id=\"description-".$task["task_id"]."\" class=\"form-control\" style=\"height: 100px;\"  placeholder=\"(optional) Enter a small description about this task\" readonly>".$task["description"]."</textarea>
              </div>
            </div>
          </div>";
    }


    echo $html;

  }

  function getRecentUnlocks(){
  global $data_accessor;
  $user_id = $_SESSION['user_id'];

  $result = $data_accessor->getRecentUnlocks($user_id);

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

  ?>