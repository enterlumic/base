import xlsxwriter
import json
import sys
import os
import datetime

string = os.getcwd()

path = string.replace("public", "" )

workbook = xlsxwriter.Workbook(path+'/storage/app/public/'+sys.argv[1])
worksheet1 = workbook.add_worksheet('Cumplimiento')
worksheet1.set_tab_color('green')
worksheet1.set_column('A:A', 2)
worksheet1.set_column('B:B', 15)
worksheet1.set_column('C:C', 10)
worksheet1.set_column('D:D', 13)
worksheet1.set_column('F:F', 3)
worksheet1.set_column('G:J', 13)
worksheet1.set_column('K:K', 3)
worksheet1.set_column('L:M', 13)

center = workbook.add_format({'align': 'center', 'border': 1})
right = workbook.add_format({'align': 'right', 'border': 1, 'bold': True})

_center = workbook.add_format({'align': 'center', 'border': 1, 'bg_color': '#92d050'})
_right = workbook.add_format({'align': 'right', 'border': 1, 'bold': True, 'bg_color': '#92d050'})

worksheet1.insert_image('B4', path+'/storage/app/public/logo_tecsa.png',   {'x_scale': 0.5, 'y_scale': 0.5})

merge_format = workbook.add_format({
    'bold':     True,
    'align':    'center',
    'valign':   'vcenter',
})

worksheet1.merge_range('B1:E3', 'HRS CUMPLIMIENTO PROACTIVAS', merge_format)
worksheet1.merge_range('G1:J3', 'APROVECHAMIENTO DE HRS', merge_format)
# worksheet1.merge_range('B3:B6', '', merge_format)

merge_format = workbook.add_format({
    'bold':     True,
    'border':   1,
    'size':   9,
    'align':    'center',
    'valign':   'vcenter',
})

worksheet1.merge_range('C4:C6', 'HORAS R', merge_format)
worksheet1.merge_range('D4:D6', 'PROMEDIO\n BILLABLE X\n AGENTE', merge_format)
worksheet1.merge_range('E4:E6', 'FALTAS', merge_format)

worksheet1.merge_range('G4:G6', 'TOPE DE HRS X\n DIA', merge_format)
worksheet1.merge_range('H4:H6', 'HRS FACT', merge_format)
worksheet1.merge_range('I4:I6', 'DIFERENCIA\n HRS TOPE/\n HRS FACT', merge_format)
worksheet1.merge_range('J4:J6', '% FACT HRS\n TOPE / HRS\n FACT', merge_format)
worksheet1.merge_range('L4:L6', 'DIFERENCIA\n HRS HC/\n HRS FACT', merge_format)
worksheet1.merge_range('M4:M6', '% FACT \nHRS TOPE\n / HRS FACT\n REALES', merge_format)

with open('storage/app/public/json_data.json') as json_file:
    jsonObject = json.load(json_file)

format0 = workbook.add_format({ 'align': 'center' })
format1 = workbook.add_format({'bg_color': '#002060', 'color': '#FFFFFF', 'bold': True, 'align': 'center' })
format2 = workbook.add_format({'bg_color': '#c5e0b4', 'align': 'center' })

row= 6
for item in jsonObject["table"]:
    row+=1

    if item['horas_r'] == '0.0':
        worksheet1.write('B'+ str(row), item['fecha'], _right)
        worksheet1.write('C'+ str(row), item['horas_r'], _center)
        worksheet1.write('D'+ str(row), item['promedio_billiable_x_agente'], _center)
        worksheet1.write('E'+ str(row), item['faltas'], _center)
        worksheet1.write('G'+ str(row), item['tope_de_hrs_x_dia'], _center)
        worksheet1.write('H'+ str(row), item['hrs_fact'], _center)
        worksheet1.write('I'+ str(row), item['dif_hrs_top'], _center)
        worksheet1.write('J'+ str(row), item['fac_hrs_tope'], _center)
        worksheet1.write('L'+ str(row), item['DIFERENCIA_HRS_HC'], _center)
        worksheet1.write('M'+ str(row), item['FACT_HRS_TOPE__HRS_FACT_REALES'], _center)
        worksheet1.write('K'+ str(row), '', _center)
        worksheet1.write('F'+ str(row), '', _center)
    else:
        worksheet1.write('B'+ str(row), item['fecha'], right)
        worksheet1.write('C'+ str(row), item['horas_r'], center)
        worksheet1.write('D'+ str(row), item['promedio_billiable_x_agente'], center)
        worksheet1.write('E'+ str(row), item['faltas'], center)
        worksheet1.write('G'+ str(row), item['tope_de_hrs_x_dia'], center)
        worksheet1.write('H'+ str(row), item['hrs_fact'], center)
        worksheet1.write('I'+ str(row), item['dif_hrs_top'], center)
        worksheet1.write('J'+ str(row), item['fac_hrs_tope'], center)
        worksheet1.write('L'+ str(row), item['DIFERENCIA_HRS_HC'], center)
        worksheet1.write('M'+ str(row), item['FACT_HRS_TOPE__HRS_FACT_REALES'], center)


# cell_format = workbook.add_format({'bold': True, 'font_color': 'red', 'border': 1})
# worksheet1.write('O7:Q9', 'Cell A1', cell_format)

worksheet1.set_column('O:O', 15)
worksheet1.set_column('P:P', 20)
worksheet1.set_column('Q:Q', 20)

bold = workbook.add_format({'bold': True, 'size': 10})
border = workbook.add_format({'border': 1})
border_center = workbook.add_format({'border': 1, 'align': 'center'})

worksheet1.write('P6', 'Objetivo Mínimo horas', bold)
worksheet1.write('Q6', 'Facturación Mensual', bold)

worksheet1.write('O7', 'Objetivo', border)
worksheet1.write('O8', 'Real', border)
worksheet1.write('O9', 'Diferencia', border)
worksheet1.write('P10', 'Porcentaje', border)

worksheet1.write('P12', 'Objetivo Ideal horas', bold)
worksheet1.write('Q12', 'Facturación Mensual', bold)

worksheet1.write('O13', 'Objetivo', border)
worksheet1.write('O14', 'Real', border)
worksheet1.write('O15', 'Diferencia', border)
worksheet1.write('P16', 'Porcentaje', border)


worksheet1.write('P7', jsonObject['objetivo_minimo']['objetivo_minimo_hrs'], border_center)
worksheet1.write('P8', jsonObject['objetivo_minimo']['real_minimo_hrs'], border_center)
worksheet1.write('P9', jsonObject['objetivo_minimo']['diff_minimo_hrs'], border_center)
worksheet1.write('Q7', jsonObject['objetivo_minimo']['objetivo_minimo_mensual'], border_center)
worksheet1.write('Q8', jsonObject['objetivo_minimo']['real_minimo_facturacion'], border_center)
worksheet1.write('Q9', jsonObject['objetivo_minimo']['diff_minimo_mensual'], border_center)
worksheet1.write('Q9', jsonObject['objetivo_minimo']['diff_minimo_mensual'], border_center)
worksheet1.write('Q10', jsonObject['objetivo_minimo']['porcentaje'], border_center)

worksheet1.write('P13', jsonObject['objetivo_ideal']['objetivo_ideal_hrs'], border_center)
worksheet1.write('P14', jsonObject['objetivo_ideal']['real_minimo_hrs'], border_center)
worksheet1.write('P15', jsonObject['objetivo_ideal']['diff_minimo_hrs'], border_center)
worksheet1.write('Q13', jsonObject['objetivo_ideal']['objetivo_ideal_mensual'], border_center)
worksheet1.write('Q14', jsonObject['objetivo_ideal']['real_minimo_facturacion'], border_center)
worksheet1.write('Q15', jsonObject['objetivo_ideal']['diff_minimo_mensual'], border_center)
worksheet1.write('Q16', jsonObject['objetivo_ideal']['porcentaje'], border_center)

    # "objetivo_ideal": {
    #     "objetivo_ideal_hrs": 31200,
    #     "objetivo_ideal_mensual": "$ 3,001,440.00",
    #     "real_minimo_hrs": "2753",
    #     "real_minimo_facturacion": "$ 264,839.00",
    #     "diff_minimo_hrs": -28447,
    #     "diff_minimo_mensual": "$ -2,998,687.00",
    #     "porcentaje": "11%"
    # }


workbook.close()