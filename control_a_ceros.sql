USE CrmMis

CREATE OR ALTER PROCEDURE get_control_a_ceros_uso_sistema  @FechaInicial DATETIME = ''
                                    , @FechaFinal   DATETIME = ''
AS

    SELECT     rep.[Fecha],
               rep.[User_ID],
               rep.[Calls] ,
               CASE
                          WHEN v.[Interacciones] IS NULL THEN 0
                          ELSE v.[Interacciones]
               END                                       AS [Interacciones] ,
               (v.[Interacciones]/NULLIF(rep.[Calls],0)) AS [%Uso]
    FROM       (
                        SELECT   r.[event_date] AS [Fecha],
                                 r.[user_id]    AS [User_Id],
                                 Sum(r.[calls]) AS [Calls]
                        FROM     reporteproductividadventasview r WITH (nolock)
                        WHERE    [event_date] BETWEEN @FechaInicial AND      @FechaFinal
                        GROUP BY r.[event_date],
                                 r.[user_id],
                                 r.[Contactos] ) AS rep
    INNER JOIN
               (
                        SELECT   Cast(v.[Fecha_Registro] AS DATE) AS [Fecha],
                                 u.usuario                        AS idtrab,
                                 Count(1)                         AS [Interacciones]
                        FROM     [CRM2].[Planes_Ventas].[dbo].[cuentas] v WITH (nolock)
                        JOIN     [CRM2].[Planes_Ventas].[dbo].[Usuarios] u WITH (nolock)
                        ON       u.idusuario = v.idusuario_venta
                        WHERE    Cast(v.[Fecha_Registro] AS DATE) BETWEEN @FechaInicial AND      @FechaFinal
                        AND      v.idtipo_registro = 1
                        AND      (
                                          u.[No_Emp] IS NOT NULL
                                 OR       u.[No_Emp] NOT LIKE '%[a-z]%')
                        GROUP BY Cast(v.[Fecha_Registro] AS DATE),
                                 u.usuario ) AS v
    ON         v.[FECHA] = rep.[Fecha]
    AND        v.[IdTrab] =rep.[user_id]



EXEC get_control_a_ceros_uso_sistema '2022-09-01', '2022-09-01'



select top 1 * from DWH.Logs.dbo.reporteproductividadventasview;