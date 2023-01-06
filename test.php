SELECT server_ip,
       campaign_id,
       Date(event_time)        AS event_date,
       Hour(event_time)        AS interval_hour,
       Sum(CASE WHEN wait_sec > 65000 THEN 0 ELSE wait_sec END) + Sum(CASE WHEN
       talk_sec > 65000 THEN 0 ELSE talk_sec END) + Sum(CASE WHEN dispo_sec >
       65000
       THEN 0 ELSE dispo_sec END) + Sum(CASE WHEN pause_sec > 65000 THEN 0 ELSE
       pause_sec END)          AS agenttime,
       Count(DISTINCT( USER )) AS agents
FROM   vicidial_agent_log
WHERE  Date(event_time) BETWEEN p_fechainicial AND p_fechafinal
GROUP  BY server_ip,
          campaign_id,
          Date(event_time),
          Hour(event_time); 