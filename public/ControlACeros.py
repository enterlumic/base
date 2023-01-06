import xlsxwriter
import json
import sys
import os
import datetime

string = os.getcwd()
 
path = string.replace("public", "" )

workbook = xlsxwriter.Workbook(path+'/storage/app/public/xx.xlsx')
# workbook = xlsxwriter.Workbook(path+'/storage/app/public/'+sys.argv[1])
worksheet1 = workbook.add_worksheet('Faltas')
worksheet2 = workbook.add_worksheet('Uso del sistema')

# Add a format. Light red fill with dark red text.
format1 = workbook.add_format({'bg_color': '#FFC7CE',
                               'font_color': '#9C0006'})

# Add a format. Green fill with dark green text.
format2 = workbook.add_format({'bg_color': '#C6EFCE',
                               'font_color': '#006100'})

with open('../storage/app/public/json_data_faltas.json') as json_file:
    data1 = json.load(json_file)

with open('../storage/app/public/json_data.json') as json_file:
    data = json.load(json_file)

###############################################################################
cell_format = workbook.add_format()

cell_format.set_pattern(1)  # This is optional when using a solid fill.
cell_format.set_bg_color('#ed7d31')
cell_format.set_bold()

worksheet1.write('B1', 'IdTrab', cell_format)
worksheet1.write('C1', 'Gestor', cell_format)
worksheet1.write('D1', 'Ingreso', cell_format)

worksheet2.write('A1', 'IdTrab', cell_format)
worksheet2.write('B1', 'Gestor', cell_format)
worksheet2.write('C1', 'Ingreso', cell_format)
worksheet2.write('D1', 'Baja', cell_format)
worksheet2.write('E1', 'Ant', cell_format)
worksheet2.write('F1', 'Turno', cell_format)
worksheet2.write('G1', 'Rol', cell_format)
worksheet2.write('H1', 'Descripcion', cell_format)
worksheet2.write('I1', 'Departamento', cell_format)
worksheet2.write('J1', 'Uso Avg', cell_format)
worksheet2.write('K1','Mes' , cell_format)

worksheet1.set_column('A:K', 30)
worksheet2.set_column('A:K', 30)

for row, row_data1 in enumerate(data1):
    worksheet1.write_row(row + 1, 1, row_data1 )
    # x= row + 2;
    # worksheet1.write_array_formula('A'+str(x)+':A'+str(x)+'', '=B'+str(x)+'&D'+str(x)+'')
    # worksheet1.write_array_formula('A'+str(x)+':A'+str(x)+'', '=B'+str(x)+'&RIGHT(D'+str(x)+',LEN(D'+str(x)+')-2)')
    # worksheet1.write_array_formula('A'+str(x)+':A'+str(x)+'', '=B'+str(x)+'&SUBSTITUTE(D'+str(x)+',"\'","")')

formatdict = {'num_format':'mm/dd/yy', 'text_wrap': True , 'hidden': True}
fmt = workbook.add_format(formatdict)
worksheet1.set_column('D2:D2', None, fmt)

for row, row_data in enumerate(data):
    worksheet2.write_row(row + 1, 0, row_data)


worksheet2.set_tab_color('green')
worksheet1.set_tab_color('red')
workbook.close()

