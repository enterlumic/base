CREATE PROCEDURE sp_delete_api_by_lumic(IN `v_id` BIGINT(20))
    MODIFIES SQL DATA
BEGIN

      UPDATE console_gt  SET b_status= 0
      WHERE id= v_id;
  END