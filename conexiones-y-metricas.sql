CREATE PROCEDURE  get_metricas_y_conexiones
	@FechaInicial DATE = '',
	@FechaFinal   DATE = ''
AS
BEGIN
	
	SET NOCOUNT ON;

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

	UNION   

	SELECT  server_ip,
			CAST(event_time  AS DATE) 'Fecha',
			[user],
			campaign_id,
			user_group,
			SUM(IIF(lead_id IS NOT NULL, 1, 0)) 'calls',
			CAST(DATEADD(SECOND, (sum(wait_sec) + sum(talk_sec) +sum(dispo_sec) + sum(pause_sec)), '00:00:00') AS TIME(0)) 'AGENTTIME',
			CAST(DATEADD(SECOND, (sum(wait_sec)), '00:00:00') AS TIME(0)) 'WAIT',
			CAST(DATEADD(SECOND, (sum(talk_sec)), '00:00:00') AS TIME(0)) 'TALK',
			CAST(DATEADD(SECOND, (sum(dispo_sec)), '00:00:00') AS TIME(0)) 'DISPO',
			CAST(DATEADD(SECOND, (sum(pause_sec)), '00:00:00') AS TIME(0)) 'PAUSA',
			CAST(DATEADD(SECOND, (sum(IIF(sub_status ='BA', pause_sec, 0))), '00:00:00') AS TIME(0)) 'BA',
			CAST(DATEADD(SECOND, (sum(IIF(sub_status ='BRK', pause_sec, 0))), '00:00:00') AS TIME(0)) 'BRK',
			CAST(DATEADD(SECOND, (sum(IIF(sub_status ='CALING', pause_sec, 0))), '00:00:00') AS TIME(0)) 'CALING'
	FROM  DWH.[Vici_Logs].[dbo].vicidial_agent_log
	WHERE user_group NOT IN ('ADMCON', 'EXFORCAP', 'VALID') AND campaign_id IN ('VENPOS')
		AND CAST(event_time AS DATE) BETWEEN @FechaInicial AND @FechaFinal
	GROUP BY server_ip, CAST(event_time AS DATE), [user], campaign_id, user_group

END

