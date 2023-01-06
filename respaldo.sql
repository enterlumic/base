CREATE   PROCEDURE get_control_a_ceros  @FechaInicial DATETIME = ''
                                    , @FechaFinal   DATETIME = ''
AS

    DECLARE @DayIni             VARCHAR(2),
            @MonthIni           VARCHAR(2),
            @YearIni            VARCHAR(4),
            @FechaIni           DATE,
            @FechaFin           DATE,
            @TiempoTotal        VARCHAR(20)

    SET @YearIni = DATEPART(yy, GETDATE() - 1)
    SET @FechaFin = GETDATE();

    SELECT    T.IdTrab, T.Paterno + ' ' + T.Materno + ' ' + T.Nombre 'Gestor'
            , CAST(T.FeIngreso AS DATE) 'Ingreso'
            , (CASE WHEN T.Fbaja IS NULL THEN CAST('-' AS VARCHAR(3)) ELSE CAST(YEAR(T.FBaja) AS VARCHAR(4)) + '-' + RIGHT('0' + CAST(MONTH(T.FBaja) AS VARCHAR(2)), 2) + '-' + RIGHT('0' + CAST(DAY(T.FBaja) AS VARCHAR(2)), 2) END) 'Baja'
            , DATEDIFF(D, FeIngreso, (CASE WHEN T.FBaja IS NULL THEN GETDATE() ELSE T.FBaja END)) 'Ant'
            , CASE WHEN RT.Etiqueta IS NULL THEN '-' ELSE RT.Etiqueta END 'Turno'
            , CASE WHEN PT.Rol IS NULL THEN '-' ELSE PT.Rol END 'Rol'
            , P.Descripcion
            , REPLACE(D.Descripcion, 'MUEVETE ', '') 'Departamento'
    FROM SONARH.SonarhNet.dbo.Trabajador T
    LEFT JOIN SONARH.SonarhNet.dbo.Puesto P ON P.Idpuesto = T.IdPuesto
    LEFT JOIN SONARH.SonarhNet.dbo.Depto  D ON D.IdDepto = T.IdDepto
    LEFT JOIN SONARH.SonarhNet.dbo.ProgTurnos PT ON PT.rol = T.Rol AND PT.Vector = DATEPART(dw, GETDATE())
    LEFT JOIN DWH.Logs.dbo.rol_turnos RT ON RT.Rol = PT.rol

    WHERE P.Descripcion LIKE 'rvt%'
    AND T.IdTrab NOT IN('24947', '25590', '19210', '13364', '25721', '24829', '24434', '13149', '17613', '20623', '14438', '24434', '25735', '24067', '13485')
    AND T.Activo = 1
    AND (T.FeIngreso < ISNULL(@FechaFinal, @FechaFin) AND T.FBaja IS NULL OR (T.FBaja < ISNULL(@FechaFinal, @FechaFin) AND T.FBaja > ISNULL(@FechaInicial, @FechaIni)))
    ORDER BY D.Descripcion, T.Paterno + ' ' + T.Materno + ' ' + T.Nombre
    

    
    EXEC get_control_a_ceros '2022-09-01', '2022-09-01'

    
    

    Name         |Value                  |
-------------+-----------------------+
IdTrab       |3603                   |
Nombre       |JESUS ARATH            |
Paterno      |CEDILLO                |
Materno      |MORENO                 |
RFC          |CEMJ041217SC5          |
IdSol        |3603                   |
IdCompania   |1                      |
IdPlanta     |1                      |
IdTipoNomina |1                      |
IdFormaPago  |2                      |
IdCentroT    |1                      |
IdCenCos     |A02809                 |
IdDepto      |CAMP264                |
IdPuesto     |A02809                 |
IdCategoria  |11                     |
IdUbicacion  |1                      |
IdBanco      |0                      |
IdGrado      |0                      |
IdEstado     |19                     |
IdMunicipio  |46                     |
IdZonaEc     |1                      |
Activo       |0                      |
Ajusta141    |0                      |
BonoEsp      |0.00                   |
CalifAnt     |                       |
CalifUlt     |                       |
CategoNva    |0                      |
ChecaTar     |0                      |
Constancia   |0                      |
Cred         |0                      |
CuentaBan    |                       |
CuentaCon    |                       |
CuentaSar    |0.00                   |
CURP         |CEMJ041217HNLDRSB3     |
DirInd       |0                      |
EdoCivil     |0                      |
EstatusIng   |0                      |
FBaja        |2022-02-09 00:00:00.000|
FBajaReal    |                       |
FGraduado    |                       |
FeIngGpo     |2022-02-09 00:00:00.000|
FeIngreso    |2022-02-09 00:00:00.000|
FeModSuel    |2022-02-09 00:00:00.000|
FeNaci       |2004-12-17 00:00:00.000|
FeTermino    |                       |
FModRegPat   |                       |
FModSal      |                       |
FonAho       |0                      |
FPlanta      |                       |
GpoIMSS      |0                      |
ImpVarDia    |0.00                   |
ImpVarInf    |0.00                   |
Motivo       |                       |
Nivel        |0                      |
NumAnter     |0                      |
PctUltA      |0.00                   |
Planta       |0                      |
PremProd     |0                      |
ProcNomn     |1                      |
RegIMSS      |00000000000            |
RegPatron    |19110179918            |
Reingreso    |0                      |
Rol          |0                      |
SalInfAn     |0.00                   |
SalIntInf    |180.03                 |
SalBase      |5167.20                |
SalBaseAn    |0.00                   |
SalDiaAn     |0.00                   |
SalDiaNvo    |172.24                 |
SalDiario    |172.24                 |
SalInfNvo    |0.00                   |
SalIntAn     |0.00                   |
SalIntNvo    |180.03                 |
SalInteg     |180.03                 |
Sexo         |M                      |
Sindicalizado|0                      |
SJReducida   |0                      |
SueProme     |0.00                   |
TipoTrab     |1                      |
Turno        |0                      |
UMF          |1                      |
Utilidad     |0                      |
CostoxHora   |0.00                   |
CostoxHoraAnt|0.00                   |
Horas        |0                      |
HorasAnt     |0                      |
Usuario      |ngarcia                |
FeUltAct     |2022-02-16 00:00:00.000|
IdEdoUMF     |19                     |
CLABE        |                       |
 