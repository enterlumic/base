CREATE  PROCEDURE `get_carrier_status`(IN `v_id_user` BIGINT(20), IN `v_id_request` VARCHAR(64))
    MODIFIES SQL DATA
BEGIN
    SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;
    CALL get_campana( v_id_user, v_id_request );
END ;;
