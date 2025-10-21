# PowerShell script to update menu structure
$sqlContent = Get-Content "update_menu_structure.sql" -Raw

# Execute SQL using MySQL Workbench or command line
Write-Host "SQL script created. Please run the following command manually:"
Write-Host "mysql -u mammocare_user -p mammocare_db < update_menu_structure.sql"
Write-Host ""
Write-Host "Or copy and paste the SQL content into MySQL Workbench/phpMyAdmin"
Write-Host ""
Write-Host "SQL Content:"
Write-Host $sqlContent
