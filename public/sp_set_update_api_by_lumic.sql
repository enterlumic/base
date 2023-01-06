CREATE PROCEDURE sp_set_update_api_by_lumic(IN `v_id` BIGINT(20)
  , IN `v_vc_name` LONGTEXT
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
BEGIN

  DECLARE v_b_exists_command INTEGER(1) ;

  SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

  UPDATE console_gt 
  SET vc_name   = IF( v_vc_name <> '', v_vc_name, vc_name)
  WHERE id= v_id ;


  SET v_i_response := LAST_INSERT_ID();

END