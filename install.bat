@echo off
echo Installing HimalayaVoyage...

echo Installing PHP dependencies...
call composer install

echo Installing Node dependencies...
call npm install

echo Creating .env file...
if not exist .env (
    copy .env.example .env
    echo .env file created
) else (
    echo .env file already exists
)

echo Generating application key...
call php artisan key:generate

echo Running migrations...
set /p migrate="Do you want to run migrations? (y/n): "
if /i "%migrate%"=="y" call php artisan migrate

echo Seeding database...
set /p seed="Do you want to seed the database? (y/n): "
if /i "%seed%"=="y" call php artisan db:seed

echo Creating storage link...
call php artisan storage:link

echo Compiling assets...
call npm run build

echo.
echo Installation complete!
echo.
echo You can now start the server with: php artisan serve
echo Admin Login: admin@himalayavoyage.com / password123
echo User Login: user@example.com / password123

pause