use mis;
DROP  PROCEDURE IF EXISTS `get_campana`;
DELIMITER ;;
CREATE  PROCEDURE `get_campana`(IN `v_dt_fecha` VARCHAR(36))
    MODIFIES SQL DATA
BEGIN

    DECLARE v_id VARCHAR(120);
    DECLARE v_campana VARCHAR(120);
    DECLARE v_call_date VARCHAR(120);

    SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

    DROP TEMPORARY TABLE IF EXISTS tmp_cursor_tbl_ventas ;
    SET @_QUERY:= CONCAT(
        "CREATE TEMPORARY TABLE tmp_cursor_tbl_ventas "
        , "SELECT id, servidor, call_date, campana, dialstatus, calls, id_user, id_request "
        , "FROM carrier_status "
        , "WHERE campana <> ''  AND call_date = '",v_dt_fecha,"'  GROUP BY campana; " ) ;

    PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
    SET @_ROW:= "";

    SELECT COUNT(*) INTO @_ROW FROM tmp_cursor_tbl_ventas;

    WHILE @_ROW > 0 DO

        SELECT id, campana, call_date INTO v_id, v_campana, v_call_date 
        FROM tmp_cursor_tbl_ventas LIMIT 1 ;

        SET @_QUERY:= CONCAT(" SELECT campana, SUM(calls) INTO @v_nombre_campana_calls , @v_total_calls
                                FROM carrier_status 
                                WHERE campana= '", v_campana, "' AND call_date= '", v_call_date, "' AND dialstatus= 'calls' " ) ;
        PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @_QUERY:= CONCAT(" SELECT campana, SUM(calls) INTO @v_nombre_campana_contactos, @v_total_contactos
                                FROM carrier_status 
                                WHERE campana= '", v_campana, "' AND call_date= '", v_call_date, "' AND dialstatus= 'contactos' " ) ;
        PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @_QUERY:= CONCAT(" SELECT campana, SUM(calls) INTO @v_nombre_campana_logros, @v_total_logros
                                FROM carrier_status 
                                WHERE campana= '", v_campana, "' AND call_date= '", v_call_date, "' AND dialstatus= 'logros' " ) ;
        PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @_QUERY:= CONCAT(" SELECT campana, SUM(calls) INTO @v_nombre_campana_logros, @v_total_logros_e
                                FROM carrier_status 
                                WHERE campana= '", v_campana, "' AND call_date= '", v_call_date, "' AND dialstatus= 'logros_e' " ) ;
        PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @_QUERY:= CONCAT(" SELECT campana, SUM(calls) INTO @v_nombre_campana_tiempo_de_conexion, @v_total_tiempo_de_conexion
                                FROM carrier_status 
                                WHERE campana= '", v_campana, "' AND call_date= '", v_call_date, "' AND dialstatus= 'tiempo_de_conexion' " ) ;
        PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @_QUERY:= CONCAT(" SELECT campana, SUM(calls) INTO @v_nombre_campana_buzon_c, @v_total_buzon_c
                                FROM carrier_status 
                                WHERE campana= '", v_campana, "' AND call_date= '", v_call_date, "' AND dialstatus= 'BuzonC' " ) ;

        SET @_QUERY:= CONCAT(" SELECT campana, SUM(calls) INTO @v_nombre_campana_buzon_a, @v_total_buzon_a
                                FROM carrier_status 
                                WHERE campana= '", v_campana, "' AND call_date= '", v_call_date, "' AND dialstatus= 'BuzonA' " ) ;

        PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

	INSERT INTO reporte_carrier_status (      id_user
                                                , vc_calls
                                                , vc_contactos_porcentaje
                                                , vc_contactos
                                                , vc_logros
                                                , vc_logrosE
                                                , vc_porcentaje_efectividad
                                                , vc_tiempo_de_conexion
                                                , vc_SPH
                                                , vc_Buzonez
                                                , vc_promedio_buzones
                                                , vc_campana
                                                , call_date
                                        )
	VALUES(   0
		, @v_total_calls
		, NULL
		, @v_total_contactos
		, @v_total_logros
		, @v_total_logros_e
		, NULL
		, @v_total_tiempo_de_conexion
		, NULL
		, @v_total_buzon_c
		, @v_total_buzon_a
                , v_campana
                , v_call_date
	);


        SET @_ROW:= @_ROW - 1;     

        DELETE FROM tmp_cursor_tbl_ventas WHERE id = v_id ;

    END WHILE;
END ;;

DELIMITER ;

-- truncate reporte_carrier_status;
CALL get_campana('2022-11-17' );
-- select * from reporte_carrier_status \G

-- CALL get_reporte_carrier_status( '2022-12-11' , '2022-12-11' , 0 )
