@echo off
echo Syncing storage files to public directory...
xcopy /E /I /Y "storage\app\public\*" "public\storage\"
echo Storage sync complete!
pause