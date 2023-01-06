ALTER  PROCEDURE  get_metricas_y_conexiones_
	@FechaInicial DATE = '',
	@FechaFinal   DATE = ''
AS
BEGIN
	
	SET NOCOUNT ON;

	-- DECLARE @count INT;

	-- CREATE TABLE #tmp_detalle_por_dia(
	--     server_ip VARCHAR, 
	--     Fecha DATE,
	--     [user] INT,
	--     campaign_id VARCHAR,
	--     user_group VARCHAR,
	--     calls INT,
	--     agenttime INT,
	--     wait INT,
	--     talk INT,
	--     dispo INT,
	--     pausa INT,
	--     ba INT,
	--     brk INT,
	--     calling INT,
	-- );


	INSERT INTO #tmp_detalle_por_dia
    SELECT  server_ip,
			CAST(event_time AS DATE) 'Fecha',
			[user],
			campaign_id,
			user_group,
			SUM(IIF(lead_id IS NOT NULL, 1, 0)) 'calls',
			CAST(DATEADD(SECOND, (sum(wait_sec) + sum(talk_sec) +sum(dispo_sec) + sum(pause_sec)), '00:00:00') AS TIME(0)) 'AGENTTIME',
			CAST(DATEADD(SECOND, (sum(wait_sec)), '00:00:00') AS TIME(0)) 'WAIT',
			CAST(DATEADD(SECOND, (sum(talk_sec)), '00:00:00') AS TIME(0)) 'TALK',
			CAST(DATEADD(SECOND, (sum(dispo_sec)), '00:00:00') AS TIME(0)) 'DISPO',
			CAST(DATEADD(SECOND, (sum(pause_sec)), '00:00:00') AS TIME(0)) 'PAUSA',
			CAST(DATEADD(SECOND, (sum(IIF(sub_status = 'BA', pause_sec, 0))), '00:00:00') AS TIME(0)) 'BA',
			CAST(DATEADD(SECOND, (sum(IIF(sub_status = 'BRK', pause_sec, 0))), '00:00:00') AS TIME(0)) 'BRK',
			CAST(DATEADD(SECOND, (sum(IIF(sub_status = 'CALING', pause_sec, 0))), '00:00:00') AS TIME(0)) 'CALING'
	FROM  DWH.[Vici_Logs].[dbo].vicidial_agent_log
	WHERE user_group NOT IN ('ADMCON', 'EXFORCAP', 'VALID') AND CAST(event_time AS DATE) BETWEEN @FechaInicial AND @FechaFinal
	AND server_ip='192.168.10.72'
	GROUP BY server_ip, CAST(event_time AS DATE), [user], campaign_id, user_group


user_group
event_time
server_ip

	-- SELECT @count = COUNT(*) FROM #tmp_detalle_por_dia;

	
	-- INSERT INTO #tmp_detalle_por_dia 
 --    SELECT  TOP 1 Id,
 --    		server_ip,
	-- 		CAST(event_time AS DATE) 'Fecha',
	-- 		[user],
	-- 		campaign_id,
	-- 		user_group,
	-- 		SUM(IIF(lead_id IS NOT NULL, 1, 0)) 'calls',
	-- FROM  DWH.[Vici_Logs].[dbo].vicidial_agent_log
	-- SELECT @count = COUNT(*) FROM #tmp_detalle_por_dia;

	-- WHILE @count > 0
	-- BEGIN
	--     DECLARE @id INT = (SELECT TOP(1) fecha + hora + importe FROM #tmp_detalle_por_dia);
	--     PRINT 'id' + @id ;
	--     DELETE FROM #tmp_detalle_por_dia WHERE Id= @id
	--     SELECT @count = COUNT(*) FROM #tmp_detalle_por_dia;
	-- END

	-- DROP TABLE #tmp_detalle_por_dia;


END



EXEC get_metricas_y_conexiones_ '20221123', '20221123'



select * from DWH.[Logs].[dbo].TrabajadorSonarh 
