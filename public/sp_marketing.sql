CREATE  PROCEDURE `get_reporte_marketing`( id_user bigint(20) )
BEGIN

    SET @i_cantidad_nacional:= 0;
    SET @i_cantidad_local:= 0;
    SET @ultima_fecha:= 0;
    SET @saldo:= 0;

    SELECT Creado INTO @ultima_fecha
    FROM envio
    INNER JOIN tipoenvio ON label LIKE "%Nacional%" AND tipoenvio.Activo = 1 AND IdTipoEnvio= Id
    WHERE IdCliente=v_id_cliente ORDER BY Creado DESC LIMIT 1;

    SELECT COUNT(*) INTO @i_cantidad_nacional
    FROM envio
    INNER JOIN tipoenvio ON label LIKE "%Nacional%" AND tipoenvio.Activo = 1 AND IdTipoEnvio= Id
    WHERE IdCliente=v_id_cliente AND Creado BETWEEN  CONCAT(DATE( @ultima_fecha - INTERVAL 7 DAY), ' 00:00:00') AND CONCAT(DATE_FORMAT(DATE(@ultima_fecha), "%Y-%m-%d"), ' 00:00:00') ;

    SELECT saldo, modificado INTO @saldo, @modificado FROM cuenta WHERE id_cliente= v_id_cliente;

    SELECT COUNT(*) INTO @i_cantidad_local
    FROM envio
    INNER JOIN tipoenvio ON label NOT LIKE "%Nacional%" AND tipoenvio.Activo = 1 AND IdTipoEnvio= Id
    WHERE IdCliente=v_id_cliente AND Creado BETWEEN  CONCAT(DATE( @ultima_fecha - INTERVAL 7 DAY), ' 00:00:00') AND CONCAT(DATE_FORMAT(DATE(@ultima_fecha), "%Y-%m-%d"), ' 00:00:00') ;

    SET @envio:= IF ( @i_cantidad_local > 0 , CONCAT('Realiza de 01 a ',@i_cantidad_local,' envios por semana locales') , '' ) ;
    SET @envio_nacional= IF ( @i_cantidad_nacional > 0 , CONCAT(' 01 a ',@i_cantidad_nacional,' nacionales') ,'');

    SET @envio:= IF ( @i_cantidad_nacional > 0 ,CONCAT(@envio, @envio_nacional) , @envio);

    SET @_QUERY:=CONCAT("SELECT CONCAT(name, ' ', apellido) AS nombre
                                    , email
                                    , contenido
                                    , '",@envio,"' AS realiza_envio
                                    , '",@modificado,"' AS fecha_acreditacion
                                    , created_at AS fecha_registro
                                    , ",@saldo," AS saldoAcreditacion
                                    , medio_de_contacto

                            FROM productos_sat_clientes
                            INNER JOIN users ON users.id= ",v_id_cliente,"
                            WHERE id_cliente= ", v_id_cliente);

    PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;
END ;;
