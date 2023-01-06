CREATE PROCEDURE get_control_a_ceros_full
  @FechaInicial DATE = '',
  @FechaFinal   DATE = ''
AS
BEGIN
  
  SET NOCOUNT ON;

    DECLARE @count_rango_fechas INT = 0,
      @sql_rango_fechas VARCHAR(8000),
      @rango_fechas   VARCHAR(8000),
      @rango_fechas_null  VARCHAR(8000),
      @query_table    VARCHAR(8000),
      @ScriptPivote   VARCHAR(8000),
      @ScriptPivoteU    VARCHAR(8000),
      @columnas_consulta  VARCHAR(8000),
      @ScriptConsulta   VARCHAR(8000)

  DECLARE @control_ceros_faltas TABLE (IdTrab     INT,
                     NombreCompleto VARCHAR(100),
                     Fecha      DATE,
                     Turno      INT,
                     entrada    VARCHAR(20),
                     salida     VARCHAR(20),
                     departamento VARCHAR(200),
                     puesto     VARCHAR(200),
                     etiqueta   VARCHAR(200),
                     descripcion  VARCHAR(200),
                     mentrada   TIME,
                     msalida    TIME,
                     idmovimiento INT)

  INSERT INTO @control_ceros_faltas EXEC get_control_a_ceros_faltas_fechas @FechaInicial, @FechaFinal

  SELECT IdTrab, ISNULL(CONVERT(VARCHAR(11), Fecha, 13), '') 'FechaTx' INTO #control_ceros_faltas_temp FROM @control_ceros_faltas

--Select * From #control_ceros_faltas_temp

  ;WITH RangoFechas(Fecha) AS 
  (
    SELECT @FechaInicial Date
    UNION ALL
    SELECT DATEADD(d,1,Fecha)
    FROM RangoFechas 
    WHERE Fecha < @FechaFinal
  )

  SELECT CONVERT(VARCHAR(11), Fecha, 13) 'Fecha'
    INTO #RangoFechasTemp
  FROM RangoFechas
  OPTION (MAXRECURSION 0)

--Select * From #RangoFechasTemp

  SELECT @count_rango_fechas =COUNT(*) FROM #RangoFechasTemp

--Select @count_rango_fechas '@count_rango_fechas'

  SELECT @sql_rango_fechas = STUFF((SELECT ', ' + '[' + Fecha + '] VARCHAR(11)' FROM #RangoFechasTemp ORDER BY Fecha ASC FOR XML PATH('')), 1, 1, '')

  SELECT @rango_fechas = STUFF((SELECT ', ' + '[' + Fecha + ']' FROM #RangoFechasTemp ORDER BY Fecha ASC FOR XML PATH('')), 1, 1, '')

  SELECT @rango_fechas_null = STUFF((SELECT ', ' + 'ISNULL([' + Fecha + '], 0) [' + Fecha + ']' FROM #RangoFechasTemp ORDER BY Fecha ASC FOR XML PATH('')), 1, 1, '')

  SELECT @columnas_consulta = 'DV.IdTrab, Gestor, Ingreso, Baja, Ant, Turno, Rol, descripcion, Departamento, '+
                + 'ISNULL(ventas_sum, 0) ''ventas_sum'', ISNULL(ventas_avg, 0) ''ventas_avg'', ISNULL(dias_en_cero, 0) ''dias_en_cero'', '
                + STUFF((SELECT ', ' + 'ISNULL([' + Fecha + '], ''0'') [' + Fecha + ']' FROM #RangoFechasTemp ORDER BY Fecha ASC FOR XML PATH('')), 1, 1, '')

--Select @rango_fechas '@rango_fechas'

  CREATE TABLE #detalle_ventas (IdTrab INT, Gestor VARCHAR(500), Ingreso DATE, Baja VARCHAR(50), Ant INT, Turno VARCHAR(10),
                Rol INT, descripcion VARCHAR(500), Departamento VARCHAR(500), ventas_sum INT, ventas_avg INT)

  CREATE TABLE #ventas_dias_cero (IdTrab INT, Ventas INT, FechaVentas VARCHAR(11))

  CREATE TABLE #ventas_final (IdTrab INT, Gestor VARCHAR(500), Ingreso DATE, Baja VARCHAR(50), Ant INT, Turno VARCHAR(10),
                Rol INT, descripcion VARCHAR(500), Departamento VARCHAR(500), ventas_sum INT, ventas_avg INT, dias_en_cero INT)

  SET @query_table = 'ALTER TABLE #detalle_ventas ADD ' + @sql_rango_fechas

  EXEC (@query_table)

  SET @query_table = 'ALTER TABLE #ventas_final ADD ' + @sql_rango_fechas

  EXEC (@query_table)

--Select * From #ventas_final

  SELECT t.idtrab AS IdTrab
      , t.paterno + ' ' + t.materno + ' ' + t.nombre AS Gestor
      , Cast(t.feingreso AS DATE) AS Ingreso
      , (CASE WHEN t.fbaja IS NULL THEN Cast('-' AS VARCHAR(3)) ELSE Cast(Year(t.fbaja) AS VARCHAR(4)) + '-' + RIGHT('0' + Cast(Month(t.fbaja) AS VARCHAR(2)),2) + '-' + RIGHT('0' + Cast(Day(t.fbaja) AS VARCHAR(2)),2) END) AS Baja
      , Datediff(d,feingreso
      , (CASE WHEN t.fbaja IS NULL THEN Getdate() ELSE t.fbaja END)) AS Ant
      , CASE WHEN rt.etiqueta IS NULL THEN '-'ELSE rt.etiqueta END AS Turno
      , CASE WHEN pt.rol IS NULL THEN '-'ELSE pt.rol END AS Rol
      , p.descripcion 'descripcion'
      , Replace(d.descripcion,'MUEVETE ','') AS Departamento
    INTO #control_ceros
  FROM SONARH.SonarhNet.dbo.trabajador T
    LEFT JOIN SONARH.SonarhNet.dbo.progturnos PT ON pt.rol = t.rol AND pt.vector = Datepart(dw,Getdate())
    LEFT JOIN SONARH.SonarhNet.dbo.depto D ON d.iddepto = t.iddepto
    LEFT JOIN SONARH.SonarhNet.dbo.puesto P ON p.idpuesto = t.idpuesto
    LEFT JOIN DWH.Logs.dbo.distro_crm C ON c.grupo = d.descripcion
    LEFT JOIN DWH.Logs.dbo.rol_turnos RT ON rt.rol = pt.rol
  WHERE p.descripcion LIKE 'rvt%'
    AND t.idtrab NOT IN('24947', '25590', '19210', '13364', '25721', '24829', '24434', '13149', '17613', '20623', '14438', '24426', '24434', '25735', '24067', '13485')
    AND (t.feingreso < @FechaFinal AND       t.fbaja IS NULL OR        (t.fbaja <@FechaFinal AND       t.fbaja >@FechaInicial) )
  ORDER BY  d.descripcion , t.paterno + ' ' + t.materno + ' ' + t.nombre

--Select * From #control_ceros

  SELECT  Cast(v.[fecha_registro] AS DATE) AS [Fecha],
      u.usuario AS IdTrab,
      Count(1) AS [Ventas]
    INTO #control_ceros_ventas
  FROM   [Planes_Ventas].[dbo].[cuentas] v WITH (nolock)
     JOIN [Planes_Ventas].[dbo].[usuarios] u WITH (nolock) ON u.idusuario = v.idusuario_venta and (ISNUMERIC(u.[no_emp]) = 1)
  WHERE (Cast(v.[fecha_registro] AS DATE) BETWEEN @FechaInicial AND @FechaFinal)
      AND v.idtipo_registro = 1
  GROUP  BY Cast(v.[fecha_registro] AS DATE), u.usuario
  ORDER BY Cast(v.[fecha_registro] AS DATE)

--Select * From #control_ceros_ventas

--Select IdTrab, Fecha, SUM(Ventas) 'ventaventas_sum' From #control_ceros_ventas GROUP BY IdTrab, Fecha ORDER BY IdTrab, Fecha

  SELECT  IdTrab,
      SUM(Ventas) 'ventas_sum',
      ROUND((CAST(SUM(Ventas) AS FLOAT) / @count_rango_fechas), 2) 'ventas_avg'
    INTO #sum_ventas_trab
  FROM #control_ceros_ventas
  GROUP BY IdTrab ORDER BY IdTrab

--Select * From #sum_ventas_trab

--Select * From #ventas_cero_trab

  SELECT  CC.*,
      ISNULL(CONVERT(VARCHAR(11), CCV.Fecha, 13), '') 'Fecha',
      ISNULL(CCV.Ventas, 0) 'Ventas'
    INTO #TempVentas
  FROM #control_ceros CC
    LEFT JOIN #control_ceros_ventas CCV ON CCV.IdTrab = CC.IdTrab

--Select * From #TempVentas

--Select  TV.IdTrab,
--      TV.Gestor,
--      TV.Ingreso,
--      TV.Baja,
--      TV.Ant,
--      TV.Turno,
--      TV.Rol,
--      TV.descripcion,
--      TV.Departamento,
--      VST.ventas_sum,
--      VST.ventas_avg,
--      TV.Fecha,
--      IIF(LEN(TV.Fecha) > 0 AND ISNULL(TV.Ventas, 0) > 0, ISNULL(TV.Fecha, ''), IIF(CCVT.IdTrab IS NOT NULL, CCVT.FechaTx, '')) 'FechaTx',
--      LEN(TV.Fecha) 'LFecha',
--      TV.Ventas 'NullVentas',
--      CCVT.IdTrab 'NullIdTrab',
--      IIF(LEN(TV.Fecha) > 0 AND ISNULL(TV.Ventas, 0) > 0, ISNULL(TV.Ventas, 0), IIF(CCVT.IdTrab IS NOT NULL, -1, 0)) 'Ventas'
--From #TempVentas TV
--  LEFT JOIN #sum_ventas_trab VST ON VST.IdTrab = TV.IdTrab
--  LEFT JOIN #control_ceros_faltas_temp CCVT ON CCVT.IdTrab = TV.IdTrab --AND CCVT.FechaTx = TV.Fecha

  SET @ScriptPivote = 'INSERT INTO #detalle_ventas '
            + 'SELECT * '
            + 'FROM (SELECT TV.IdTrab, '
            + '       TV.Gestor, '
            + '       TV.Ingreso, '
            + '       TV.Baja, '
            + '       TV.Ant, '
            + '       TV.Turno, '
            + '       TV.Rol, '
            + '       TV.descripcion, '
            + '       TV.Departamento, '
            + '       VST.ventas_sum, '
            + '       VST.ventas_avg, '
            + '       IIF(LEN(TV.Fecha) > 0 AND ISNULL(TV.Ventas, 0) > 0, ISNULL(TV.Fecha, ''''), IIF(CCVT.IdTrab IS NOT NULL, CCVT.FechaTx, '''')) ''Fecha'', '
            + '       IIF(LEN(TV.Fecha) > 0 AND ISNULL(TV.Ventas, 0) > 0, ISNULL(TV.Ventas, 0), IIF(CCVT.IdTrab IS NOT NULL, -1, 0)) ''Ventas'' '
            + '   FROM #TempVentas TV '
            + '     LEFT JOIN #sum_ventas_trab VST ON VST.IdTrab = TV.IdTrab '
            + '     LEFT JOIN #control_ceros_faltas_temp CCVT ON CCVT.IdTrab = TV.IdTrab '
            + ') STable '
            + 'PIVOT (MAX(Ventas) FOR Fecha IN ( ' + @rango_fechas + ')) PVTable'

--Select @ScriptPivote
  EXEC (@ScriptPivote)

--Select @columnas_consulta '@ScriptConsulta'

--Select * From #detalle_ventas

  SET @ScriptPivoteU = 'INSERT INTO #ventas_dias_cero '
             + 'SELECT * '
             + 'FROM (SELECT  DV.IdTrab, ' + @rango_fechas_null
             + '    FROM #detalle_ventas DV '
             + ') SCTable '
             + 'UNPIVOT (Ventas FOR Fecha IN (' + @rango_fechas + ')) UPVTable'

--Select @ScriptPivoteU
  EXEC (@ScriptPivoteU)

  SELECT  IdTrab,
      COUNT(Ventas) 'dias_en_cero'
    INTO #ventas_cero_trab
  FROM #ventas_dias_cero
  WHERE Ventas <= 0
  GROUP BY IdTrab

--Select * From #ventas_cero_trab

  SET @ScriptConsulta = 'SELECT ' + @columnas_consulta + ' FROM #detalle_ventas DV LEFT JOIN #ventas_cero_trab VCT ON VCT.IdTrab = DV.IdTrab '
  EXEC (@ScriptConsulta)

  DROP TABLE #control_ceros
  DROP TABLE #control_ceros_ventas
  DROP TABLE #RangoFechasTemp
  DROP TABLE #control_ceros_faltas_temp
  DROP TABLE #sum_ventas_trab
  DROP TABLE #ventas_cero_trab
  DROP TABLE #TempVentas
  DROP TABLE #ventas_dias_cero
  DROP TABLE #detalle_ventas
  DROP TABLE #ventas_final

END

