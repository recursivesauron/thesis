<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="icon" href="../../favicon.ico">
    <title>Navbar Template for Bootstrap</title>
    <!-- Bootstrap core CSS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/front-page.css">
    <link rel="stylesheet" href="./css/inner.css">
    <link rel="stylesheet" href="./css/inner4.css">
    <link rel="stylesheet" type="text/css" href="./css/progress-bar.css">
    <link rel="stylesheet" href="./datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    <link href='https://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
    <link href="./bootstrap-slider-master/dist/css/bootstrap-slider.min.css" rel="stylesheet" />
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
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

        <img src="./images/GeneratingSustainability.png" class="header-image"/>

        <ul class="main-navigation">
          <li class="active"><a href="home">Home</a></li>
          <li><a href="manage-habits">Manage Habits</a></li>
          <li><a href="manage-tasks">Manage Tasks</a></li>
          <li><a href="achivements">View Achievements</a></li>
          <li><a href="about">About the Project</a></li>
        </ul>
      
          <div class="karma-points">
            <img src="./images/badge.png" class="karma-points-image" />
            <p class="karma-points-number">5,000</p>
          </div>
          <div class="recent-unlocks">
            <h4>Recent Unlocks</h4>
            <div class="row recent-unlocks-row">
              <img src="./images/borderlands.jpg" class="left-unlock" />
              <img src="./images/civ 5.jpg" class="right-unlock" />
            </div>
            <div class="row recent-unlocks-row">
              <img src="./images/gwent.jpg" class="left-unlock" />
              <img src="./images/meat boy.jpg" class="right-unlock" />
            </div>
            <div class="row recent-unlock-row">
              <img src="./images/rocket-league.jpg" class="left-unlock"/>
              <img src="./images/shadows.jpg" class="right-unlock"/>
            </div>
          </div>
          <div class="logout-container">
            <a href="logout.php" class="btn btn-primary logout">Logout</a>
          </div>
        </div>
      </div>
    </div><!--left menu end-->

    <div id="main-content" class="container-fluid">
      <div class="achievements-wrapper">
        

        <div class="row achievement-instance">
          <div class="col-xs-2">
            <!--image-->
            <img class="achievement-instance-image" src="./images/meat boy.jpg" />
          </div>
          <div class="col-xs-8">
            <!--achievement name and desk-->
            <h3>Golden God</h3>
            <h5>100% the game.</h5>
          </div>
          <div class="col-xs-2">
            <!--optional unlock date-->
            <h6 class="achievement-instance-unlock">Unlocked: 06/07/2016</h6>
          </div>
        </div>


        <div class="row achievement-instance">
          <div class="col-xs-2">
            <!--image-->
            <img class="achievement-instance-image" src="./images/lock.png" />
          </div>
          <div class="col-xs-8">
            <!--achievement name and desk-->
            <h3>A Hidden Achievement Title</h3>
            <h5>A slightly more detailed description of what to do for the achievement.</h5>
          </div>
        </div>


      </div>
    </div><!--main-content end-->
    <!-- Bootstrap core JavaScript
      ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script type = "text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
    <script src="./js/isotope.js"></script>
    <script src="./moment/min/moment.min.js"></script>
    <script src="./datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
     <script>

        jQuery(function ($) {
          // quick search regex
          var qsRegex;
          
          // init Isotope
          var $container = $('.tasks-wrapper').isotope({
            itemSelector: '.task-instance',
            layoutMode: 'fitRows',
            filter: function() {
              return qsRegex ? $(this).text().match( qsRegex ) : true;
            }
          });

          // use value of search field to filter
          var $quicksearch = $('#quicksearch').keyup( debounce( function() {
            qsRegex = new RegExp( $quicksearch.val(), 'gi' );
            $container.isotope();
          }, 200 ) );
          
        });

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
          $( "#slider-range-min" ).slider({
            range: "min",
            value: 10,
            min: 1,
            max: 50,
            slide: function( event, ui ) {
              $( "#amount" ).val(ui.value );
            }
          });
          $( "#amount" ).val( $( "#slider-range-min" ).slider( "value" ) );
        } );
    </script>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker6').datetimepicker();
            $('#datetimepicker7').datetimepicker({
                useCurrent: false //Important! See issue #1075
            });
            $("#datetimepicker6").on("dp.change", function (e) {
                $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
            });
            $("#datetimepicker7").on("dp.change", function (e) {
                $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
            });
        });
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
   
  </body>
</html>