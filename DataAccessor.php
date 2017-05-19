<?php
	@session_start();
	include ('./login-database.php');
	
	global $data_accessor;
  	$data_accessor = new DataAccessor();

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$action = $_POST['action'];

		switch($action){
			case "create-habit":
				if(DataAccessor::validateHabit($_POST['name'], $_POST['description'], $_POST['points'])){
					DataAccessor::createHabit($_POST['name'], $_POST['description'], $_POST['points']);
				}
				else{
					echo "false";
				}
				break;
			case "delete-habit":
				DataAccessor::deleteHabit($_POST['community_id']);
				break;
			case "save-habit":
				DataAccessor::saveHabit($_POST['community_id'], $_POST['name'], $_POST['description'], $_POST['points']);
				break;
			case "add-habit":
				DataAccessor::addHabit($_POST['community_id']);
				break;
			case "create-task":
				if(DataAccessor::validateHabit($_POST['name'], $_POST['description'], $_POST['points'])){
					DataAccessor::createTask($_POST['name'], $_POST['description'], $_POST['points']);
				}
				else{
					echo "false";
				}
				break;
			case "delete-task":
				DataAccessor::deleteTask($_POST['task_id']);
				break;
			case "save-task":
				DataAccessor::saveTask($_POST['task_id'], $_POST['name'], $_POST['description'], $_POST['points']);
				break;
			case "add-task":
				DataAccessor::addTask($_POST['task_id']);
				break;
			case "increment-habit":
				DataAccessor::incrementHabit($_POST['community_id']);
				DataAccessor::checkAchievements();
				break;
			case "decrement-habit":
				DataAccessor::decrementHabit($_POST['community_id']);
				DataAccessor::checkAchievements();
				break;
			case "get-achievement-by-id":
				DataAccessor::getAchievementById($_POST['id']);
				break;
			case "unlock-achievement":
				DataAccessor::unlockAchievement($_POST['achievement_id']);
				break;
			case "get-total-points":
				$DA = new DataAccessor();
				echo $DA->getTotalPoints();
				break;
			case "check-achievements":
				DataAccessor::checkAchievements();
				break;
			case "check-username":
				DataAccessor::checkUsername($_POST['username']);
				break;
			case "complete-task":
				DataAccessor::completeTask($_POST['task_id']);
				DataAccessor::checkAchievements();
				break;
			case "complete-daily":
				DataAccessor::completeDaily($_POST['daily_id']);
				DataAccessor::checkAchievements();
				break;
			case "opt-out":
				DataAccessor::optOut();
				break;
			case "opt-in":
				DataAccessor::optIn();
				break;
			case "get-completed-achievement":
				DataAccessor::getCompletedAchievementById($_POST['id']);
				break;
			default:
				//echo "false";
				break;
		}
	}


	class DataAccessor{
		public $database = null;

		function __construct(){
			$this->database = connectToDatabase();
		}

		public function getTotalPoints(){
			$user_id = $_SESSION['user_id']; 
			$query = "SELECT karma_points FROM users WHERE user_id = :user_id";

			$stmt = $this->database->prepare($query);
			$result = $stmt->execute(array(":user_id" => $user_id));
			return $stmt->fetch()['karma_points'];
		}

		public function getRecentUnlocks(){
			$user_id = $_SESSION['user_id'];
			$query = "SELECT image_path FROM `user_complete_achievements` INNER JOIN achievements ON user_complete_achievements.achievement_id = achievements.achievement_id WHERE user_id = :user_id";
			$stmt = $this->database->prepare($query);
			$result = $stmt->execute(array(":user_id" => $user_id));
			return $stmt->fetchAll();
		}

		public function getDailies(){
			$user_id = $_SESSION['user_id'];

			$query = "SELECT * FROM user_active_dailies INNER JOIN dailies ON user_active_dailies.daily_id = dailies.daily_id WHERE user_id = :user_id";
			$stmt = $this->database->prepare($query);
			$result = $stmt->execute(array(":user_id" => $user_id));
			return $stmt->fetchAll();

		}

		public function getUserHabits(){
			$user_id = $_SESSION['user_id'];

			$query = "SELECT community_habit_id, title, description, karma_points as points FROM user_habits WHERE user_id = :user_id";
			$stmt = $this->database->prepare($query);
			$result = $stmt->execute(array(":user_id" => $user_id));
			return $stmt->fetchAll();
		}

		public function getCommunityHabits(){
			$user_id = $_SESSION['user_id'];

			$query = "SELECT community_habit_id, title, description, karma_points as points FROM community_habits WHERE community_habit_id NOT IN (SELECT community_habit_id FROM user_habits WHERE user_id = :user_id)";
			$stmt = $this->database->prepare($query);
			$result = $stmt->execute(array(":user_id" => $user_id));
			return $stmt->fetchAll();
		}

		public function getActiveTasks(){
			$user_id = $_SESSION['user_id'];

			$query = "SELECT task_id, title, description, karma_points as points FROM tasks WHERE user_id = :user_id AND is_complete = 0";
			$stmt = $this->database->prepare($query);
			$result = $stmt->execute(array(":user_id" => $user_id));
			return $stmt->fetchAll();
		}

		public function getCompleteTasks(){
			$user_id = $_SESSION['user_id'];

			$query = "SELECT task_id, title, description, karma_points as points FROM tasks WHERE user_id = :user_id AND is_complete = 1";
			$stmt = $this->database->prepare($query);
			$result = $stmt->execute(array(":user_id" => $user_id));
			return $stmt->fetchAll();

		}

		public function getUserAchievements($user_id){
			$query = "SELECT users.karma_points as points, user_active_achievements.achievement_id, name, requirement, image_path FROM user_active_achievements INNER JOIN achievements ON user_active_achievements.achievement_id = achievements.achievement_id INNER JOIN users ON user_active_achievements.user_id = users.user_id WHERE user_active_achievements.user_id = :user_id AND is_tracked = 1";
			$stmt = $this->database->prepare($query);
			$result = $stmt->execute(array(":user_id" => $user_id));
			return $stmt->fetchAll();
		}

		public static function validateHabit($name, $description, $points){
			if(!(strlen($name) > 0)){
				return false;
			}

			return true;
		}

		public static function createHabit($name, $description, $points){
			$user_id = $_SESSION['user_id'];
			if($description == ""){
				$description = NULL;
			}

			try{
				$DA = new DataAccessor();
				$DA->database->beginTransaction();
				
				//insert into community habits
				$query = "INSERT into community_habits VALUES(DEFAULT, :name, :description, :points)";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":name" => $name, ":description" => $description, ":points" => $points));

				//insert into personal habits, and use new community id
				$query = "INSERT into user_habits VALUES(:user_id, :community_id, :name, :description, :points)";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":user_id" => $user_id, "community_id" => $DA->database->lastInsertId(), ":name" => $name, ":description" => $description, ":points" => $points));

				$DA->database->commit();
				echo 'true';
			}
			catch(PDOException $ex){
				$DA->database->rollback();
				echo 'false';
			}
			
		}

		public static function deleteHabit($community_id){
			$user_id = $_SESSION['user_id'];

			try{
				$DA = new DataAccessor();
				$query = "DELETE FROM user_habits WHERE user_id = :user_id AND community_habit_id = :community_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":user_id" => $user_id, ":community_id" => $community_id));

				echo 'true';
			}

			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}			
		}

		public static function saveHabit($community_id, $name, $description, $points){
			$user_id = $_SESSION['user_id'];

			if($description == ""){
				$description = NULL;
			}


			try{
				$DA = new DataAccessor();
				$query = "UPDATE user_habits SET title = :name, description = :description, karma_points = :points WHERE user_id = :user_id AND community_habit_id = :community_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":name" => $name, ":description" => $description, ":points" => $points, ":user_id" => $user_id, ":community_id" => $community_id));

				echo 'true';
			}

			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}	
		}

		public static function addHabit($community_id){
			$user_id = $_SESSION['user_id'];

			try{
				$DA = new DataAccessor();
				$query = "INSERT INTO user_habits (user_id, community_habit_id, title, description, karma_points) (SELECT :user_id, community_habit_id, title, description, karma_points FROM community_habits WHERE community_habit_id = :community_id)";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":user_id" => $user_id, ":community_id" => $community_id));

				echo 'true';
			}

			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}			
		}


		public static function createTask($name, $description, $points){
			$user_id = $_SESSION['user_id'];
			if($description == ""){
				$description = NULL;
			}

			try{
				$DA = new DataAccessor();
				
				//insert into users tasks
				$query = "INSERT into tasks VALUES(DEFAULT, :user_id, :name, :description, :points, 0)";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":user_id" => $user_id, ":name" => $name, ":description" => $description, ":points" => $points));

				echo 'true';
			}
			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}
			
		}

		public static function deleteTask($task_id){
			try{
				$DA = new DataAccessor();
				$query = "DELETE FROM tasks WHERE task_id = :task_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":task_id" => $task_id));

				echo 'true';
			}

			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}			
		}

		public static function saveTask($task_id, $name, $description, $points){
			
			if($description == ""){
				$description = NULL;
			}

			try{
				$DA = new DataAccessor();
				$query = "UPDATE tasks SET title = :name, description = :description, karma_points = :points WHERE task_id = :task_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":name" => $name, ":description" => $description, ":points" => $points, ":task_id" => $task_id));

				echo 'true';
			}

			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}	
		}

		public static function addTask($task_id){

			try{
				$DA = new DataAccessor();
				$query = "UPDATE tasks SET is_complete = 0 WHERE task_id = :task_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":task_id" => $task_id));

				echo 'true';
			}

			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}			
		}



		/****************** POINT AND ACHIEVEMENT MANIPULATING FUNCTIONS **************************/
		public static function incrementHabit($community_id){
			try{
				$user_id = $_SESSION['user_id'];

				$DA = new DataAccessor();
				$query = "UPDATE users SET karma_points = karma_points + (SELECT karma_points FROM user_habits WHERE user_id = :user_id AND community_habit_id = :community_id) WHERE user_id = :user_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":user_id" => $user_id, ":community_id" => $community_id));

				echo 'true';
			}

			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}		
		}

		public static function decrementHabit($community_id){
			try{
				$user_id = $_SESSION['user_id'];

				$DA = new DataAccessor();
				$query = "UPDATE users SET karma_points = karma_points - (SELECT karma_points FROM user_habits WHERE user_id = :user_id AND community_habit_id = :community_id) WHERE user_id = :user_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":user_id" => $user_id, ":community_id" => $community_id));

				echo 'true';
			}

			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}
		}

		public static function checkAchievements(){
			try{
				$user_id = $_SESSION['user_id'];

				$DA = new DataAccessor();
				$query = "SELECT u.achievement_id FROM user_active_achievements u INNER JOIN achievements a ON u.achievement_id = a.achievement_id  WHERE user_id = :user_id AND type = 'a'";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":user_id" => $user_id));

				$data_array = $stmt->fetchAll();

				$unlockIds = array();
				foreach($data_array as $achievement){
					switch($achievement['achievement_id']){
						case 1: //top of the leaderboard
							$query = "SELECT IF (:user_id IN (SELECT user_id FROM users WHERE karma_points = (SELECT MAX(karma_points) FROM users)),'true','false') as status";
							$stmt = $DA->database->prepare($query);
							$result = $stmt->execute(array(":user_id" => $user_id));
							$data = $stmt->fetchAll();
							
							if($data[0]['status'] === 'true'){ //true
								array_push($unlockIds, 1);
							} 
							break;
						case 2: //500 points
							$query = "SELECT IF ((SELECT karma_points FROM users WHERE user_id = :user_id) >= 500,'true','false') as status";
							$stmt = $DA->database->prepare($query);
							$result = $stmt->execute(array(":user_id" => $user_id));
							$data = $stmt->fetchAll();
							
							if($data[0]['status'] === 'true'){ //true
								array_push($unlockIds, 2);
							} 
							break;
						case 3: //1000 points
							$query = "SELECT IF ((SELECT karma_points FROM users WHERE user_id = :user_id) >= 1000,'true','false') as status";
							$stmt = $DA->database->prepare($query);
							$result = $stmt->execute(array(":user_id" => $user_id));
							$data = $stmt->fetchAll();
							
							if($data[0]['status'] === 'true'){ //true
								array_push($unlockIds, 3);
							} 
							break;
						case 4: //2500 points
							$query = "SELECT IF ((SELECT karma_points FROM users WHERE user_id = :user_id) >= 2500,'true','false') as status";
							$stmt = $DA->database->prepare($query);
							$result = $stmt->execute(array(":user_id" => $user_id));
							$data = $stmt->fetchAll();
							
							if($data[0]['status'] === 'true'){ //true
								array_push($unlockIds, 4);
							} 
							break;
						default:
							break;
					}

				}

				echo "|" . json_encode($unlockIds);
			}

			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}
		}

		public static function getAchievementById($id){
			try{
				$DA = new DataAccessor();
				$query = "SELECT name, image_path FROM achievements WHERE achievement_id = :id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":id" => $id));
				$data = $stmt->fetchAll();

				//print_r($data);
				echo json_encode($data);
				
			}

			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}
		}

		public static function getCompletedAchievementById($id){
			try{
				$user_id = $_SESSION['user_id'];

				$DA = new DataAccessor();
				$query = "SELECT name, image_path, description, time_completed FROM user_complete_achievements INNER JOIN achievements ON user_complete_achievements.achievement_id = achievements.achievement_id WHERE user_complete_achievements.achievement_id = :id AND user_id = :user_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":id" => $id, ":user_id" => $user_id));
				$data = $stmt->fetchAll();

				//print_r($data);
				echo json_encode($data);
				
			}

			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}
		}

		public static function unlockAchievement($achievement_id){
			
			try{
				$DA = new DataAccessor();
				$DA->database->beginTransaction();
				
				$user_id = $_SESSION['user_id'];

				//remove the unlocked achievement from active achievements
				$query = "DELETE FROM user_active_achievements WHERE user_id = :user_id AND achievement_id = :achievement_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":user_id" => $user_id, ":achievement_id" => $achievement_id));

				//insert the completed achievement into complete achievements
				$query = "INSERT into user_complete_achievements VALUES(:user_id, :achievement_id, NOW())";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":user_id" => $user_id, ":achievement_id" => $achievement_id));

				$DA->database->commit();
				echo 'true';

			}
			catch(PDOException $ex){
				$DA->database->rollback();
				echo 'false';
			}
		}


		public function getLockedAchievements(){
			try{
				$user_id = $_SESSION['user_id'];

				$DA = new DataAccessor();
				$query = "SELECT * FROM user_active_achievements INNER JOIN achievements ON user_active_achievements.achievement_id = achievements.achievement_id WHERE user_id = :user_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":user_id" => $user_id));
				return $stmt->fetchAll();
			}

			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}
		}


		public function getUnlockedAchievements(){
			try{
				$user_id = $_SESSION['user_id'];

				$DA = new DataAccessor();
				$query = "SELECT * FROM user_complete_achievements INNER JOIN achievements ON user_complete_achievements.achievement_id = achievements.achievement_id WHERE user_id = :user_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":user_id" => $user_id));
				return $stmt->fetchAll();
				
			}

			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}
		}

		public static function checkUsername($username){
			try{

				$DA = new DataAccessor();
				$query = "SELECT * FROM login WHERE username = :username";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":username" => $username));
				if($stmt->rowCount() > 0){
					echo "false";
				}
				else{
					echo "true";
				}
				
			}

			catch(PDOException $ex){
				echo $ex->getMessage();
				echo 'false';
			}
		}

		public static function completeTask($task_id){
			try{
				$DA = new DataAccessor();
				$DA->database->beginTransaction();
				
				$user_id = $_SESSION['user_id'];

				//insert into community habits
				$query = "UPDATE tasks SET is_complete = 1 WHERE task_id = :task_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":task_id" => $task_id));

				$query = "UPDATE users SET karma_points = karma_points + (SELECT karma_points FROM tasks WHERE task_id = :task_id) WHERE user_id = :user_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":task_id" => $task_id, ":user_id" => $user_id));
				$DA->database->commit();
				echo 'true';

			}
			catch(PDOException $ex){
				$DA->database->rollback();
				echo 'false';
			}
		}


		public static function completeDaily($daily_id){
			try{
				$DA = new DataAccessor();
				$DA->database->beginTransaction();
				
				$user_id = $_SESSION['user_id'];

				//insert into community habits
				$query = "DELETE FROM user_active_dailies WHERE user_id = :user_id AND daily_id = :daily_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":user_id" => $user_id, ":daily_id" => $daily_id));

				$query = "INSERT INTO user_complete_dailies VALUES (:user_id, :daily_id, NOW())";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":user_id" => $user_id, ":daily_id" => $daily_id));

				$query = "UPDATE users SET karma_points = karma_points + (SELECT karma_points FROM dailies WHERE daily_id = :daily_id) WHERE user_id = :user_id";
				$stmt = $DA->database->prepare($query);
				$result = $stmt->execute(array(":daily_id" => $daily_id, ":user_id" => $user_id));
				$DA->database->commit();
				echo 'true';

			}
			catch(PDOException $ex){
				$DA->database->rollback();
				echo 'false';
			}
		}

		public function getLeaderboard(){
			$query = "SELECT users.user_id, alias, karma_points as points, name, image_path FROM users LEFT JOIN user_complete_achievements ON users.user_id = user_complete_achievements.user_id LEFT JOIN achievements ON user_complete_achievements.achievement_id = achievements.achievement_id WHERE users.opt_out = 0 ORDER BY points DESC, name";
			$stmt = $this->database->prepare($query);
			$result = $stmt->execute();
			return $stmt->fetchAll();
		}

		public function checkOptOut(){
			$user_id = $_SESSION['user_id'];

			$query = "SELECT opt_out FROM users WHERE user_id = :user_id";
			$stmt = $this->database->prepare($query);
			$result = $stmt->execute(array(":user_id" => $user_id));
			$opt_out = $stmt->fetch()["opt_out"];

			if($opt_out === "0"){
				return "false";
			}
			else{
				return "true";
			}
		}

		public static function optOut(){
			$user_id = $_SESSION['user_id'];
			$DA = new DataAccessor();

			$query = "UPDATE users SET opt_out = 1 WHERE user_id = :user_id";
			$stmt = $DA->database->prepare($query);
			$result = $stmt->execute(array(":user_id" => $user_id));
			return true;
		}

		public static function optIn(){
			$user_id = $_SESSION['user_id'];
			$DA = new DataAccessor();

			$query = "UPDATE users SET opt_out = 0 WHERE user_id = :user_id";
			$stmt = $DA->database->prepare($query);
			$result = $stmt->execute(array(":user_id" => $user_id));
			return true;
		}
	}

?>