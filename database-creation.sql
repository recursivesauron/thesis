/* database creation file */

CREATE TABLE users(
	user_id			int 			NOT NULL	AUTO_INCREMENT,
	alias			varchar(30)		NOT NULL,
	opt_out			tinyint(1)		NOT NULL	DEFAULT 0,
	karma_points	int 			NOT NULL	DEFAULT 0,
	PRIMARY KEY (user_id)
) ENGINE=InnoDB;

CREATE TABLE community_habits(
	community_habit_id		int				NOT NULL	AUTO_INCREMENT,
	title			varchar(255)	NOT NULL,
	description		varchar(255)	NULL,
	karma_points 	int 			NOT NULL,
	PRIMARY KEY (community_habit_id)
) ENGINE=InnoDB;

CREATE TABLE user_habits(
	user_id			int 			NOT NULL,
	community_habit_id 	int 		NOT NULL,
	title			varchar(255)	NOT NULL,
	description		varchar(255)	NULL,
	karma_points 	int 			NOT NULL,
	PRIMARY KEY(user_id, community_habit_id),
	FOREIGN KEY(user_id) REFERENCES users(user_id),
	FOREIGN KEY(community_habit_id) REFERENCES community_habits(community_habit_id)
) ENGINE=InnoDB;

CREATE TABLE tasks(
	task_id			int 			NOT NULL 	AUTO_INCREMENT,
	user_id 		int 			NOT NULL,
	title 			varchar(255)	NOT NULL,
	description		varchar(255)	NULL,
	karma_points	int 			NOT NULL,
	is_complete		tinyint(1)		NOT NULL	DEFAULT 0,
	PRIMARY KEY(task_id),
	UNIQUE(title)
) ENGINE=InnoDB;

CREATE TABLE achievements(
	achievement_id	int 			NOT NULL 	AUTO_INCREMENT,
	name			varchar(255)	NOT NULL,
	description		varchar(255)	NOT NULL,
	type 			char(1)			NOT NULL,
	requirement 	int 			NOT NULL,
	image_path		varchar(255)	NOT NULL,
	PRIMARY KEY(achievement_id),
	UNIQUE(name)
) ENGINE=InnoDB;
/*Note: the char field holds either 'a' for automatic, or 'r' for request.*/

CREATE TABLE user_active_achievements(
	user_id 		int 			NOT NULL,
	achievement_id 	int 			NOT NULL,
	is_tracked 		tinyint(1) 		NOT NULL 	DEFAULT 0,
	PRIMARY KEY(user_id, achievement_id),
	FOREIGN KEY(user_id) REFERENCES users(user_id),
	FOREIGN KEY(achievement_id) REFERENCES achievements(achievement_id)
) ENGINE=InnoDB;

CREATE TABLE user_complete_achievements(
	user_id 		int 			NOT NULL,
	achievement_id 	int 			NOT NULL,
	time_completed 	datetime		NOT NULL,
	PRIMARY KEY(user_id, achievement_id),
	FOREIGN KEY(user_id) REFERENCES users(user_id),
	FOREIGN KEY(achievement_id) REFERENCES achievements(achievement_id)
) ENGINE=InnoDB;

CREATE TABLE dailies(
	daily_id 		int 			NOT NULL	AUTO_INCREMENT,
	title 			varchar(255)	NOT NULL,
	description 	varchar(255) 	NOT NULL,
	karma_points 	int 			NOT NULL,
	PRIMARY KEY(daily_id)
) ENGINE=InnoDB;

CREATE TABLE user_active_dailies(
	user_id 		int 			NOT NULL,
	daily_id 		int 			NOT NULL,
	PRIMARY KEY(user_id, daily_id),
	FOREIGN KEY(user_id) REFERENCES users(user_id),
	FOREIGN KEY(daily_id) REFERENCES dailies(daily_id)
) ENGINE=InnoDB;

CREATE TABLE user_complete_dailies(
	user_id 		int 			NOT NULL,
	daily_id 		int 			NOT NULL,
	completed 		datetime		NULL,
	PRIMARY KEY(user_id, daily_id),
	FOREIGN KEY(user_id) REFERENCES users(user_id),
	FOREIGN KEY(daily_id) REFERENCES dailies(daily_id)
) ENGINE=InnoDB;



/*******************insertion of sample data, as well as sample user***********************/


INSERT INTO habits VALUES(DEFAULT, "Recycle cans", NULL, 5);
INSERT INTO habits VALUES(DEFAULT, "Turn off monitors when not needed", NULL, 5);

INSERT INTO user_habits VALUES(1, 1);

INSERT INTO tasks VALUES(DEFAULT, 1, "Fill Database", "Remember to fill the database with sample information", 10, 0);


INSERT INTO achievements VALUES(DEFAULT, "Smitty Werbenjagermanjensen", "You are #1", "a", 0, 500, "./images/meat boy.jpg");
INSERT INTO achievements VALUES(DEFAULT, "Stage 1 Points", "Reached 500 Points!", "a", 500, 50, "./images/borderlands.jpg");
INSERT INTO achievements VALUES(DEFAULT, "Stage 2 Points", "Reached 1000 Points!", "a", 1000, 200, "./images/gwent.jpg");
INSERT INTO achievements VALUES(DEFAULT, "Stage 3 Points", "Reached 2500 Points!", "a", 2500, 500, "./images/meat boy.jpg");
INSERT INTO achievements VALUES(DEFAULT, "TEST ACHIEVEMENT", "TESTING STUFF", "r", 100, 400, "./images/rocket-league.jpg");

INSERT INTO achievements VALUES(DEFAULT, "Save the bees!", "Make a small habitat for bees to make a nest in.", "r", 0, 500, "./images/meat boy.jpg");
INSERT INTO achievements VALUES(DEFAULT, "This is my mason jar", "Reduce the waste you produce in a week so much so that you can fit it all in a mason jar", "r", 0, 500, "./images/borderlands.jpg");
INSERT INTO achievements VALUES(DEFAULT, "On top of the world", "Reach the top of the leaderboard", "a", 0, 300, "./images/gwent.jpg");


INSERT INTO user_active_achievements VALUES(1,1, 0,0);
INSERT INTO user_active_achievements VALUES(1,2,0,1);
INSERT INTO user_active_achievements VALUES(1,3, 0,1);
INSERT INTO user_active_achievements VALUES(1,4,0,1);
INSERT INTO user_active_achievements VALUES(1,5,0,0);

INSERT INTO dailies VALUES(DEFAULT, "Lone driver", "Carpool, take public transport, or walk to get around today", 75);
INSERT INTO dailies VALUES(DEFAULT, "One Bottle", "Reuse a bottle for the whole day, don't buy any liquids in a different bottle.", 50);
INSERT INTO dailies VALUES(DEFAULT, "Mind the Lights", "Turn off any lights you don't need to use today", 50);
INSERT INTO dailies VALUES(DEFAULT, "TEST 1", "DESC 1", 75);
INSERT INTO dailies VALUES(DEFAULT, "TEST 2", "DESC 2", 50);
INSERT INTO dailies VALUES(DEFAULT, "TEST 3", "DESC 3", 50);

INSERT INTO user_dailies VALUES(1,1, NULL);
INSERT INTO user_dailies VALUES(1,2,NULL);
INSERT INTO user_dailies VALUES(1,3,NULL);

INSERT INTO user_active_dailies VALUES(1,1);
INSERT INTO user_active_dailies VALUES(1,2);
INSERT INTO user_active_dailies VALUES(1,3);





DROP TABLE IF EXISTS user_dailies;
DROP TABLE IF EXISTS dailies;
DROP TABLE IF EXISTS user_active_achievements;
DROP TABLE IF EXISTS user_complete_achievements;
DROP TABLE IF EXISTS achievements;
DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS user_habits;
DROP TABLE IF EXISTS community_habits;
DROP TABLE IF EXISTS users;


