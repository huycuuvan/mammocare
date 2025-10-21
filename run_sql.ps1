# PowerShell script to run MySQL commands
$sqlFile = "update_menu_structure.sql"
$mysqlPath = "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe"

# Check if MySQL exists in common locations
$possiblePaths = @(
    "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe",
    "C:\Program Files\MySQL\MySQL Server 8.1\bin\mysql.exe", 
    "C:\xampp\mysql\bin\mysql.exe",
    "C:\wamp64\bin\mysql\mysql8.0.31\bin\mysql.exe",
    "mysql.exe"
)

$mysqlExe = $null
foreach ($path in $possiblePaths) {
    if (Test-Path $path) {
        $mysqlExe = $path
        break
    }
}

if ($mysqlExe) {
    Write-Host "Found MySQL at: $mysqlExe"
    Write-Host "Running SQL file: $sqlFile"
    
    # Read SQL content and execute
    $sqlContent = Get-Content $sqlFile -Raw
    
    # Execute using cmd to avoid PowerShell parsing issues
    $cmd = "echo `"$sqlContent`" | `"$mysqlExe`" -u mammocare_user -pVinawebhp@2024 mammocare_db"
    cmd /c $cmd
} else {
    Write-Host "MySQL not found. Please run the SQL manually in MySQL Workbench or phpMyAdmin:"
    Write-Host ""
    Write-Host "SQL Content:"
    Write-Host (Get-Content $sqlFile -Raw)
}
