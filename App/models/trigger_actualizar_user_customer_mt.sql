delimiter //
CREATE TRIGGER trigger_actualizar_user_customer AFTER INSERT ON sms_campaign 
	FOR EACH ROW
	BEGIN
		SELECT DISTINCT customer_id into @customer_id FROM campaign_customer WHERE campaign_id = NEW.campaign_id;
		SELECT DISTINCT user_id into @user_id FROM campaign_user WHERE campaign_id = NEW.campaign_id;
		
		SELECT count(*) into @existe_user_control_mt FROM user_control_mt 
		WHERE user_id = @user_id 
		AND YEAR(create_time) = YEAR(NOW())
		AND MONTH(create_time) = MONTH(NOW());

		SELECT count(*) into @existe_customer_control_mt FROM customer_control_mt 
		WHERE customer_id = @customer_id
		AND YEAR(create_time) = YEAR(NOW())
		AND MONTH(create_time) = MONTH(NOW());

		IF(@existe_user_control_mt > 0) THEN
			UPDATE user_control_mt 
				SET update_time = now(), 
				count = count +1 
			WHERE user_id = @user_id
			AND YEAR(create_time) = YEAR(NOW())
			AND MONTH(create_time) = MONTH(NOW());
		ELSE
            INSERT INTO user_control_mt values(null, @user_id, now(), now(), 1);
		END IF;

		IF(@existe_customer_control_mt > 0) THEN
			UPDATE customer_control_mt 
				SET update_time = now(), 
				count = count +1 
			WHERE customer_id = @customer_id
			AND YEAR(create_time) = YEAR(NOW())
			AND MONTH(create_time) = MONTH(NOW());
		ELSE
			INSERT INTO customer_control_mt values(null, @customer_id, now(), now(), 1);
		END IF;

    end;
	//
delimiter ;