@echo off
cd /d C:\xampp\htdocs\clon_app_sedaloreto\clon_app_facturation

:loop
C:\xampp\php\php.exe artisan consumos:calcular-valores
timeout /t 60 /nobreak >nul
goto loop
