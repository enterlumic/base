import xlsxwriter
import json
import sys
import os
import datetime

string = os.getcwd()

path = string.replace("public", "" )

workbook = xlsxwriter.Workbook(path+'/storage/app/public/'+sys.argv[1])
worksheet = workbook.add_worksheet('vicidial_closer_log')

worksheet.set_tab_color('green')
worksheet.set_column('A:Z', 25)


with open('storage/app/public/json_data.json') as json_file:
    my_list = json.load(json_file)

format0 = workbook.add_format({ 'align': 'center' })
format1 = workbook.add_format({'bg_color': '#066547', 'color': '#FFFFFF', 'bold': True, 'align': 'center' })
format2 = workbook.add_format({'bg_color': '#c5e0b4', 'align': 'center' })

for row_num, row_data in enumerate(my_list):
    for col_num, col_data in enumerate(row_data):
        worksheet.write(row_num +4, col_num, col_data, format0)
        if row_num +4 == 4 :
            worksheet.write(row_num +4, col_num, col_data, format1)


workbook.close()
