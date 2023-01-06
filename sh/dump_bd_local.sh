mysql -u u733136234_console -pF4I6^\$BDC-aEonn9 u733136234_console -e "TRUNCATE tbl_debug";mysqldump --routines --triggers -u u733136234_console -pF4I6^\$BDC-aEonn9 u733136234_console > /var/www/html/console/bd.sql;
grep -wrl '' /var/www/html/console/bd.sql | xargs sed -i 's///g';
grep -wrl '' /var/www/html/console/bd.sql | xargs sed -i 's///g';
grep -wrl '' /var/www/html/console/bd.sql | xargs sed -i 's///g';

echo 11111111111111111111111;