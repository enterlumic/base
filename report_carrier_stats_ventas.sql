
-- =============================================
-- Author:		Edson Gomez Zavala
-- Create date: 01/11/2018 02:00:00 p.m.
-- Se elimino MSR y Foraneo se cargara en otro SP --17/01/2020
-- =============================================

ALTER PROCEDURE [dbo].[report_carrier_stats_ventas](
	@fecha_inicial date,
	@fecha_final date
)


AS
BEGIN
 SET NOCOUNT ON

	-- Llamdas
	/*SELECT 
	svr as [Servidor],call_date,Campana,'Calls' as dialstatus,Calls
	FROM carrier_stats_ventas
	WHERE call_date between @fecha_inicial and @fecha_final and campana in('MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS')--'MSR','EXCELFOR','FORANEO' y MSR, se removio foranoe por orden de tomas
	group by svr,call_date,Campana,Calls
	*/
	
	select 
	servidororigen as [servidor],
	CAST(call_date AS DATE) as call_date,
	campaign_id as Campana,
	'Calls' as dialstatus,
	count(1) as calls
	from [Vici_Logs].[dbo].vicidial_log where

	CAST(call_date AS DATE) between @fecha_inicial and @fecha_final and
	campaign_id in('MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS')

	group by CAST(call_date AS DATE),campaign_id,ServidorOrigen




	UNION
	--Contactos
	/*SELECT 
	svr as [Servidor],call_date,Campana,'Contactos' as dialstatus,Mayores
	FROM carrier_stats_ventas
	WHERE call_date between @fecha_inicial and @fecha_final and campana in('MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS')--'MSR','EXCELFOR','FORANEO', se removio foranoe por orden de tomas
	group by svr,call_date,Campana,Mayores
	*/
	select 
	servidororigen as [servidor],
	CAST(call_date AS DATE) as call_date,
	campaign_id as Campana,
	'CONTACTOS' as dialstatus,
	count(case when length_in_sec >60 then 1 else null end) AS 'CALLS'

	from [Vici_Logs].DBO.vicidial_log where
	CAST(call_date AS DATE) between @fecha_inicial and @fecha_final and
	campaign_id in('MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS')

	group by CAST(call_date AS DATE),campaign_id,ServidorOrigen


	UNION
	-- Tiempo de Conexion
	SELECT
	ServidorOrigen as [Servidor],event_date as call_date,campaign_id as Campana,'Tiempo de Conexion' as dialstatus,((sum(agenttime_sec)/60.0)/60) as op_time
	FROM ReporteProductividadSecondsView
	WHERE event_date between @fecha_inicial and @fecha_final and ServidorOrigen in ('VICIDIAL2','VICIDIAL3','VICIDIAL7','VICIDIAL4') and campaign_id in(
	'MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS')--'MSR','EXCELFOR', se removio foranoe por orden de tomas
	group by ServidorOrigen,event_date,campaign_id


	UNION
	-- Tiempo de efectivo
	SELECT
	ServidorOrigen as [Servidor],event_date as call_date,campaign_id as Campana,'Tiempo efectivo' as dialstatus,((sum(efectivetime_sec)/60.0)/60) as op_time
	FROM ReporteProductividadSecondsView
	WHERE event_date between @fecha_inicial and @fecha_final and ServidorOrigen in ('VICIDIAL2','VICIDIAL3','VICIDIAL7','VICIDIAL4') and campaign_id in(
	'MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS')--'MSR','EXCELFOR', se removio foranoe por orden de tomas
	group by ServidorOrigen,event_date,campaign_id



	UNION
	-- Logros
	Select
	'VICIDIAL' as [Servidor],cast(v.[Fecha_Registro] as date) as call_date,ca.campana as Campana
	,'LOGROS' as dialstatus,count(1) as Calls
	from [CRM2].[Planes_Ventas].[dbo].[cuentas] v with (nolock)
	join [CRM2].[Planes_Ventas].[dbo].[Usuarios] u with (nolock) on u.IdUsuario = v.IdUsuario_Venta
	join [CRM2].[Planes_Ventas].[dbo].[carga] c with (nolock) on c.idcarga = v.idcarga
	join [CRM2].[Planes_Ventas].[dbo].[campana] ca with (nolock) on ca.idcampana = c.idcampana
	where CAST(v.[Fecha_Registro] as date) between @fecha_inicial and @fecha_final
	and v.IdTipo_Registro = 1
	and (u.[No_Emp] is not null or u.[No_Emp] not like '%[a-z]%')
	and v.IdTipo_Registro = 1
	and ca.idcampana not in('3','6','7')--6 y 7'FORANEO', MSR 3 se removio foranoe por orden de tomas
	group by  cast(v.[Fecha_Registro] as date),ca.campana
	
	UNION
	-- Logros Efectivos
	SELECT
	'VICIDIAL' AS [Servidor],CAST(v.[Fecha_Registro] AS DATE) AS call_date,ca.campana AS Campana
	,'LOGROS E' AS dialstatus,COUNT(1) AS Calls
	FROM [CRM2].[Planes_Ventas].[dbo].[cuentas] v WITH (NOLOCK)
	JOIN [CRM2].[Planes_Ventas].[dbo].[Usuarios] u WITH (NOLOCK) ON u.IdUsuario = v.IdUsuario_Venta
	JOIN [CRM2].[Planes_Ventas].[dbo].[carga] c WITH (NOLOCK) ON c.idcarga = v.idcarga
	JOIN [CRM2].[Planes_Ventas].[dbo].[campana] ca WITH (NOLOCK) ON ca.idcampana = c.idcampana
	where CAST(v.[Fecha_Registro] as date) BETWEEN @fecha_inicial AND @fecha_final
	AND v.IdTipo_Registro = 1
	AND (u.[No_Emp] IS NOT NULL OR u.[No_Emp] NOT LIKE '%[a-z]%')
	AND v.IdEstatus IN( '6','9','10','14','18','19','20','21','22','23','24','25','29','30','31','16','27','32')
	and ca.idcampana not in('3','6','7')--'FORANEO', MSR 3 se removio foranoe por orden de tomas
	GROUP BY  CAST(v.[Fecha_Registro] AS DATE),ca.campana
	
	UNION
	-- Cuenta de buzones(totales)
	/*Select
	svr as [Servidor],call_date,Campana,'BuzonC' as dialstatus,Buzon
	from carrier_stats_ventas_buzones
	WHERE call_date between @fecha_inicial and @fecha_final and campana in('MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS')--,'MSR','EXCELFOR','FORANEO', se romovio foraneo por orden de tomas
	group by svr,call_date,Campana, Buzon
	*/
	SELECT 
	servidororigen as [servidor],
	CAST(call_date AS DATE),
	campaign_id as Campana,
	'BuzonC' as dialstatus,
	COUNT(STATUS) AS Buzon

	FROM [Vici_Logs].dbo.vicidial_log WHERE 

	campaign_id in(
	'MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS') and
	CAST(call_date AS DATE) between @fecha_inicial and @fecha_final
	and [status] ='Z6b'
	and vicidial_log.length_in_sec >=0
	GROUP BY CAST(call_date AS DATE),campaign_id,ServidorOrigen




	UNION
	-- Buzone average
	/*Select
	svr as [Servidor],call_date,Campana,'BuzonA' as dialstatus,Average
	from carrier_stats_ventas_buzones
	WHERE call_date between @fecha_inicial and @fecha_final and campana in('MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS')--,'MSR','EXCELFOR','FORANEO', se romovio foraneo por orden de tomas
	group by svr,call_date,Campana, Average
	*/

	SELECT 
	servidororigen as [servidor],
	CAST(call_date AS DATE),
	campaign_id as Campana,
	'BuzonA' as dialstatus,
	AVG(length_in_sec) AS Average 

	FROM [Vici_Logs].dbo.vicidial_log WHERE 
	campaign_id in(
	'MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS') and
	CAST(call_date AS DATE) between @fecha_inicial and @fecha_final
	and [status] ='Z6b'
	and vicidial_log.length_in_sec >=0
	GROUP BY CAST(call_date AS DATE),campaign_id,ServidorOrigen


	UNION
	--Agentes logueados
	select 
	'VICIDIAL' as [servidor],event_date as call_date,'contratos' as campana,'Agentes' as dialstatus, count(DISTINCT(USER_ID)) as Calls
	from ReporteProductividadSecondsView where 
	campaign_id in('MVTPPRE','ESTPREDI','EXCELVOZ','EXCVOZPR','EXDATAUT','ESTRENA','MVTPOS')and 
	event_date between @fecha_inicial and @fecha_final
	group by event_date


	print 'Reporte Carrier Stats, Se obtienen ' + CAST(@@rowcount AS varchar(5)) + ' filas, entre el ' + cast(@fecha_inicial as varchar(10)) + ' y el ' + cast(@fecha_final as varchar(10));

 SET NOCOUNT OFF
END