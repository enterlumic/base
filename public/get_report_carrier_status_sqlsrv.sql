CREATE PROCEDURE get_report_carrier_status_sqlsrv( @fecha_inicial date, @fecha_final date )
AS
BEGIN
 SET NOCOUNT ON

    -- Cuenta de buzones(totales)
    SELECT 
    servidororigen as [servidor],
    CAST(call_date AS DATE),
    campaign_id as Campana,
    'BuzonC' as dialstatus,
    COUNT(STATUS) AS Buzon

    FROM DWH.[Vici_Logs].[dbo].vicidial_log 
    WHERE campaign_id in(
    'MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS') and
    CAST(call_date AS DATE) between @fecha_inicial and @fecha_final
    and [status] ='Z6b'
    and vicidial_log.length_in_sec >=0
    GROUP BY CAST(call_date AS DATE),campaign_id,ServidorOrigen

    UNION

    SELECT 
    servidororigen as [servidor],
    CAST(call_date AS DATE),
    campaign_id as Campana,
    'BuzonA' as dialstatus,
    AVG(length_in_sec) AS Average 

    FROM DWH.[Vici_Logs].[dbo].vicidial_log  WHERE 
    campaign_id in(
    'MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS') and
    CAST(call_date AS DATE) between @fecha_inicial and @fecha_final
    and [status] ='Z6b'
    and vicidial_log.length_in_sec >=0
    GROUP BY CAST(call_date AS DATE),campaign_id,ServidorOrigen

    UNION

    -- Llamadas
    SELECT 
    ServidorOrigen as servidor,
    CAST(call_date AS DATE) as call_date,
    campaign_id as campana,
    'calls' as dialstatus, 
    count(*) as calls
    from DWH.[Vici_Logs].[dbo].vicidial_log 
    where call_date between @fecha_inicial and @fecha_final
    and campaign_id in('MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS')
    group by CAST(call_date AS DATE),campaign_id,ServidorOrigen

    UNION

    --Contactos
    SELECT 
    servidororigen as servidor,
    CAST(call_date AS DATE) as call_date,
    campaign_id as campana,
    'contactos' as dialstatus,
    count(case when length_in_sec >60 then 1 else null end) AS 'calls'
    from DWH.[Vici_Logs].[dbo].vicidial_log 
    where CAST(call_date AS DATE) between @fecha_inicial and @fecha_final
    and campaign_id in('MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS')
    group by CAST(call_date AS DATE),campaign_id,ServidorOrigen

    UNION

    -- -- Tiempo de Conexion
    SELECT
    ServidorOrigen as [servidor]
    ,event_date as call_date
    ,campaign_id as campana
    ,'Tiempo de Conexion' as dialstatus
    ,((sum(agenttime_sec)/60.0)/60) as op_time
    FROM ReporteProductividadSecondsView
    WHERE event_date between @fecha_inicial and @fecha_final and ServidorOrigen in ('VICIDIAL2','VICIDIAL3','VICIDIAL7','VICIDIAL4') and campaign_id in(
    'MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS')--'MSR','EXCELFOR', se removio foranoe por orden de tomas
    group by ServidorOrigen,event_date,campaign_id

    UNION

    -- Tiempo de efectivo
    SELECT
    ServidorOrigen as servidor
    ,event_date as call_date
    ,campaign_id as campana
    ,'Tiempo efectivo' as dialstatus
    ,((sum(efectivetime_sec)/60.0)/60) as op_time
    FROM ReporteProductividadSecondsView
    WHERE event_date between @fecha_inicial and @fecha_final and ServidorOrigen in ('VICIDIAL2','VICIDIAL3','VICIDIAL7','VICIDIAL4') and campaign_id in(
    'MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS')--'MSR','EXCELFOR', se removio foranoe por orden de tomas
    group by ServidorOrigen,event_date,campaign_id

    UNION
    -- Logros
    SELECT
    'VICIDIAL' as [servidor]
    ,cast(v.[Fecha_Registro] as date) as call_date
    ,ca.campana as campana
    ,'logros' as dialstatus
    ,count(1) as calls
    from Planes_Ventas.dbo.[cuentas] v with (nolock)
    join Planes_Ventas.dbo.[Usuarios] u with (nolock) on u.IdUsuario = v.IdUsuario_Venta
    join Planes_Ventas.dbo.[carga] c with (nolock) on c.idcarga = v.idcarga
    join Planes_Ventas.dbo.[campana] ca with (nolock) on ca.idcampana = c.idcampana
    where CAST(v.[Fecha_Registro] as date) between @fecha_inicial and @fecha_final
    and v.IdTipo_Registro = 1
    and (u.[No_Emp] is not null or u.[No_Emp] not like '%[a-z]%')
    and v.IdTipo_Registro = 1
    and ca.idcampana not in('3','6','7')
    group by  cast(v.[Fecha_Registro] as date),ca.campana

    UNION

    -- Logros Efectivos
    SELECT
    'VICIDIAL' AS [servidor]
    ,CAST(v.[Fecha_Registro] AS DATE) AS call_date
    ,ca.campana AS campana 
    ,'logros_e' AS dialstatus
    ,COUNT(1) AS call
    FROM Planes_Ventas.dbo.[cuentas] v WITH (NOLOCK)
    JOIN Planes_Ventas.dbo.[Usuarios] u WITH (NOLOCK) ON u.IdUsuario = v.IdUsuario_Venta
    JOIN Planes_Ventas.dbo.[carga] c WITH (NOLOCK) ON c.idcarga = v.idcarga
    JOIN Planes_Ventas.dbo.[campana] ca WITH (NOLOCK) ON ca.idcampana = c.idcampana
    where CAST(v.[Fecha_Registro] as date) BETWEEN @fecha_inicial AND @fecha_final
    AND v.IdTipo_Registro = 1
    AND (u.[No_Emp] IS NOT NULL OR u.[No_Emp] NOT LIKE '%[a-z]%')
    AND v.IdEstatus IN( '6','9','10','14','18','19','20','21','22','23','24','25','29','30','31','16','27','32')
    AND ca.idcampana not in('3','6','7')
    GROUP BY  CAST(v.[Fecha_Registro] AS DATE),ca.campana

    UNION

    --Agentes logueados
    select 
    'VICIDIAL' as [servidor]
    ,event_date as call_date
    ,'contratos' as campana
    ,'Agentes' as dialstatus
    , count(DISTINCT(USER_ID)) as call

    from ReporteProductividadSecondsView where 
    campaign_id in('MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS')and 
    event_date between @fecha_inicial and @fecha_final
    group by event_date

    print 'Reporte Carrier Stats, Se obtienen ' + CAST(@@rowcount AS varchar(5)) + ' filas, entre el ' + cast(@fecha_inicial as varchar(10)) + ' y el ' + cast(@fecha_final as varchar(10));

END


DWH.[Vici_Logs].[dbo].vicidial_log 

USE Vici_Logs;

select top 1 *
from DWH.[Vici_Logs].[dbo].TrabajadorSonarh 
where cast(event_time as date)='20221031'






