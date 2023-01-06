import xlsxwriter
import json
import sys
import os
import datetime

string = os.getcwd()

path = string.replace("public", "" )

workbook = xlsxwriter.Workbook(path+'/storage/app/public/'+sys.argv[1])
worksheet1 = workbook.add_worksheet('Desempeño Detalle')

worksheet1.set_tab_color('green')
worksheet1.set_column('A:A', 10)
worksheet1.set_column('B:B', 35)
worksheet1.set_column('C:C', 12)
worksheet1.set_column('D:D', 13)
worksheet1.set_column('F:F', 10)
worksheet1.set_column('G:G', 5)
worksheet1.set_column('H:H', 30)
worksheet1.set_column('I:I', 30)
worksheet1.set_column('J:J', 35)
worksheet1.set_column('K:K', 35)
worksheet1.set_column('L:O', 20)

center  = workbook.add_format({'align': 'center', 'border': 1})
right   = workbook.add_format({'align': 'right', 'border': 1, 'bold': True})
_center = workbook.add_format({'align': 'center', 'border': 1, 'bg_color': '#92d050'})
_right  = workbook.add_format({'align': 'right', 'border': 1, 'bold': True, 'bg_color': '#92d050'})

worksheet1.insert_image('A1', path+'/storage/app/public/logo_tecsa.png',   {'x_scale': 0.5, 'y_scale': 0.5})

with open(path + '/storage/app/public/json_data.json') as json_file:
    my_list = json.load(json_file)

format0 = workbook.add_format({ 'align': 'center', 'border':   1})
format1 = workbook.add_format({'bg_color': '#385724', 'color': '#FFFFFF', 'bold': True, 'align': 'center', 'border':   1, 'valign':   'vcenter', })
format2 = workbook.add_format({'bg_color': '#c5e0b4', 'align': 'center' })

for row_num, row_data in enumerate(my_list):
    for col_num, col_data in enumerate(row_data):
        if row_num == 0:
            worksheet1.write(row_num +4, col_num, col_data, format1)
        else:
            worksheet1.write(row_num +4, col_num, col_data, format0)

workbook.close()
