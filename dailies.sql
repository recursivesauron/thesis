/*mysql daily habits procedure*/
DROP PROCEDURE IF EXISTS daily_refresh;

DELIMITER $$
CREATE PROCEDURE daily_refresh()
BEGIN
	DECLARE done int DEFAULT 0;
	DECLARE userId int;

	/*for each user, give 3 random dailies that aren't still in their completed list*/
	DECLARE user_cursor CURSOR FOR 
		SELECT user_id FROM users;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

	DELETE FROM user_complete_dailies WHERE DATE(completed) < DATE(DATE_SUB(NOW(), INTERVAL 3 DAY));
	DELETE FROM user_active_dailies WHERE daily_id >= 1;

	

	OPEN user_cursor;
	FETCH user_cursor INTO userId;
	
	set_dailies: LOOP
		IF done THEN
			LEAVE set_dailies;
		END IF;

		INSERT INTO user_active_dailies (SELECT DISTINCT userId, daily_id FROM dailies WHERE daily_id NOT IN (SELECT daily_id FROM user_complete_dailies WHERE user_id = userId) ORDER BY RAND() LIMIT 3);
		
		FETCH user_cursor INTO userId;
	END LOOP set_dailies;
	CLOSE user_cursor;

END $$
DELIMITER ;

DROP EVENT IF EXISTS daily_refresh_event
CREATE EVENT daily_refresh_event
    ON SCHEDULE
      EVERY 1 MINUTE
    COMMENT 'Calls daily refresh'
    DO
      CALL daily_refresh();