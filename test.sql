-- dbo.ReporteProductividadVentasview source

CREATE View [dbo].[ReporteProductividadVentasview] as

SELECT
  event_date
, e.Paterno + ' ' + e.Materno + ' ' +  e.Nombre as [Nombre]
, [user_id]
, e.Departamento
, e.FechaIngreso as [Fecha_Ingreso]
, datediff(DAY,e.FechaIngreso, getdate()) as [Antiguedad]
, cast(sum(talk_sec) as decimal) / (case when sum(agenttime_sec) > 1 then sum(agenttime_sec) else 1 end) as [Talk_Time]
, cast(sum(wait_sec) as decimal) / (case when sum(agenttime_sec) > 1 then sum(agenttime_sec) else 1 end) as [Wait_Time]
, cast(sum(dispo_sec) as decimal) / (case when sum(agenttime_sec) > 1 then sum(agenttime_sec) else 1 end) as [Wrap_Up_Time]
, cast(sum(pause_sec) as decimal) / (case when sum(agenttime_sec) > 1 then sum(agenttime_sec) else 1 end) as [Pause_Up_Time]
, dbo.fn_sec_to_Hmmss( sum(dispo_sec) / (case when sum(CALLS) > 1 then sum (CALLS) else 1 end),'s') as [D_AHT]
, dbo.fn_sec_to_Hmmss( sum(costumer_sec) / (case when sum (CALLS) > 1 then sum (CALLS) else 1 end),'s') as [AHT]
, Sum(  (([B2A] + [I6A] + [J4A] + [E3X] + [Q5I]) / (case when datepart(HH,agenttime) > 1 then datepart(HH,agenttime) else 1 end)) ) as [CPH]
, ( Sum([B2A]) / (case when sum(datepart(HH,agenttime)) > 1 then sum(datepart(HH,agenttime)) else 1 end) ) as [SPH]
, Sum(CALLS) / (case when sum(datepart(HH,agenttime)) > 1 then sum(datepart(HH,agenttime)) else 1 end) as [LLPH]
, Sum(  ( B2A / (case when ([B2A] + [I6A] + [J4A] + [E3X] + [Q5I]) > 1 then ([B2A] + [I6A] + [J4A] + [E3X] + [Q5I]) else 1 end)) ) as [CONV]
, Sum( CALLS ) as [calls]

--APD

--CONTACTS
, Sum([B2A] + [I6A] + [J4A] + [E3X] + [Q5I] + [K3B]) as [Contactos]
, Sum( [B2A]) as [B2A]
, Sum( [I6A]) as [I6A]
, Sum( [J4A]) as [J4A]
, Sum( [E3X]) as [E3X]
, Sum( [Q5I]) as [Q5I]
, Sum( [K3B]) as [K3B]
, cast(Sum([B2A] + [I6A] + [J4A] + [E3X] + [Q5I] + [K3B]) as decimal) / (case when sum(CALLS) > 1 then sum(CALLS) else 1 end) as [PromContactos]

-- COMPLETES
, Sum([W9L] + [O4X] + [L5I] + [J3D] + [C7R] + [Q6W] + [G8K] + [E7U]) as [Completos]
, Sum( [W9L]) as [W9L]
, Sum( [O4X]) as [O4X]
, Sum( [L5I]) as [L5I]
, Sum( [J3D]) as [J3D]
, Sum( [C7R]) as [C7R]
, Sum( [E7U]) as [E7U]
, Sum( [Q6W]) as [Q6W]
, Sum( [G8K]) as [G8K]
, cast(Sum( [W9L]+ [O4X] + [L5I]+ [J3D] + [C7R] + [Q6W] + [G8K]+ [E7U]) as decimal)  / (case when sum(CALLS) > 1 then sum(CALLS) else 1 end) as [PromCompletos]

-- REDIALED
, Sum([PU] + [Z6B] + [E2L] + [L9P] + [D6B] + [V5T] + [NA] + [ALTNUM]) as [Remarcaje]
, Sum( [PU]) as [PU]
, Sum( [Z6B]) as [Z6B]
, Sum( [E2L]) as [E2L]
, Sum( [L9P]) as [L9P]
, Sum( [D6B]) as [D6B]
, Sum( [V5T]) as [V5T]
, Sum( [NA]) as [NA]
, Sum( [ALTNUM]) as [ALTNUM]

, cast(Sum([PU] + [Z6B] + [E2L] + [L9P] + [D6B] + [V5T] + [NA] + [ALTNUM]) as decimal)  / (case when sum(CALLS) > 1 then sum(CALLS) else 1 end) as [PromRemarcajes]

-- APB
, dbo.fn_sec_to_Hmmss(Sum(agenttime_sec),'s') as [agenttime] --Tiempo en Conexión
, dbo.fn_sec_to_Hmmss(Sum(dead_sec ),'s') as [dead]--Llamadas Colgadas
, dbo.fn_sec_to_Hmmss(Sum(costumer_sec),'s') as [costumer] --Llamadas Activas
, dbo.fn_sec_to_Hmmss(Sum(talk_sec),'s') as [talk]--Duracion Llamadas
, dbo.fn_sec_to_Hmmss(Sum(wait_sec),'s') as [wait]--Espera a Llamada
, dbo.fn_sec_to_Hmmss(Sum(dispo_sec),'s') as [dispo]--Tiempo en Dispo
, dbo.fn_sec_to_Hmmss(Sum(login_sec),'s') as [login]--Login
, dbo.fn_sec_to_Hmmss(Sum(jun_sec),'s') as [jun]--Junta
, dbo.fn_sec_to_Hmmss(Sum(andial_sec),'s') as [andial]--Tiempo Muerto
, dbo.fn_sec_to_Hmmss(Sum(ba_sec),'s') as [ba]--Baño
, dbo.fn_sec_to_Hmmss(Sum(brk_sec),'s') as [brk]--Break
, dbo.fn_sec_to_Hmmss(Sum(rea_sec),'s') as [rea]--Reagendar Llamada
, dbo.fn_sec_to_Hmmss(Sum(lagged_sec),'s') as [lagged]--Falla Sistema
, dbo.fn_sec_to_Hmmss(Sum(noncode_sec),'s') as [noncode] --Sin Codigo de Pausa
, dbo.fn_sec_to_Hmmss(Sum(pause_sec),'s') as [pause]--Pausa
, dbo.fn_sec_to_Hmmss((Sum(agenttime_sec) - sum(pause_sec)),'s') as [Horas_Efectivas]
, cast((Sum(agenttime_sec) - Sum(pause_sec)) as decimal)  / (case when (Sum(agenttime_sec)) > 1 then (Sum(agenttime_sec)) else 1 end) as [PromTiempo_Efectivo]

from DWH.Logs.dbo.[ReporteProductividadConcentradoSecondsView] rpcsv
inner join DWH.Logs.dbo.Empleado e on cast(e.IdTrab as nvarchar(10)) = rpcsv.user_id
where 
   
   (
   e.Departamento in 
      (
         'ESTRENA',
         'CLIENTE EXCELENTE DATOS',
         'ESTRENA FORANEO',
         'CLIENTE EXCELENTE VOZ',
         'MSR',
         'MUEVETE POSPAGO',
         'BLACKBERRY DATOS'
      )
   and
   rpcsv.campaign_id not IN ('all')
-- rpcsv.campaign_id IN ('ESTPREDI','ESTRENA','EXCELDAT','EXCELFOR','EXCELVOZ','EXCVOZPR','EXDATAUT','FORANEO','MVTPOS','MVTPPRE','MSR')
   )

Group by  event_date, e.Paterno + ' ' + e.Materno + ' ' +  e.Nombre, [user_id], e.Departamento, e.FechaIngreso;