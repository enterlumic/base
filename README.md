===============    Template     ===============

https://themesbrand.com/velzon/html/minimal/dashboard-crm.html

===============    Dependencias     ===============

Python
xlsxwriter
crontab -e
sudo timedatectl set-timezone America/Monterrey
cron -e
* cd /var/www/html/mis && php artisan schedule:run >> /dev/null 2>&1

// Para generar imagen desde html
https://pypi.org/project/html2image/
pip install --upgrade html2image

========================================================

Theme

{
	"font_size": 10,
	"ignored_packages":
	[
		"Vintage",
	],
	"color_scheme": "Packages/Agila Theme/Agila Neon Monocyanide.tmTheme",
	"theme": "Adaptive.sublime-theme",
}



