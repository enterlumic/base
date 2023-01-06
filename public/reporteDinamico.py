import xlsxwriter
import json
import sys
import os
import datetime

string = os.getcwd()

path = string.replace("public", "" )

workbook = xlsxwriter.Workbook(path + '/storage/app/public/'+sys.argv[1])
worksheet = workbook.add_worksheet('Carrier_Stats')
worksheet.set_tab_color('red')

worksheet.insert_image('B1', path+'/storage/app/public/logo.png')

with open(path + '/storage/app/public/json_data.json') as json_file:
    my_list = json.load(json_file)

format0 = workbook.add_format({ 'align': 'center' })
format1 = workbook.add_format({'bg_color': '#002060', 'color': '#FFFFFF', 'bold': True, 'align': 'center' })
format2 = workbook.add_format({'bg_color': '#c5e0b4', 'align': 'center' })

for row_num, row_data in enumerate(my_list):
    for col_num, col_data in enumerate(row_data):
        if row_num +4 == 4 or row_num +4 == 16 or row_num +4 == 17 :
            worksheet.write(row_num +4, col_num, col_data, format1)
        else:
            worksheet.write(row_num +4, col_num, col_data, format0)

        if row_num +4 == 16 or row_num +4 == 17 :
            worksheet.write(row_num +4, col_num, col_data, format2)


chart_general = workbook.add_chart({'type': 'line'})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A5',
    'values': '=Carrier_Stats!$B$5:$O$5',
})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A6',
    'values': '=Carrier_Stats!$B$6:$O$6',
})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A7',
    'values': '=Carrier_Stats!$B$7:$O$7',
})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A8',
    'values': '=Carrier_Stats!$B$8:$O$8',
})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A9',
    'values': '=Carrier_Stats!$B$9:$O$9',
})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A9',
    'values': '=Carrier_Stats!$B$9:$O$9',
})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A10',
    'values': '=Carrier_Stats!$B$10:$O$10',
})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A11',
    'values': '=Carrier_Stats!$B$11:$O$11',
})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A12',
    'values': '=Carrier_Stats!$B$8:$O$8',
})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A13',
    'values': '=Carrier_Stats!$B$13:$O$13',
})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A14',
    'values': '=Carrier_Stats!$B$14:$O$14',
})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A15',
    'values': '=Carrier_Stats!$B$15:$O$15',
})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A16',
    'values': '=Carrier_Stats!$B$16:$O$16',
})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A17',
    'values': '=Carrier_Stats!$B$17:$O$17',
})

chart_general.add_series({
    'name':   '=Carrier_Stats!$A18',
    'values': '=Carrier_Stats!$B$18:$O$18',
})

worksheet.insert_chart('A19', chart_general, {'x_offset': 25, 'y_offset': 10})

chart_general_ho_o = workbook.add_chart({'type': 'line'})

chart_general_ho_o.add_series({
    'name':   '=Carrier_Stats!$A17',
    'values': '=Carrier_Stats!$B$17:$O$17',
})

chart_general_ho_o.add_series({
    'name':   '=Carrier_Stats!$A18',
    'values': '=Carrier_Stats!$B$18:$O$18',
})

worksheet.insert_chart('I19', chart_general_ho_o, {'x_offset': 25, 'y_offset': 10})

workbook.close()
