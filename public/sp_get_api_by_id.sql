CREATE PROCEDURE `sp_get_api_by_id`(IN `v_id` BIGINT(20))
    READS SQL DATA
    DETERMINISTIC
BEGIN

       SELECT vc_name
       FROM console_gt
       WHERE id= v_id AND b_status > 0
       LIMIT 1 ;
          
END 