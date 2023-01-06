CREATE  PROCEDURE `get_asistencias`()
    MODIFIES SQL DATA
  BEGIN

    SET @v_day:= DAY(CURDATE());
    SET @v_year:= YEAR(CURDATE());
    SET @v_month:= MONTH(CURDATE());

    DROP TEMPORARY TABLE IF EXISTS tmp_asistencias ;
    SET @_QUERY:= CONCAT(
        "CREATE TEMPORARY TABLE tmp_asistencias "
        , "SELECT id, user, user_group, COUNT(user) AS total_asistencia "
        , "FROM metricas_conexiones "
        , "WHERE YEAR(fecha)= '", @v_year, "' AND MONTH(fecha)= '", @v_month, "' GROUP BY user;  " ) ;       

    PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

    SET @_ROW:= "";

    SELECT COUNT(*) INTO @_ROW FROM tmp_asistencias;

    DROP TABLE IF EXISTS new_tbl;
    CREATE TABLE IF NOT EXISTS new_tbl (
      id VARCHAR(200),
      nombre VARCHAR(200),
      user_group VARCHAR(200),
      asistencia_abr VARCHAR(3),
      faltas VARCHAR(200),
      asistencias VARCHAR(200)
    );

    TRUNCATE new_tbl;

    WHILE @_ROW > 0 DO 

        SELECT id, user, total_asistencia INTO @id, @user, @total_asistencia FROM tmp_asistencias LIMIT 1 ;

        SET @id_user:= 0;
        SELECT user INTO @id_user FROM metricas_conexiones 
        WHERE YEAR(fecha)=  @v_year 
        AND MONTH(fecha)= @v_month 
        AND DAY(fecha)= @v_day -1
        AND user = @user 
        ;

        IF ( @id_user = 0) THEN BEGIN

            INSERT INTO new_tbl (id, nombre, user_group, asistencia_abr, faltas, asistencias)
            SELECT user AS id, Gestor AS nombre, user_group, 'F', (DAY(CURDATE()) - 2) - @total_asistencia AS faltas, @total_asistencia AS asistencias FROM metricas_conexiones 
            LEFT OUTER JOIN turnos ON IdTrab = user
            WHERE YEAR(fecha)=  @v_year 
            AND MONTH(fecha)= @v_month 
            AND user = @user 
            AND user_group NOT IN ('POSPAGO', 'CON', 'TEAML') 
            GROUP BY user;

        END; END IF;

        DELETE FROM tmp_asistencias WHERE user = @user ;
        SET @_ROW:= @_ROW - 1;     
   
    END WHILE;

    SELECT * FROM new_tbl;

END ;;
