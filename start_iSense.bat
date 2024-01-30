@echo off

REM Display ASCII art for "iSense" in Terminal 0
echo Terminal 0
echo.
echo   ######  ######## ########     ###    ########  ########
echo  ##    ##    ##    ##     ##   ## ##   ##     ##    ##
echo  ##          ##    ##     ##  ##   ##  ##     ##    ##
echo   ######     ##    ########  ##     ## ########     ##
echo        ##    ##    ##   ##   ######### ##   ##      ##
echo  ##    ##    ##    ##    ##  ##     ## ##    ##     ##
echo   ######     ##    ##     ## ##     ## ##     ##    ##
echo.

REM Start PHP artisan serve in Terminal 1
start cmd /k "echo Terminal 1 && php artisan serve & pause"

REM Start PHP artisan mqtt:subscribe in Terminal 2
start cmd /k "echo Terminal 2 && php artisan mqtt:subscribe & pause"
