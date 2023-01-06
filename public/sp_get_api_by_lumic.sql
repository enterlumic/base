CREATE  PROCEDURE sp_get_api_by_lumic(IN `v_i_start` INTEGER(5), IN `v_i_end` INTEGER(5))
    READS SQL DATA
    DETERMINISTIC
BEGIN

       SELECT id AS id
        , vc_name, created_at 
       FROM console_gt
       WHERE b_status > 0
       LIMIT v_i_start, v_i_end ;
          
    END