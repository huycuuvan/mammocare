@echo off
echo Running MySQL script...
"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" -u mammocare_user -pVinawebhp@2024 mammocare_db < update_menu_structure.sql
echo Script completed.
pause
