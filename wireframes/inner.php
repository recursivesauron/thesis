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
    <link rel="stylesheet" type="text/css" href="./css/progress-bar.css">
    <link href='https://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
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
      

      <!-- daily challenges -->
      <div class="container-fluid daily-challenges-container">
          <h3>Daily Challenges</h3>
          
          <div class="row">

            <div class="col-lg-4 col-md-8 col-md-offset-2 col-xs-12 col-lg-offset-0" id="daily-challenge-container-1">
              <div class="daily-challenge-inner">
                <h4>Challenge Title</h4>
                <hr />

                <table style="display: block; vertical-align: middle;">
                  <tbody>
                    <tr>
                      <td colspan="2" style="padding-left: 10px; padding-right: 5px;">A small description of the challenge...</td>
                      <td style="padding-left: 20px; padding-right: 5px;">
                        <button type="button" class="btn btn-default btn-circle btn-lg" style="background-color: #ffc107; color: white; font-weight: bold; margin: 0 auto;">
                          <p style="margin-left: -7px;">150</p>
                        </button>
                      </td>
                      <td style="padding-left: 5px; padding-right: 5px;"><input type="checkbox" style="display: block; margin: 0 auto; min-width: 75px;"/></td>
                    </tr>
                  </tbody>
                </table>

              


              </div>
            </div>
            <div class="col-lg-4 col-md-8 col-md-offset-2 col-xs-12 col-lg-offset-0" id="daily-challenge-container-2">
              <div class="daily-challenge-inner">
                <h4>Challenge Title</h4>
                <hr />


                <table style="display: block; vertical-align: middle;">
                  <tbody>
                    <tr>
                      <td colspan="2" style="padding-left: 10px; padding-right: 5px;">A small description of the challenge...</td>
                      <td style="padding-left: 20px; padding-right: 5px;">
                        <button type="button" class="btn btn-default btn-circle btn-lg" style="background-color: #ffc107; color: white; font-weight: bold; margin: 0 auto;">
                          <p style="margin-left: -7px;">150</p>
                        </button>
                      </td>
                      <td style="padding-left: 5px; padding-right: 5px;"><input type="checkbox" style="display: block; margin: 0 auto; min-width: 75px;"/></td>
                    </tr>
                  </tbody>
                </table>


              </div>
            </div>
            
            <div class="col-lg-4 col-md-8 col-md-offset-2 col-xs-12 col-lg-offset-0" id="daily-challenge-container-3">
              <div class="daily-challenge-inner">
                <h4>Challenge Title</h4>
                <hr />


                <table style="display: block; vertical-align: middle;">
                  <tbody>
                    <tr>
                      <td colspan="2" style="padding-left: 10px; padding-right: 5px;">A small description of the challenge...</td>
                      <td style="padding-left: 20px; padding-right: 5px;">
                        <button type="button" class="btn btn-default btn-circle btn-lg" style="background-color: #ffc107; color: white; font-weight: bold; margin: 0 auto;">
                          <p style="margin-left: -7px;">150</p>
                        </button>
                      </td>
                      <td style="padding-left: 5px; padding-right: 5px;"><input type="checkbox" style="display: block; margin: 0 auto; min-width: 75px;"/></td>
                    </tr>
                  </tbody>
                </table>


              </div>
            </div>
         

        </div>
      </div>


      <div class="row category-container">
        <div id="habits-col" class="col-lg-4 col-xs-12">
          <div class="inner-wrapper">
            <h3>My Habits</h3>

            <div class="row">
              <div class="col-lg-12 col-lg-offset-0 col-md-8 col-md-offset-2 col-xs-12 habit-item">
                <div class="row">
                  <div class="col-xs-6">
                    <h4 class="habit-name">Item Full Name</h4>
                  </div>
                  <div class="col-xs-6">
                    <button type="button" class="btn btn-default btn-circle btn-lg karma-circle">
                      <p class="karma-circle-number">150</p>
                    </button>
                  </div>
                </div>
                <div class="habit-button-wrapper">
                  <button type="button" class="btn btn-default btn-number plus" data-type="plus" data-field="quant[1]">
                    <span class="glyphicon glyphicon-plus"></span>
                  </button>
                  <button type="button" class="btn btn-default btn-number minus" data-type="plus" data-field="quant[1]">
                    <span class="glyphicon glyphicon-minus"></span>
                  </button>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12 col-lg-offset-0 col-md-8 col-md-offset-2 col-xs-12 habit-item">
                <div class="row">
                  <div class="col-xs-6">
                    <h4 class="habit-name">Item Full Name</h4>
                  </div>
                  <div class="col-xs-6">
                    <button type="button" class="btn btn-default btn-circle btn-lg karma-circle">
                      <p class="karma-circle-number">150</p>
                    </button>
                  </div>
                </div>
                <div class="habit-button-wrapper">
                  <button type="button" class="btn btn-default btn-number plus" data-type="plus" data-field="quant[1]">
                    <span class="glyphicon glyphicon-plus"></span>
                  </button>
                  <button type="button" class="btn btn-default btn-number minus" data-type="plus" data-field="quant[1]">
                    <span class="glyphicon glyphicon-minus"></span>
                  </button>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12 col-lg-offset-0 col-md-8 col-md-offset-2 col-xs-12 habit-item">
                <div class="row">
                  <div class="col-xs-6">
                    <h4 class="habit-name">Item Full Name</h4>
                  </div>
                  <div class="col-xs-6">
                    <button type="button" class="btn btn-default btn-circle btn-lg karma-circle">
                      <p class="karma-circle-number">150</p>
                    </button>
                  </div>
                </div>
                <div class="habit-button-wrapper">
                  <button type="button" class="btn btn-default btn-number plus" data-type="plus" data-field="quant[1]">
                    <span class="glyphicon glyphicon-plus"></span>
                  </button>
                  <button type="button" class="btn btn-default btn-number minus" data-type="plus" data-field="quant[1]">
                    <span class="glyphicon glyphicon-minus"></span>
                  </button>
                </div>
              </div>
            </div>

          </div><!--end of inner wrapper-->
        </div> <!-- end of habits column --> 
     

      
        <div id="tasks-col" class="col-lg-4 col-xs-12">
          <div class="inner-wrapper">
            <h3>My Tasks</h3>

            <div class="row">
              <div class="col-lg-12 col-lg-offset-0 col-md-8 col-md-offset-2 col-xs-12 task-wrapper">
              
                <div class="row">
                  <div class="col-xs-6">
                    <h4 class="task-name">Item Full Name</h4>
                  </div>
                  <div class="col-xs-6">
                    <button type="button" class="btn btn-default btn-circle btn-lg karma-circle">
                      <p class="karma-circle-number">150</p>
                    </button>
                  </div>
                  
                  <input class="task-checkbox" type="checkbox"/>
                </div><!--end of task instance row-->

              </div><!--end of column handler-->
            </div><!--end of task row-->

            <div class="row">
              <div class="col-lg-12 col-lg-offset-0 col-md-8 col-md-offset-2 col-xs-12 task-wrapper">
              
                <div class="row">
                  <div class="col-xs-6">
                    <h4 class="task-name">Item Full Name</h4>
                  </div>
                  <div class="col-xs-6">
                    <button type="button" class="btn btn-default btn-circle btn-lg karma-circle">
                      <p class="karma-circle-number">150</p>
                    </button>
                  </div>
                  
                  <input class="task-checkbox" type="checkbox"/>
                </div><!--end of task instance row-->

              </div><!--end of column handler-->
            </div><!--end of task row-->

            <div class="row">
              <div class="col-lg-12 col-lg-offset-0 col-md-8 col-md-offset-2 col-xs-12 task-wrapper">
              
                <div class="row">
                  <div class="col-xs-6">
                    <h4 class="task-name">Item Full Name</h4>
                  </div>
                  <div class="col-xs-6">
                    <button type="button" class="btn btn-default btn-circle btn-lg karma-circle">
                      <p class="karma-circle-number">150</p>
                    </button>
                  </div>
                  
                  <input class="task-checkbox" type="checkbox"/>
                </div><!--end of task instance row-->

              </div><!--end of column handler-->
            </div><!--end of task row-->


          </div><!--end of inner wrapper-->
        </div> <!--end of tasks column-->



        <div id="achievements-col" class="col-lg-4 col-xs-12">
          <div class="inner-wrapper">
            <h3>My Achievements</h3>

            <div class="row">
              <div class="col-lg-12 col-lg-offset-0 col-md-8 col-md-offset-2 col-xs-12 achievement-wrapper">
                <div class="row">
                  <div class="col-xs-3">
                    <img src="./images/rocket-league.jpg" class="tracked-achievement-icon"/>
                  </div>
                  <div class="col-xs-6">
                    <h4 class="achievement-name">Achievement Name</h4>
                  </div>
                  <div class="col-xs-3">
                    <div class="radial-progress" data-progress="30">
                      <div class="circle">
                        <div class="mask full">
                          <div class="fill"></div>
                        </div>
                        <div class="mask half">
                          <div class="fill"></div>
                          <div class="fill fix"></div>
                        </div>
                        <div class="shadow"></div>
                      </div>
                      <div class="inset">
                        <div class="percentage">
                          <div class="numbers"><span>-</span><span>0%</span><span>1%</span><span>2%</span><span>3%</span><span>4%</span><span>5%</span><span>6%</span><span>7%</span><span>8%</span><span>9%</span><span>10%</span><span>11%</span><span>12%</span><span>13%</span><span>14%</span><span>15%</span><span>16%</span><span>17%</span><span>18%</span><span>19%</span><span>20%</span><span>21%</span><span>22%</span><span>23%</span><span>24%</span><span>25%</span><span>26%</span><span>27%</span><span>28%</span><span>29%</span><span>30%</span><span>31%</span><span>32%</span><span>33%</span><span>34%</span><span>35%</span><span>36%</span><span>37%</span><span>38%</span><span>39%</span><span>40%</span><span>41%</span><span>42%</span><span>43%</span><span>44%</span><span>45%</span><span>46%</span><span>47%</span><span>48%</span><span>49%</span><span>50%</span><span>51%</span><span>52%</span><span>53%</span><span>54%</span><span>55%</span><span>56%</span><span>57%</span><span>58%</span><span>59%</span><span>60%</span><span>61%</span><span>62%</span><span>63%</span><span>64%</span><span>65%</span><span>66%</span><span>67%</span><span>68%</span><span>69%</span><span>70%</span><span>71%</span><span>72%</span><span>73%</span><span>74%</span><span>75%</span><span>76%</span><span>77%</span><span>78%</span><span>79%</span><span>80%</span><span>81%</span><span>82%</span><span>83%</span><span>84%</span><span>85%</span><span>86%</span><span>87%</span><span>88%</span><span>89%</span><span>90%</span><span>91%</span><span>92%</span><span>93%</span><span>94%</span><span>95%</span><span>96%</span><span>97%</span><span>98%</span><span>99%</span><span>100%</span></div>
                        </div>
                      </div>
                    </div><!--end of radial progress-->
                  </div><!--end of achievement progress column-->
                </div><!--end of achievement row-->
              </div><!--end of achievement wrapper-->
            </div><!--end of achievement item-->

            <div class="row">
              <div class="col-lg-12 col-lg-offset-0 col-md-8 col-md-offset-2 col-xs-12 achievement-wrapper">
                <div class="row">
                  <div class="col-xs-3">
                    <img src="./images/rocket-league.jpg" class="tracked-achievement-icon"/>
                  </div>
                  <div class="col-xs-6">
                    <h4 class="achievement-name">Achievement Name</h4>
                  </div>
                  <div class="col-xs-3">
                    <div class="radial-progress" data-progress="30">
                      <div class="circle">
                        <div class="mask full">
                          <div class="fill"></div>
                        </div>
                        <div class="mask half">
                          <div class="fill"></div>
                          <div class="fill fix"></div>
                        </div>
                        <div class="shadow"></div>
                      </div>
                      <div class="inset">
                        <div class="percentage">
                          <div class="numbers"><span>-</span><span>0%</span><span>1%</span><span>2%</span><span>3%</span><span>4%</span><span>5%</span><span>6%</span><span>7%</span><span>8%</span><span>9%</span><span>10%</span><span>11%</span><span>12%</span><span>13%</span><span>14%</span><span>15%</span><span>16%</span><span>17%</span><span>18%</span><span>19%</span><span>20%</span><span>21%</span><span>22%</span><span>23%</span><span>24%</span><span>25%</span><span>26%</span><span>27%</span><span>28%</span><span>29%</span><span>30%</span><span>31%</span><span>32%</span><span>33%</span><span>34%</span><span>35%</span><span>36%</span><span>37%</span><span>38%</span><span>39%</span><span>40%</span><span>41%</span><span>42%</span><span>43%</span><span>44%</span><span>45%</span><span>46%</span><span>47%</span><span>48%</span><span>49%</span><span>50%</span><span>51%</span><span>52%</span><span>53%</span><span>54%</span><span>55%</span><span>56%</span><span>57%</span><span>58%</span><span>59%</span><span>60%</span><span>61%</span><span>62%</span><span>63%</span><span>64%</span><span>65%</span><span>66%</span><span>67%</span><span>68%</span><span>69%</span><span>70%</span><span>71%</span><span>72%</span><span>73%</span><span>74%</span><span>75%</span><span>76%</span><span>77%</span><span>78%</span><span>79%</span><span>80%</span><span>81%</span><span>82%</span><span>83%</span><span>84%</span><span>85%</span><span>86%</span><span>87%</span><span>88%</span><span>89%</span><span>90%</span><span>91%</span><span>92%</span><span>93%</span><span>94%</span><span>95%</span><span>96%</span><span>97%</span><span>98%</span><span>99%</span><span>100%</span></div>
                        </div>
                      </div>
                    </div><!--end of radial progress-->
                  </div><!--end of achievement progress column-->
                </div><!--end of achievement row-->
              </div><!--end of achievement wrapper-->
            </div><!--end of achievement item-->

            <div class="row">
              <div class="col-lg-12 col-lg-offset-0 col-md-8 col-md-offset-2 col-xs-12 achievement-wrapper">
                <div class="row">
                  <div class="col-xs-3">
                    <img src="./images/rocket-league.jpg" class="tracked-achievement-icon"/>
                  </div>
                  <div class="col-xs-6">
                    <h4 class="achievement-name">Achievement Name</h4>
                  </div>
                  <div class="col-xs-3">
                    <div class="radial-progress" data-progress="30">
                      <div class="circle">
                        <div class="mask full">
                          <div class="fill"></div>
                        </div>
                        <div class="mask half">
                          <div class="fill"></div>
                          <div class="fill fix"></div>
                        </div>
                        <div class="shadow"></div>
                      </div>
                      <div class="inset">
                        <div class="percentage">
                          <div class="numbers"><span>-</span><span>0%</span><span>1%</span><span>2%</span><span>3%</span><span>4%</span><span>5%</span><span>6%</span><span>7%</span><span>8%</span><span>9%</span><span>10%</span><span>11%</span><span>12%</span><span>13%</span><span>14%</span><span>15%</span><span>16%</span><span>17%</span><span>18%</span><span>19%</span><span>20%</span><span>21%</span><span>22%</span><span>23%</span><span>24%</span><span>25%</span><span>26%</span><span>27%</span><span>28%</span><span>29%</span><span>30%</span><span>31%</span><span>32%</span><span>33%</span><span>34%</span><span>35%</span><span>36%</span><span>37%</span><span>38%</span><span>39%</span><span>40%</span><span>41%</span><span>42%</span><span>43%</span><span>44%</span><span>45%</span><span>46%</span><span>47%</span><span>48%</span><span>49%</span><span>50%</span><span>51%</span><span>52%</span><span>53%</span><span>54%</span><span>55%</span><span>56%</span><span>57%</span><span>58%</span><span>59%</span><span>60%</span><span>61%</span><span>62%</span><span>63%</span><span>64%</span><span>65%</span><span>66%</span><span>67%</span><span>68%</span><span>69%</span><span>70%</span><span>71%</span><span>72%</span><span>73%</span><span>74%</span><span>75%</span><span>76%</span><span>77%</span><span>78%</span><span>79%</span><span>80%</span><span>81%</span><span>82%</span><span>83%</span><span>84%</span><span>85%</span><span>86%</span><span>87%</span><span>88%</span><span>89%</span><span>90%</span><span>91%</span><span>92%</span><span>93%</span><span>94%</span><span>95%</span><span>96%</span><span>97%</span><span>98%</span><span>99%</span><span>100%</span></div>
                        </div>
                      </div>
                    </div><!--end of radial progress-->
                  </div><!--end of achievement progress column-->
                </div><!--end of achievement row-->
              </div><!--end of achievement wrapper-->
            </div><!--end of achievement item-->
          


          </div><!--end of inner wrapper-->
        </div><!--end of achievements column-->



      </div> <!-- end of container row -->
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
    </script>
    
  </body>
</html>