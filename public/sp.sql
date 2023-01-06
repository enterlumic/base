CREATE  PROCEDURE `get_reporte`( vc_string_filtro varchar(100)
                                ,dt_fecha_ini varchar(19)
                                ,dt_fecha_fin varchar(19)
                                ,id_status_interaccion varchar(100)
                              )
BEGIN

    SET @_QUERY:=CONCAT("SELECT `clientes`.`id`,
                                   `vc_cliente`,
                                   `vc_correo`,
                                   `vc_telefono`,
                                   `vc_medio_contacto`,
                                   `vc_red_social`,
                                   `vc_tipificacion`,
                                   `id_subtipificacion`,
                                   `guia_o_id_envio`,
                                   `id_carrier`,
                                   `id_tipo_envio`,
                                   `vc_path_upload`,
                                   `vc_comentarios`,
                                   `vc_status`,
                                   `clientes`.`created_at`,
                                   `name`
                            FROM   `clientes`
                                   LEFT JOIN `cat_medio_contacto` ON `cat_medio_contacto`.`id` = `id_medio_contacto`
                                   LEFT JOIN `cat_red_social` ON `cat_red_social`.`id` = `id_red_social`
                                   LEFT JOIN `cat_tipificacion` ON `cat_tipificacion`.`id` = `id_tipificacion`
                                   LEFT JOIN `cat_status_interaccion` ON `cat_status_interaccion`.`id` = `id_status_interaccion`
                                   LEFT JOIN `users` ON `users`.`id` = id_user
                            WHERE  `clientes`.`b_status` = 1");

    IF (vc_string_filtro <> '') THEN BEGIN

        SET @_QUERY:=CONCAT(@_QUERY, " AND (vc_cliente LIKE '%%%",TRIM(vc_string_filtro),"%%%'");
        SET @_QUERY:=CONCAT(@_QUERY, " OR  vc_correo LIKE '%%%",TRIM(vc_string_filtro),"%%%'");
        SET @_QUERY:=CONCAT(@_QUERY, " OR  vc_telefono LIKE '%%%",TRIM(vc_string_filtro),"%%%')");

    END; END IF;

    IF (dt_fecha_ini <> '' AND dt_fecha_fin <> '') THEN BEGIN
        SET @_QUERY:=CONCAT(@_QUERY, " AND clientes.created_at BETWEEN '",dt_fecha_ini," 00:00:00' AND '",dt_fecha_fin," 23:59:59' ");
    END; END IF;

    IF (dt_fecha_ini = '' AND dt_fecha_fin = '') THEN BEGIN
        SET @_QUERY:=CONCAT(@_QUERY, " AND clientes.created_at BETWEEN '", DATE_FORMAT(DATE(NOW() - INTERVAL 7 DAY), "%Y-%m-%d") ," 00:00:00' AND '", now(),"' ");
    END; END IF;

    IF (id_status_interaccion > 0 ) THEN BEGIN
        SET @_QUERY:=CONCAT(@_QUERY, " AND `id_status_interaccion`= ", id_status_interaccion);
    END; END IF;

    SET @_QUERY:=CONCAT(@_QUERY, " ORDER BY created_at DESC LIMIT 0, 46108");

    PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
END ;;
