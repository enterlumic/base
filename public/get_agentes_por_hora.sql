use mis

DROP PROCEDURE IF EXISTS get_agentes_por_hora;
DELIMITER ;;

CREATE PROCEDURE IF NOT EXISTS `get_agentes_por_hora`(IN `v_date` VARCHAR(20))
    MODIFIES SQL DATA
BEGIN

    DECLARE v_b_existente TINYINT(1) ;
    SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

    SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @B_EXISTS from reporte_agentes_por_hora WHERE fecha= '", v_date , "' ");
        PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

    IF (@B_EXISTS = 0) THEN BEGIN

       SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server1_9 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.251' AND i_hora = 9 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server1_10 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.251' AND i_hora = 10 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server1_11 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.251' AND i_hora = 11 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server1_12 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.251' AND i_hora = 12 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server1_13 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.251' AND i_hora = 13 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server1_14 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.251' AND i_hora = 14 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server1_15 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.251' AND i_hora = 15 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server1_16 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.251' AND i_hora = 16 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server1_17 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.251' AND i_hora = 17 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server1_18 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.251' AND i_hora = 18 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server1_19 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.251' AND i_hora = 19 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server1_20 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.251' AND i_hora = 20 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server1_21 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.251' AND i_hora = 21 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server2_8 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.236' AND i_hora = 8 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server2_9 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.236' AND i_hora = 9 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server2_10 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.236' AND i_hora = 10 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server2_11 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.236' AND i_hora = 11 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server2_12 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.236' AND i_hora = 12 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server2_13 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.236' AND i_hora = 13 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server2_14 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.236' AND i_hora = 14 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server2_15 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.236' AND i_hora = 15 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server2_16 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.236' AND i_hora = 16 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server2_17 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.236' AND i_hora = 17 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server2_18 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.236' AND i_hora = 18 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server2_19 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.236' AND i_hora = 19 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server2_20 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.236' AND i_hora = 20 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server2_21 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.236' AND i_hora = 21 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server3_8 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 8 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server3_9 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 9 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server3_10 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 10 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server3_11 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 11 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server3_12 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 12 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server3_13 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 13 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server3_14 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 14 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server3_15 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 15 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server3_16 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 16 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server3_17 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 17 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server3_18 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 18 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server3_19 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 19 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server3_20 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 20 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server3_21 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 21 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home1_8 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 8 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home1_9 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 9 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home1_10 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 10 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home1_11 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 11 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home1_12 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 12 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home1_13 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 13 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home1_14 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 14 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home1_15 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 15 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home1_16 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 16 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home1_17 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 17 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home1_18 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 18 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home1_19 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 19 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home1_20 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 20 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home1_21 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 21 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice1_8 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 8 AND vc_usuario NOT IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice1_9 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 9 AND vc_usuario NOT IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice1_10 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 10 AND vc_usuario NOT IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice1_11 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 11 AND vc_usuario NOT IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice1_12 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 12 AND vc_usuario NOT IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice1_13 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 13 AND vc_usuario NOT IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice1_14 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 14 AND vc_usuario NOT IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice1_15 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 15 AND vc_usuario NOT IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice1_16 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 16 AND vc_usuario NOT IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice1_17 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 17 AND vc_usuario NOT IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice1_18 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 18 AND vc_usuario NOT IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice1_19 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 19 AND vc_usuario NOT IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice1_20 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 20 AND vc_usuario NOT IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice1_21 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.72' AND i_hora = 21 AND vc_usuario NOT IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server4_8 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 8 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server4_9 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 9 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server4_10 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 10 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server4_11 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 11 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server4_12 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 12 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server4_13 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 13 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server4_14 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 14 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server4_15 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 15 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server4_16 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 16 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server4_17 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 17 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server4_18 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 18 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server4_19 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 19 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server4_20 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 20 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server4_21 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 21 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home2_8 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 8 AND vc_usuario IN (24809, 19270, 20358, 31136) and vc_usuario REGEXP '^[0-9]+$'");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home2_9 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 9 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home2_10 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 10 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home2_11 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 11 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home2_12 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 12 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home2_13 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 13 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home2_14 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 14 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home2_15 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 15 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home2_16 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 16 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home2_17 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 17 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home2_18 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 18 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home2_19 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 19 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home2_20 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 20 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @home2_21 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 21 AND vc_usuario IN (24809, 19270, 20358, 31136)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice2_8 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 8 AND vc_usuario NOT IN (24809, 19270, 20358)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice2_9 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 9 AND vc_usuario NOT IN (24809, 19270, 20358)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice2_10 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 10 AND vc_usuario NOT IN (24809, 19270, 20358)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice2_11 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 11 AND vc_usuario NOT IN (24809, 19270, 20358)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice2_12 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 12 AND vc_usuario NOT IN (24809, 19270, 20358)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice2_13 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 13 AND vc_usuario NOT IN (24809, 19270, 20358)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice2_14 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 14 AND vc_usuario NOT IN (24809, 19270, 20358)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice2_15 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 15 AND vc_usuario NOT IN (24809, 19270, 20358)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice2_16 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 16 AND vc_usuario NOT IN (24809, 19270, 20358)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice2_17 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 17 AND vc_usuario NOT IN (24809, 19270, 20358)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice2_18 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 18 AND vc_usuario NOT IN (24809, 19270, 20358)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice2_19 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 19 AND vc_usuario NOT IN (24809, 19270, 20358)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice2_20 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 20 AND vc_usuario NOT IN (24809, 19270, 20358)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @ofice2_21 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.238' AND i_hora = 21 AND vc_usuario NOT IN (24809, 19270, 20358)");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server5_8 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.239' AND i_hora = 8 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server5_9 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.239' AND i_hora = 9 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server5_10 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.239' AND i_hora = 10 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server5_11 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.239' AND i_hora = 11 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server5_12 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.239' AND i_hora = 12 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server5_13 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.239' AND i_hora = 13 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server5_14 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.239' AND i_hora = 14 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server5_15 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.239' AND i_hora = 15 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server5_16 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.239' AND i_hora = 16 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server5_17 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.239' AND i_hora = 17 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server5_18 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.239' AND i_hora = 18 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server5_19 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.239' AND i_hora = 19 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server5_20 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.239' AND i_hora = 20 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server5_21 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.239' AND i_hora = 21 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server6_8 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.240' AND i_hora = 8 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server6_9 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.240' AND i_hora = 9 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server6_10 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.240' AND i_hora = 10 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server6_11 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.240' AND i_hora = 11 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server6_12 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.240' AND i_hora = 12 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server6_13 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.240' AND i_hora = 13 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server6_14 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.240' AND i_hora = 14 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server6_15 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.240' AND i_hora = 15 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server6_16 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.240' AND i_hora = 16 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server6_17 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.240' AND i_hora = 17 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server6_18 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.240' AND i_hora = 18 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server6_19 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.240' AND i_hora = 19 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server6_20 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.240' AND i_hora = 20 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_server6_21 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.240' AND i_hora = 21 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_nube1_8 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.100' AND i_hora = 8 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_nube1_9 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.100' AND i_hora = 9 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_nube1_10 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.100' AND i_hora = 10 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_nube1_11 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.100' AND i_hora = 11 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_nube1_12 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.100' AND i_hora = 12 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_nube1_13 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.100' AND i_hora = 13 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_nube1_14 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.100' AND i_hora = 14 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_nube1_15 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.100' AND i_hora = 15 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_nube1_16 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.100' AND i_hora = 16 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_nube1_17 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.100' AND i_hora = 17 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_nube1_18 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.100' AND i_hora = 18 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_nube1_19 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.100' AND i_hora = 19 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_nube1_20 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.100' AND i_hora = 20 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
        SET @_QUERY:= CONCAT(" SELECT COUNT(*) INTO @hrs_nube1_21 from agentes_por_hora WHERE dt_fecha= '", v_date , "' AND vc_ip= '192.168.10.100' AND i_hora = 21 ");
            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        SET @TotalHO_8= @home1_8 + @home2_8 + @hrs_nube1_8;
        SET @TotalHO_9= @home1_9 + @home2_9 + @hrs_nube1_9;
        SET @TotalHO_10= @home1_10 + @home2_10 + @hrs_nube1_10;
        SET @TotalHO_11= @home1_11 + @home2_11 + @hrs_nube1_11;
        SET @TotalHO_12= @home1_12 + @home2_12 + @hrs_nube1_12;
        SET @TotalHO_13= @home1_13 + @home2_13 + @hrs_nube1_13;
        SET @TotalHO_14= @home1_14 + @home2_14 + @hrs_nube1_14;
        SET @TotalHO_15= @home1_15 + @home2_15 + @hrs_nube1_15;
        SET @TotalHO_16= @home1_16 + @home2_16 + @hrs_nube1_16;
        SET @TotalHO_17= @home1_17 + @home2_17 + @hrs_nube1_17;
        SET @TotalHO_18= @home1_18 + @home2_18 + @hrs_nube1_18;
        SET @TotalHO_19= @home1_19 + @home2_19 + @hrs_nube1_19;
        SET @TotalHO_20= @home1_20 + @home2_20 + @hrs_nube1_20;
        SET @TotalHO_21= @home1_21 + @home2_21 + @hrs_nube1_21;

        SET @Office_8= @hrs_server2_8 + @ofice1_8 + @ofice2_8 + @hrs_server5_8 + @hrs_server6_8;
        SET @Office_9= @hrs_server2_9 + @ofice1_9 + @ofice2_9 + @hrs_server5_9 + @hrs_server6_9;
        SET @Office_10= @hrs_server2_10 + @ofice1_10 + @ofice2_10 + @hrs_server5_10 + @hrs_server6_10;
        SET @Office_11= @hrs_server2_11 + @ofice1_11 + @ofice2_11 + @hrs_server5_11 + @hrs_server6_11;
        SET @Office_12= @hrs_server2_12 + @ofice1_12 + @ofice2_12 + @hrs_server5_12 + @hrs_server6_12;
        SET @Office_13= @hrs_server2_13 + @ofice1_13 + @ofice2_13 + @hrs_server5_13 + @hrs_server6_13;
        SET @Office_14= @hrs_server2_14 + @ofice1_14 + @ofice2_14 + @hrs_server5_14 + @hrs_server6_14;
        SET @Office_15= @hrs_server2_15 + @ofice1_15 + @ofice2_15 + @hrs_server5_15 + @hrs_server6_15;
        SET @Office_16= @hrs_server2_16 + @ofice1_16 + @ofice2_16 + @hrs_server5_16 + @hrs_server6_16;
        SET @Office_17= @hrs_server2_17 + @ofice1_17 + @ofice2_17 + @hrs_server5_17 + @hrs_server6_17;
        SET @Office_18= @hrs_server2_18 + @ofice1_18 + @ofice2_18 + @hrs_server5_18 + @hrs_server6_18;
        SET @Office_19= @hrs_server2_19 + @ofice1_19 + @ofice2_19 + @hrs_server5_19 + @hrs_server6_19;
        SET @Office_20= @hrs_server2_20 + @ofice1_20 + @ofice2_20 + @hrs_server5_20 + @hrs_server6_20;
        SET @Office_21= @hrs_server2_21 + @ofice1_21 + @ofice2_21 + @hrs_server5_21 + @hrs_server6_21;

        INSERT INTO reporte_agentes_por_hora (total, hora_8, hora_9, hora_10, hora_11, hora_12 , hora_13, hora_14, hora_15, hora_16, hora_17, hora_18 , hora_19, hora_20, hora_21, fecha) VALUES
             ("Svr 1",@hrs_server1_8, @hrs_server1_9, @hrs_server1_10, @hrs_server1_11, @hrs_server1_12 , @hrs_server1_13, @hrs_server1_14, @hrs_server1_15, @hrs_server1_16, @hrs_server1_17, @hrs_server1_18, @hrs_server1_19, @hrs_server1_20, @hrs_server1_21, v_date)
            ,("Svr 2",@hrs_server2_8, @hrs_server2_9, @hrs_server2_10, @hrs_server2_11, @hrs_server2_12 , @hrs_server2_13, @hrs_server2_14, @hrs_server2_15, @hrs_server2_16, @hrs_server2_17, @hrs_server2_18, @hrs_server2_19, @hrs_server2_20, @hrs_server2_21, v_date)        
            ,("Svr 3",@hrs_server3_8, @hrs_server3_9, @hrs_server3_10, @hrs_server3_11, @hrs_server3_12 , @hrs_server3_13, @hrs_server3_14, @hrs_server3_15, @hrs_server3_16, @hrs_server3_17, @hrs_server3_18, @hrs_server3_19, @hrs_server3_20, @hrs_server3_21, v_date)
            ,("HO",@home1_8, @home1_9, @home1_10, @home1_11, @home1_12 , @home1_13, @home1_14, @home1_15, @home1_16, @home1_17, @home1_18, @home1_19, @home1_20, @home1_21, v_date)
            ,("O",@ofice1_8, @ofice1_9, @ofice1_10, @ofice1_11, @ofice1_12 , @ofice1_13, @ofice1_14, @ofice1_15, @ofice1_16, @ofice1_17, @ofice1_18, @ofice1_19, @ofice1_20, @ofice1_21, v_date)
            ,("Svr 4",@hrs_server4_8, @hrs_server4_9, @hrs_server4_10, @hrs_server4_11, @hrs_server4_12 , @hrs_server4_13, @hrs_server4_14, @hrs_server4_15, @hrs_server4_16, @hrs_server4_17, @hrs_server4_18, @hrs_server4_19, @hrs_server4_20, @hrs_server4_21, v_date)
            ,("HO",@home2_8, @home2_9, @home2_10, @home2_11, @home2_12 , @home2_13, @home2_14, @home2_15, @home2_16, @home2_17, @home2_18, @home2_19, @home2_20, @home2_21, v_date)
            ,("O",@ofice2_8, @ofice2_9, @ofice2_10, @ofice2_11, @ofice2_12 , @ofice2_13, @ofice2_14, @ofice2_15, @ofice2_16, @ofice2_17, @ofice2_18, @ofice2_19, @ofice2_20, @ofice2_21, v_date)
            ,("Svr 5",@hrs_server5_8, @hrs_server5_9, @hrs_server5_10, @hrs_server5_11, @hrs_server5_12 , @hrs_server5_13, @hrs_server5_14, @hrs_server5_15, @hrs_server5_16, @hrs_server5_17, @hrs_server5_18, @hrs_server5_19, @hrs_server5_20, @hrs_server5_21, v_date)
            ,("Svr 6",@hrs_server6_8, @hrs_server6_9, @hrs_server6_10, @hrs_server6_11, @hrs_server6_12 , @hrs_server6_13, @hrs_server6_14, @hrs_server6_15, @hrs_server6_16, @hrs_server6_17, @hrs_server6_18, @hrs_server6_19, @hrs_server6_20, @hrs_server6_21, v_date)
            ,("Nube 1",@hrs_nube1_8, @hrs_nube1_9, @hrs_nube1_10, @hrs_nube1_11, @hrs_nube1_12 , @hrs_nube1_13, @hrs_nube1_14, @hrs_nube1_15, @hrs_nube1_16, @hrs_nube1_17, @hrs_nube1_18, @hrs_nube1_19, @hrs_nube1_20, @hrs_nube1_21, v_date)
            ,("Total HO",@TotalHO_8, @TotalHO_9, @TotalHO_10, @TotalHO_11, @TotalHO_12 , @TotalHO_13, @TotalHO_14, @TotalHO_15, @TotalHO_16, @TotalHO_17, @TotalHO_18, @TotalHO_19, @TotalHO_20, @TotalHO_21, v_date)
            ,("Total O",@Office_8, @Office_9, @Office_10, @Office_11, @Office_12 , @Office_13, @Office_14, @Office_15, @Office_16, @Office_17, @Office_18, @Office_19, @Office_20, @Office_21, v_date);



    END; END IF;

 
END ;;
DELIMITER ;


TRUNCATE reporte_agentes_por_hora;
CALL get_agentes_por_hora("2022-11-16" );


SELECT * FROM reporte_agentes_por_hora;

