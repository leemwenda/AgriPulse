@echo off
echo ================================================
echo   AgriPulse Deployment Package Creator
echo ================================================
echo.

REM Check if we're in the right directory
if not exist "artisan" (
    echo ERROR: Please run this script from the AgriPulse root directory
    pause
    exit /b 1
)

echo Step 1: Building frontend assets...
call npm run build
if errorlevel 1 (
    echo WARNING: npm build failed. Make sure Node.js is installed.
)

echo.
echo Step 2: Optimizing Laravel for production...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo.
echo Step 3: Creating deployment folder...
if exist "deploy" rmdir /s /q "deploy"
mkdir deploy
mkdir deploy\htdocs

echo.
echo Step 4: Copying files to deployment folder...

REM Copy public folder contents to htdocs root
xcopy /s /e /y "public\*" "deploy\htdocs\"

REM Copy Laravel folders
xcopy /s /e /y "app" "deploy\htdocs\app\"
xcopy /s /e /y "bootstrap" "deploy\htdocs\bootstrap\"
xcopy /s /e /y "config" "deploy\htdocs\config\"
xcopy /s /e /y "database" "deploy\htdocs\database\"
xcopy /s /e /y "resources" "deploy\htdocs\resources\"
xcopy /s /e /y "routes" "deploy\htdocs\routes\"
xcopy /s /e /y "storage" "deploy\htdocs\storage\"
xcopy /s /e /y "vendor" "deploy\htdocs\vendor\"

REM Copy essential files
copy "artisan" "deploy\htdocs\"
copy "composer.json" "deploy\htdocs\"
copy "composer.lock" "deploy\htdocs\"
copy ".env.production" "deploy\htdocs\.env.example"

echo.
echo Step 5: Creating .htaccess for Laravel...
(
echo ^<IfModule mod_rewrite.c^>
echo     RewriteEngine On
echo.
echo     # Handle Authorization Header
echo     RewriteCond %%{HTTP:Authorization} .
echo     RewriteRule .* - [E=HTTP_AUTHORIZATION:%%{HTTP:Authorization}]
echo.
echo     # Redirect Trailing Slashes If Not A Folder
echo     RewriteCond %%{REQUEST_FILENAME} !-d
echo     RewriteCond %%{REQUEST_URI} ^(.+^)/$
echo     RewriteRule ^^ %%1 [L,R=301]
echo.
echo     # Send Requests To Front Controller
echo     RewriteCond %%{REQUEST_FILENAME} !-d
echo     RewriteCond %%{REQUEST_FILENAME} !-f
echo     RewriteRule ^^ index.php [L]
echo ^</IfModule^>
echo.
echo # Disable directory browsing
echo Options -Indexes
echo.
echo # Protect sensitive files
echo ^<FilesMatch "^\.env"^>
echo     Order allow,deny
echo     Deny from all
echo ^</FilesMatch^>
) > "deploy\htdocs\.htaccess"

echo.
echo ================================================
echo   Deployment Package Created Successfully!
echo ================================================
echo.
echo Your deployment files are in: deploy\htdocs\
echo.
echo NEXT STEPS:
echo 1. Open the 'deploy\htdocs' folder
echo 2. Rename '.env.example' to '.env'
echo 3. Edit '.env' with your hosting database credentials
echo 4. Upload all files to your hosting via FTP
echo 5. Visit yourdomain.com/install.php to set up database
echo 6. Delete install.php and fix-permissions.php after setup
echo.
echo For detailed instructions, see: DEPLOYMENT_GUIDE_FREE_HOSTING.md
echo.
pause
