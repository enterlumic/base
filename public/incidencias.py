import xlsxwriter
import json
import sys
import os

string = os.getcwd()
 
path = string.replace("public", "" )

workbook = xlsxwriter.Workbook(path+'/storage/app/public/'+sys.argv[1])
worksheet1 = workbook.add_worksheet()

# Add a format. Light red fill with dark red text.
format1 = workbook.add_format({'bg_color': '#FFC7CE',
                               'font_color': '#9C0006'})

# Add a format. Green fill with dark green text.
format2 = workbook.add_format({'bg_color': '#C6EFCE',
                               'font_color': '#006100'})

# Some sample data to run the conditional formatting against.
with open('../storage/app/public/json_data.json') as json_file:
    data = json.load(json_file)
###############################################################################
cell_format = workbook.add_format()

cell_format.set_pattern(1)  # This is optional when using a solid fill.
cell_format.set_bg_color('#ed7d31')
cell_format.set_bold()

worksheet1.write('A1', 'IdTrab', cell_format)
worksheet1.write('B1', 'Gestor', cell_format)
worksheet1.write('C1', 'Ingreso', cell_format)
worksheet1.write('D1', 'Baja', cell_format)
worksheet1.write('E1', 'Ant', cell_format)
worksheet1.write('F1', 'Turno', cell_format)
worksheet1.write('G1', 'Rol', cell_format)
worksheet1.write('H1', 'Descripcion', cell_format)
worksheet1.write('I1', 'Departamento', cell_format)
worksheet1.write('J1', 'Coordinador', cell_format)
worksheet1.write('K1', 'Jefe Piso', cell_format)
worksheet1.write('L1', 'HORAS MES', cell_format)
worksheet1.write('M1', 'TIEMPO EFECTIVO', cell_format)
worksheet1.write('N1', '% TIEMPO EFECTIVO', cell_format)
worksheet1.write('O1', 'SPH MES', cell_format)
worksheet1.write('P1', 'LOGROS MES', cell_format)

worksheet1.set_column('A:K', 30)

for row, row_data in enumerate(data):
    worksheet1.write_row(row + 1, 0, row_data)

workbook.close()

