CREATE PROCEDURE `get_reporte_carrier_status`(   IN `v_dt_ini` VARCHAR(10)
                                        , IN `v_dt_fin` VARCHAR(10)
                                        , IN `v_rango` VARCHAR(1)
                                        )
    MODIFIES SQL DATA
BEGIN

    SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

    IF (v_rango = 0) THEN BEGIN
      SET @_QUERY:=CONCAT('SELECT 
            UPPER(vc_campana) AS campana
          , call_date AS "fecha"
          , vc_calls AS calls
          , (vc_contactos / vc_calls) * 100 AS "contactos"
          , vc_contactos  AS contactos
          , vc_logros AS logros
          , vc_logrosE AS "logros_e"
          , ROUND((vc_logros / vc_logrosE) * 100, 2) AS "efectividad"
          , vc_tiempo_de_conexion AS "tiempo_conexion"
          , (vc_logros / vc_tiempo_de_conexion) AS sph
          , vc_Buzonez as buzonez
          , vc_promedio_buzones AS "promedio_uzonez"
          FROM reporte_carrier_status');
    
    END; END IF;

    IF (v_rango = 1) THEN BEGIN
      SET @_QUERY:=CONCAT('SELECT 
            UPPER(vc_campana) AS campana
          , call_date AS "fecha"
          , vc_calls AS calls
          , (vc_contactos / vc_calls) * 100 AS "contactos"
          , vc_contactos  AS contactos
          , vc_logros AS logros
          , vc_logrosE AS "logros_e"
          , ROUND((vc_logros / vc_logrosE) * 100, 2) AS "efectividad"
          , vc_tiempo_de_conexion AS "tiempo_conexion"
          , (vc_logros / vc_tiempo_de_conexion) AS sph
          , vc_Buzonez as buzonez
          , vc_promedio_buzones AS "promedio_uzonez"
          FROM reporte_carrier_status');
    
    END; END IF;

    PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

END ;;
