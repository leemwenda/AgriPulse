@echo off
echo ========================================
echo AgriPulse - InfinityFree Deployment
echo ========================================
echo.

echo Step 1: Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo.
echo Step 2: Creating deployment package...

REM Create deployment directory
if exist "infinityfree-deploy" rmdir /s /q infinityfree-deploy
mkdir infinityfree-deploy

echo Copying essential files...

REM Copy public folder (this goes to htdocs root)
xcopy /E /I /Y public infinityfree-deploy\public

REM Copy application files
xcopy /E /I /Y app infinityfree-deploy\app
xcopy /E /I /Y bootstrap infinityfree-deploy\bootstrap
xcopy /E /I /Y config infinityfree-deploy\config
xcopy /E /I /Y database infinityfree-deploy\database
xcopy /E /I /Y resources infinityfree-deploy\resources
xcopy /E /I /Y routes infinityfree-deploy\routes

REM Copy storage structure (empty)
mkdir infinityfree-deploy\storage
mkdir infinityfree-deploy\storage\app
mkdir infinityfree-deploy\storage\framework
mkdir infinityfree-deploy\storage\framework\cache
mkdir infinityfree-deploy\storage\framework\sessions
mkdir infinityfree-deploy\storage\framework\views
mkdir infinityfree-deploy\storage\logs
echo. > infinityfree-deploy\storage\logs\.gitkeep

REM Copy vendor folder
xcopy /E /I /Y vendor infinityfree-deploy\vendor

REM Copy root files
copy /Y artisan infinityfree-deploy\
copy /Y composer.json infinityfree-deploy\
copy /Y composer.lock infinityfree-deploy\
copy /Y package.json infinityfree-deploy\

REM Create .env file for InfinityFree
echo APP_NAME=AgriPulse > infinityfree-deploy\.env
echo APP_ENV=production >> infinityfree-deploy\.env
echo APP_KEY= >> infinityfree-deploy\.env
echo APP_DEBUG=false >> infinityfree-deploy\.env
echo APP_URL=http://yourdomain.infinityfreeapp.com >> infinityfree-deploy\.env
echo. >> infinityfree-deploy\.env
echo LOG_CHANNEL=stack >> infinityfree-deploy\.env
echo LOG_DEPRECATIONS_CHANNEL=null >> infinityfree-deploy\.env
echo LOG_LEVEL=debug >> infinityfree-deploy\.env
echo. >> infinityfree-deploy\.env
echo DB_CONNECTION=mysql >> infinityfree-deploy\.env
echo DB_HOST=your_db_host >> infinityfree-deploy\.env
echo DB_PORT=3306 >> infinityfree-deploy\.env
echo DB_DATABASE=your_db_name >> infinityfree-deploy\.env
echo DB_USERNAME=your_db_user >> infinityfree-deploy\.env
echo DB_PASSWORD=your_db_password >> infinityfree-deploy\.env
echo. >> infinityfree-deploy\.env
echo SESSION_DRIVER=file >> infinityfree-deploy\.env
echo SESSION_LIFETIME=120 >> infinityfree-deploy\.env

echo.
echo Step 3: Creating ZIP file...
powershell Compress-Archive -Path infinityfree-deploy\* -DestinationPath agripulse-infinityfree.zip -Force

echo.
echo ========================================
echo SUCCESS! Deployment package created!
echo ========================================
echo.
echo File created: agripulse-infinityfree.zip
echo Size: 
dir agripulse-infinityfree.zip | find "agripulse-infinityfree.zip"
echo.
echo Next steps:
echo 1. Upload agripulse-infinityfree.zip to InfinityFree
echo 2. Extract it in the htdocs folder
echo 3. Edit .env file with your database details
echo 4. Visit yourdomain.com/install.php
echo.
pause
