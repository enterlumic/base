CREATE PROCEDURE sp_undo_delete_api_by_lumic(IN `v_id` BIGINT(20), OUT `v_i_internal_status` INTEGER)
    MODIFIES SQL DATA
BEGIN

      UPDATE tbl_api  SET b_status= 1
      WHERE id= v_id;
      SET v_i_internal_status:= ROW_COUNT();
      
  END