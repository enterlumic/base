CREATE  PROCEDURE `get_total_login`( IN `v_dt_ini` VARCHAR(20), IN `v_dt_fin` VARCHAR(20) )
    MODIFIES SQL DATA
BEGIN

    DECLARE v_variable_1 VARCHAR(120);
    DECLARE v_variable_2 VARCHAR(120);

    SET @_QUERY:= CONCAT(
        "   SELECT skynet.created_at, email, count(email) AS total
            FROM users
            INNER JOIN skynet ON users.id= id_user_o_id_cliente
            WHERE skynet.created_at >= '",v_dt_ini," 00:00:00'  AND skynet.created_at <= '",v_dt_fin," 23:59:00'
            AND vc_evento = 'login' GROUP BY DATE_FORMAT(skynet.created_at,'%Y-%m-%d'), email ORDER BY skynet.created_at DESC;" ) ;

    PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

END ;;
